<?php
/**
 * CrudController class.
 *
 * Controller class designed to serve as parent of other controllers to enable them
 * for CRUD actions related to a given model.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Controllers;

use Illuminate\Database\Eloquent\Model;
use Vibrant\Vibrant\Library\VibrantTools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    protected $locale_prefix;
    protected $crud_permissions;
    protected $table_height;
    protected $model;
    protected $view_prefix;
    protected $class_name;
    protected $namespace;
    protected $rest_base_url;
    protected $available_permissions = ['create','read','update','delete'];
    protected $crud_by_uid = false;
    protected $find_method = 'find';
    protected $find_by_field = 'id';
    protected $nested_parameters;
    protected $nested_parameters_except_last;
    protected $force_module_name;

    private $permissions;
    private $force_id_request = true;

    public function __construct(Model $model = null, $view_prefix = null, $crud_permissions = null, $nested_parameters = [])
    {
        $this->model = $model;
        $this->view_prefix = $view_prefix;
        $this->crud_permissions = $crud_permissions;
        $this->nested_parameters = $nested_parameters;
        $this->nested_parameters_except_last = $nested_parameters;
        if(count($this->nested_parameters_except_last) > 1){ array_pop($this->nested_parameters_except_last); };
        $this->class_name = substr(class_basename(get_class($this)), 0, -10);
        $this->namespace = "\\".get_class($this);
        $this->rest_base_url = VibrantTools::cleanUrl(action($this->namespace.'@index', $this->nested_parameters_except_last));
        $this->permissions =  ($this->crud_permissions === null) ? $this->available_permissions : array_intersect($this->crud_permissions, $this->available_permissions);
        $this->find_method = ($this->crud_by_uid === true) ? 'findByUid' : $this->find_method;
        $this->find_by_field = ($this->crud_by_uid === true) ? 'uid' : $this->find_by_field;
        $this->force_id_request = ($this->find_by_field === 'id');
    }

    /**
     * Display a listing of Resources.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //validations and access control
        $this->validationAndAccess(__FUNCTION__, $request);

        //init
        $table_name = $this->class_name.'_Table';

        //handle cookie
        $preferredHiddenCols = VibrantTools::getHiddenColumnsFromCookie($table_name);

        //settings to pass to the view
        $ajax_url = VibrantTools::cleanUrl(action($this->namespace.'@listing', $this->nested_parameters_except_last));
        $create_item_url =VibrantTools::cleanUrl(action($this->namespace.'@create', $this->nested_parameters));
        $rest_base_url = $this->rest_base_url;
        $locale_prefix = $this->locale_prefix;
        $crud_permissions = $this->permissions;
        $checkbox_groups_by_field = $this->find_by_field;
        $height = $this->table_height;
        $table_settings = array_merge(compact(
            'table_name',
            'ajax_url',
            'locale_prefix',
            'create_item_url',
            'rest_base_url',
            'crud_permissions',
            'checkbox_groups_by_field',
            'height'),
            VibrantTools::getTableSettingsFromModel($this->model, $preferredHiddenCols)
        );

        return view($this->view_prefix.'.index', compact('table_settings'))->with(['nested_parameters' => $this->nested_parameters, 'force_module_name' => $this->force_module_name]);
    }

    /**
     * Get list of Resources accepting parameters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function listing(Request $request)
    {
        //validations and access control
        $this->validationAndAccess(__FUNCTION__, $request);

        //Start query builder. You can start limiting your results here, for example:
        $scope = $this->nested_parameters;
        if(empty($scope)){
            $query = '';
        }else{
            $query = $this->model->select($this->model->availableTableFields());
            foreach($scope as $field => $value){
                $query = (!empty($value)) ? $query->where($field,'=',$value) : $query;
            }
        }

        //Get resources list using our query builder function, just to pass the tablable model, the json request from the table view and optionally, a initial query object.
        $query_results = VibrantTools::getListFromModel($this->model, $request, $this->force_id_request, $query);

        return response()->json($query_results);
    }

    /**
     * Show the form for creating a new Resource of the model.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validations and access control
        $this->validationAndAccess(__FUNCTION__, $request);

        //catch errors
        $errors = null;
        if ($request->session()->has('errors')) {
            $errors = $request->session()->get('errors');
        }

        //settings to pass to the view
        $form_id = $this->class_name.'_CreateForm';
        $form_action = VibrantTools::cleanUrl(action($this->namespace.'@store', $this->nested_parameters));
        $cancel_link = $this->rest_base_url;
        $locale_prefix = $this->locale_prefix;
        $fields = VibrantTools::getCreateFormFieldsFromModel($this->model, $errors, $this->nested_parameters);
        $form_settings = array_merge(compact('form_id', 'form_action', 'fields', 'cancel_link', 'locale_prefix'));

        return view($this->view_prefix.'.create', compact('form_settings'))->with(['nested_parameters' => $this->nested_parameters, 'force_module_name' => $this->force_module_name]);
    }

    /**
     * Store new Resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        //pre-action processing
        $request = $this->validationAndAccess(__FUNCTION__, $request);

        //action processing
        $resource = $this->model::create($request->except('_token'));

        //post-action processing

        $this->postAction(__FUNCTION__, $request, $resource);

        $redirect_url = $this->rest_base_url;
        $message = array('success'=>__('vibrant::shared.element_created'));

        return redirect($redirect_url)->with($message);
    }

    /**
     * Show the form for editing a Resource.
     *
     * @param Request $request
     * @param  string|integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(count($this->nested_parameters) > 0){
            $id = end($this->nested_parameters);
            reset($this->nested_parameters);
        }

        //validations and access control
        $this->validationAndAccess(__FUNCTION__, $request);

        //catch errors
        $errors = null;
        if ($request->session()->has('errors')) {
            $errors = $request->session()->get('errors');
        }

        //init
        $findByField = $this->find_by_field;
        $findMethod = $this->find_method;
        $resource = $this->model::$findMethod($id);
        if(!is_object($resource)){
            abort(500, 'Resource not found');
        }

        //settings to pass to the view
        $form_id = $this->class_name.'_EditForm'; //the id of the html form
        $form_action = VibrantTools::cleanUrl(action($this->namespace.'@update', array_merge([$findByField => $resource->$findByField], $this->nested_parameters_except_last)));
        $cancel_link = $this->rest_base_url;
        $locale_prefix = $this->locale_prefix;
        $method = "PATCH";
        $fields = VibrantTools::getEditFormFieldsFromModel($resource, $errors);
        $form_settings = array_merge(compact('form_id', 'form_action', 'method', 'fields', 'cancel_link', 'locale_prefix'));

        //post-action processing
        $this->postAction(__FUNCTION__, $request);

        return view($this->view_prefix.'.edit', compact('form_settings'))->with(['nested_parameters' => $this->nested_parameters,  'force_module_name' => $this->force_module_name]);
    }

    /**
     * Update Resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        if(count($this->nested_parameters) > 0){
            $id = end($this->nested_parameters);
            reset($this->nested_parameters);
        }
        $this->validationAndAccess(__FUNCTION__, $request, $id);

        //init
        $findMethod = $this->find_method;
        $resource = $this->model::$findMethod($id);
        if(!is_object($resource)){
            abort(500, 'Resource not found');
        }

        $resource->update($request->except(['_token', '_method']));

        //post-action processing
        $this->postAction(__FUNCTION__, $request);

        $redirect_url = $this->rest_base_url;
        $message = array('success'=>__('vibrant::shared.changes_saved'));
        return redirect($redirect_url)->with($message);
    }

    /**
     * Remove Resource from storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(count($this->nested_parameters) > 0){
            $id = end($this->nested_parameters);
            reset($this->nested_parameters);
        }

        $this->validationAndAccess(__FUNCTION__, $request, $id);

        //init
        $findMethod = $this->find_method;
        $resource = $this->model::$findMethod($id);
        if(!is_object($resource)){
            abort(500, 'Resource not found');
        }

        $resource->delete();

        //post-action processing
        $this->postAction(__FUNCTION__, $request, $resource);

        $redirect_url = $this->rest_base_url;
        $message = array('success'=>trans_choice('vibrant::shared.element_deleted', 1));
        return redirect($redirect_url)->with($message);
    }

    /**
     * Delete one or more Resources at once.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $this->validationAndAccess(__FUNCTION__, $request);

        $items = explode(',', $request->input('items'));

        if(count($items) == 0){
            $message = array('error'=>'No elements were selected.');
            return redirect()->action($this->namespace.'@index')->with($message);
        }

        if ($request->input('items')) {
            $resources =  $this->model::whereIn($this->find_by_field, $items)->get();
            foreach ($resources as $resource) {
                if(is_object($resource)){
                    //post-action processing
                    $id = $resource->$this->find_by_field;
                    $this->beforeDestroy($request, $id);
                    //action
                    $resource->delete();
                    //post-action processing
                    $this->postAction(__FUNCTION__, $request, $resource);
                }
            }
        }

        $redirect_url = $this->rest_base_url;
        $message = array( 'success' => trans_choice('vibrant::shared.element_deleted', count($items) ) );
        return redirect($redirect_url)->with($message);
    }

    /**
     *  Single point of control for validation, access authorization and pre-action processing
     *
     * @param null $method
     * @param Request $request
     * @param null $id
     * @return bool|Request
     */
    public function validationAndAccess($method = null, Request $request, $id = null){
        //Pre-processing for all actions
        $request = $this->beforeAny($request, $method);
        if(get_class($request) != 'Illuminate\Http\Request'){
            abort('500', "Your implementation of 'beforeAny' method must return a 'Illuminate\Http\Request' class");
        };

        //Get rules from model (if exists)
        $rules = VibrantTools::getRulesFromModel($this->model, $method);

        //Get permissions from controller
        $permissions = $this->permissions;

        //Process the request
        switch($method){
            case 'index':
            case 'listing':
                if(!in_array('read', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $this->beforeRead($request);
                break;
            case 'create':
                if(!in_array('create', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $this->beforeCreate($request);
                break;
            case 'store':
                if(!in_array('create', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $request->validate($rules);
                $this->beforeStore($request);
                break;
            case 'edit':
                if(!in_array('update', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $this->beforeEdit($request);
                break;
            case 'update':
                if(!in_array('update', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $request->validate($rules);
                $this->beforeUpdate($request, $id);
                break;
            case 'destroy':
                if(!in_array('delete', $permissions)){
                    abort(500, 'Not Authorized');
                }
                $this->beforeDestroy($request, $id);
                break;
            case 'bulkDelete':
                if(!in_array('delete', $permissions)){
                    abort(500, 'Not Authorized');
                }
                //beforeDestroy is called inside the bulkDelete method so we can get the id of every deleted resource
                break;
            default:
                break;
        }
        return $request;
    }

    public function beforeAny(Request $request, $method){return $request;}
    public function beforeRead(Request $request){return false;}
    public function beforeCreate(Request $request){return false;}
    public function beforeStore(Request $request){return false;}
    public function beforeEdit(Request $request){return false;}
    public function beforeUpdate(Request $request, $id){return false;}
    public function beforeDestroy(Request $request, $id){return false;}

    /**
     * Single point of control for post-action processing
     * @param null $method
     * @param Request $request
     * @param $resource
     */
    public function postAction($method = null, Request $request, $resource = null){
        $this->afterAny($request, $resource, $method);
        switch($method){
            case 'store':
                $this->afterStore($request, $resource);
                break;
            case 'update':
                $this->afterUpdate($request, $resource);
                break;
            case 'destroy':
            case 'bulkDelete':
                $this->afterDestroy($request, $resource);
                break;
            default:
                break;
        }
    }

    public function afterAny(Request $request, $resource, $method){return false;}
    public function afterStore(Request $request, $resource){return false;}
    public function afterUpdate(Request $request, $resource){return false;}
    public function afterDestroy(Request $request, $resource){return false;}
}
