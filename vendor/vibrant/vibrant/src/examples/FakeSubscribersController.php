<?php
/**
 * FakeSubscribersController class.
 *
 * Controller class for the FakeSubscriber resource.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Examples;

use Vibrant\Vibrant\Controllers\CrudController as Controller;
use Illuminate\Http\Request;

class FakeSubscribersController extends Controller
{
    //protected $crud_by_uid = true; //Use Uid field instead of Id for all CRUD actions, it needs: 'findByUid' method defined at your model and 'uid' field included in available_fields array
    //protected $locale_prefix = ''; //If defined, table labels and placeholders will use translation with this prefix, otherwise fields names will be used as labels and placeholders
    protected $table_height = 620; //table height in pixels, if zero or not defined height will be 100%

    public function __construct(Request $request)
    {
        $model = new FakeSubscriber(); //Data model
        $view_prefix = "vibrant::examples.crud"; //Prefix for the path of the CRUD blade views
        $crud_permissions = $this->setCrudPermissions($request);
        parent::__construct($model, $view_prefix, $crud_permissions);
    }

    /**
     * Returns an array with the granted permissions. A sub-array of ['create','read','update','delete']
     * @param Request $request
     * @return array
     */
    private function setCrudPermissions(Request $request){
        $crud_permissions = [];
        //Grant/remove CRUD permissions based on $request information and other context
        //Replace with you logic
        if (true) {
            $crud_permissions = ['create','read','update','delete'];
        }
        return $crud_permissions;
    }
}
