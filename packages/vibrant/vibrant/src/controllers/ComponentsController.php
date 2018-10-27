<?php
/**
 * ComponentsController class.
 *
 * Controller class that handles the controller manager UI. It parses the phpDoc block of
 * a Laravel Component to json parameters that the UI understands.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Vibrant\Vibrant\Library\VibrantTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ComponentsController extends Controller
{
    /**
     * Show the components dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show = ($request->has('show')) ? $request->show : null;
        $components_by_type = VibrantTools::get_registered_components()['components'];
        $components_paths_json = json_encode(VibrantTools::get_registered_components()['paths']);
        $components_json = json_encode($components_by_type);
        return view('vibrant::modules.components.home')->with(compact('components_by_type', 'components_json', 'components_paths_json', 'show'));
    }

    /**
     * Preview of a blade component.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $request->validate([
           'blade_path' => 'required',
           'params' => 'required'
        ]);
        $params = json_decode($request->params, true);
        if(empty($params)){
            $params = [];
        }
        $blade_path = $request->blade_path;
        $blade_file_path = View::make($blade_path)->getPath();
        $component = VibrantTools::parseComponentInfo($blade_file_path);

        $directive = $component['meta']['directive'];
        //getting slots out of params
        $slots = [];
        foreach($params as $key => $param){
            if(substr($key, 0, 6) == '_slot_'){
                $slots[substr($key, 6)] = $param;
                unset($params[$key]);
            }
        }

        $validationRules = [];
        foreach ($component['params'] as $component_param){
            //set rules
            $rule = '';
            if($component_param['required']){
                $rule = 'required';
            }
            if(!empty($component_param['validation'])){
                if(!empty($rule)){
                    $rule .= '|';
                }
                $rule .= $component_param['validation'];
            }
            if(!empty($rule)){
                $validationRules[$component_param['variable']] = $rule;
            }

            //processing param according to type
            if($component_param['type'] === 'bool'){
                if(!empty($params[$component_param['variable']] )){
                    $params[$component_param['variable']] = ($params[$component_param['variable']] == 'true' || $params[$component_param['variable']] == '1') ? true : false;
                }
            }

        }

        $validator = Validator::make($params, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        return view('vibrant::modules.components.preview')->with(compact(
            'directive',
            'blade_path',
            'params',
            'slots'
        ));
    }

    /**
     * Response with blade component info in Json format
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComponentInfo(Request $request){
        $request->validate([
           'blade_path' => 'required',
        ]);
        $blade_file_path = View::make($request->blade_path)->getPath();
        return response()->json(VibrantTools::parseComponentInfo($blade_file_path));
    }

    /**
     * Catch request for preview of a test blade Form component.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function catchRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site' => 'required|url',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $method = $request->method();
        $params = $request->all();
        return response()->json(compact('method', 'params'));
    }


}
