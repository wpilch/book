<?php
namespace App\Http\Controllers;

use App\Persons;
use Vibrant\Vibrant\Controllers\CrudController as Controller;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $model = new Persons();
        $view_prefix = "crud";

        parent::__construct($model, $view_prefix);
    }

    public function bulkDelete(Request $request)
    {
        $this->validationAndAccess(__FUNCTION__, $request);

        $items = explode(',', $request->input('items'));

        if(count($items) == 0){
            $message = array('error'=>'No elements were selected.');
            return redirect()->action($this->namespace.'@index')->with($message);
        }

        if ($request->input('items')) {
            $this->model::whereIn($this->find_by_field, $items)->delete();
        }

        $redirect_url = $this->rest_base_url;
        $message = array( 'success' => trans_choice('vibrant::shared.element_deleted', count($items) ) );
        return redirect($redirect_url)->with($message);
    }

    public function store(Request $request)
    {

        //pre-action processing
        $request = $this->validationAndAccess(__FUNCTION__, $request);

        $resource  = $this->model;
        foreach($request->except('_token') as $key => $value){
            $resource->{$key}  = $value;
        }
        $resource->save();
        //action processing

        //post-action processing

        $this->postAction(__FUNCTION__, $request, $resource);

        $redirect_url = $this->rest_base_url;
        $message = array('success'=>__('vibrant::shared.element_created'));

        return redirect($redirect_url)->with($message);
    }

    public function accept(Request $request, $id)
    {
        //init
        $findMethod = $this->find_method;
        $resource = $this->model::$findMethod($id);
        if(!is_object($resource)){
            abort(500, 'Resource not found');
        }

        $resource->accepted = 'yes';
        $resource->save();

        //post-action processing
        $this->postAction(__FUNCTION__, $request);
        $redirect_url = $this->rest_base_url;
        $message = array('success'=>'Itam accepted successfully');

        return redirect($redirect_url)->with($message);
    }

    public function bulkAccept(Request $request)
    {

        $items = explode(',', $request->input('items'));

        if(count($items) == 0){
            $message = array('error'=>'No elements were selected.');
            return redirect()->action($this->namespace.'@index')->with($message);
        }

        if ($request->input('items')) {
            $this->model::whereIn($this->find_by_field, $items)->update(array('accepted' => 'yes'));
        }

        $redirect_url = $this->rest_base_url;
        $message = array( 'success' => 'Itams accepted successfully' );
        return redirect($redirect_url)->with($message);
    }
}
