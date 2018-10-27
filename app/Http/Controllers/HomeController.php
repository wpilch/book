<?php
namespace App\Http\Controllers;

use App\Persons;
use Vibrant\Vibrant\Controllers\CrudController as Controller;
use Illuminate\Http\Request;
use Vibrant\Vibrant\Library\VibrantTools;

class HomeController extends Controller
{
    private $force_id_request = true;

    public function __construct(Request $request)
    {
        $model = new Persons();
        $view_prefix = "crud";
        $crud_permissions = $this->setCrudPermissions($request);
        parent::__construct($model, $view_prefix, $crud_permissions);
    }

    private function setCrudPermissions(Request $request){
        $crud_permissions = ['read'];

        return $crud_permissions;
    }

    public function home(Request $request)
    {
        $table_settings = [
            'id' => 'exampleTable',
            'ajax_url' => '/backend/home/crud/listing',
            'available_fields' => '["tytuł","nazwisko","imię", "status",  "telefon", "pokój", "grupa","email"]',
            //optional parameters:
            'hidden_fields' => '["tytuł","status","created_at","updated_at"]',
            'unsortable_fields' => '["telefon"]',
            'filters' => '{"grupa": '.json_encode(Persons::$building_options).'}',
            'include_card_view_toggle' => false,
            'include_export' => true,
            'include_create_btn' => true,
            'include_refresh' => true,
            'order_by' => 'nazwisko',
            'order_direction' => 'asc',
            'create_item_url' => '/person/create',
            'create_btn_label' => 'Dodaj',
            'crud_permissions' => '["read", "create"]',
            'mobile_responsive' => true,
        ];
        return view('home',compact('table_settings'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $title_options = json_encode(Persons::$title_options);
        $building_options = json_encode(Persons::$building_options);
        $status_options = json_encode(Persons::$status_options);
        return view('home.create', compact('title_options','building_options','status_options' ));
    }

    public function store(Request $request)
    {
        $resource  = $this->model;
        foreach($request->except('_token') as $key => $value){
            $resource->{$key}  = $value;
        }
        $resource->save();
        //action processing

        //post-action processing

        $this->postAction(__FUNCTION__, $request, $resource);

        $redirect_url = url('/');
        $message = array('success'=>__('Dodano rekord'));

        return redirect($redirect_url)->with($message);
    }

    public function listing(Request $request)
    {

        //Start query builder. You can start limiting your results here, for example:
        $scope = $this->nested_parameters;
        $scope['accepted'] = 'yes';
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
}
