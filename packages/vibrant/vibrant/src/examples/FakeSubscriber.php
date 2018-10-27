<?php
/**
 * FakeSubscriber class.
 *
 * Model class for testing vibrant's tablable functionality.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Examples;

use Illuminate\Database\Eloquent\Model;
use Vibrant\Vibrant\Traits\Tablable;

class FakeSubscriber extends Model
{
    use Tablable;

    protected $fillable = ['uid', 'first_name', 'last_name', 'email', 'gender', 'dob', 'phone', 'lang', 'status', 'created_at', 'updated_at'];
    public static $rules = [
        'gender' => 'required',
        'last_name' => 'required'
    ];

    /**
     * REQUIRED TABLE PROPERTIES
     * */
    protected $available_fields = ['uid', 'first_name', 'last_name', 'email', 'gender', 'dob', 'phone', 'status', 'created_at', 'updated_at'];
    protected $searchable_fields = ['uid', 'first_name', 'last_name', 'email', 'phone', 'status' ];
    protected $unsortable_fields = ['phone'];
    protected $hidden_fields = ['created_at', 'updated_at'];
    /**
     * END REQUIRED TABLE PROPERTIES
     **/

    /**
     * OPTIONAL TABLE CUSTOM METHODS
     */
    /**
     * Filters settings, if want filters enabled.
    *
     * @return mixed
     */
    public function tableFilters(){
        $filters['status'] = ['active', 'inactive', 'blocked'];
        return ($filters);
    }

    /**
     * Custom filter query, if needed or in case you use appended attributes in your table filters array
     */
    /*public function filterBy($filters_array, $query = null)
    {
        if(empty($query)){
            //start query, for example:
            //$query = self::select($this->availableTableFields());
        }
        //then build the query according to the received filters
        //for example:
        foreach ($filters_array as $parameter => $value){
            switch ($parameter){
                case 'some_appended_attribute':
                    $query = $query
                        //join the table of the appended attribute, for example:
                        ->leftJoin('external_table', 'external_table.fake_subscribers_id', '=' , 'fake_subscribers.id')
                        //make the query using the column in the external table that corresponds to the filter field,
                        //assuming for example that the filter field is column 'name' of the external table:
                        ->where( 'external_table.name' , '=', $value);
                    break;
                default:
                    $query = $query->where( $parameter , '=', $value);
                    break;
            }
        }
        //then return the query object
        return $query;
    }
    */
    /**
     * Custom searches, if needed or in case you use appended attributes in your searchable_fields array
     */
    /*public function searchBy($keywords, $query = null)
    {
        if(empty($query)){
            //if there is not query yet start one, for example:
            $query = self::select($this->availableTableFields());
        }

        // Split the search entries
        if (!empty(trim($keywords))) {
            foreach (explode(' ', trim($keywords)) as $keyword) {
                $query = $query->where(function ($q) use ($keyword) {
                    foreach ($this->searchable_fields as $searchable_field) {
                        //switch the query building depending on each searchable field
                        switch($searchable_field) {
                            case 'some_appended_attribute':
                                //join the table of the appended attribute, for example:
                                $q = $q->leftJoin('external_table', 'external_table.fake_subscribers_id', '=', 'fake_subscribers.id');
                                //make the query using the columns in the external table that corresponds to the searchable field,
                                //assuming for example that the searchable field is column 'name' of the external table:
                                $q = $q->orwhere("external_table.name", 'like', '%' . $keyword . '%');
                                break;
                            default:
                                $q = $q->orwhere($searchable_field, 'like', '%' . $keyword . '%');
                                break;
                        }
                    }
                });
            }
        }
        return $query;
    }*/
    /**
     * Custom sort pre-processing, if needed
     */
    /*public function beforeSort($sort_order, $query){
        //pre-processing both $sort_order and $query here
        //for example:
        switch ($sort_order){
            //imagine you are sorting by an appended attribute
            case 'users.some_appended_attribute':
                //then we have to translate that to an attribute that actually exists in the table
                $sort_order = 'fake_subscribers.status';
                break;
            default: break;
        }
        return ([$sort_order, $query]);
    }*/
    /**
     * END OPTIONAL TABLE CUSTOM METHODS
     */

    /**
     * EXAMPLE OF A MCV FORM
     **/
    public $form_fields = [
        'first_name' => ['row' => 'new', 'col_class' => 'col-sm-6', 'required' => true ],
        'last_name' => ['row' => 'same', 'col_class' => 'col-sm-6' ],
        'email' => ['row' => 'new', 'input' => 'email', 'col_class' => 'col-sm-8', 'required' => true ],
        'phone'=> ['row' => 'same', 'col_class' => 'col-sm-4' ],
        'gender'=> ['row' => 'new', 'col_class' => 'col-sm-4', 'input' => 'select',
            'items' => [
                ['label' => 'male', 'value' => 'male' ],
                ['label' => 'female', 'value' => 'female' ]
            ]
        ],
        'dob'=> ['row' => 'same', 'col_class' => 'col-sm-4', 'input' => 'datepicker', 'placeholder' => 'yyyy-mm-dd' ],
        'status'=> ['row' => 'same', 'col_class' => 'col-sm-4', 'input' => 'select',
            'items' => [
                ['label' => 'active', 'value' => 'active'],
                ['label' => 'inactive', 'value' => 'inactive'],
                ['label' => 'blocked', 'value' => 'blocked'],
            ]
        ],
        'uid'=>['input' => 'range']
    ];

    /**
     * Find item by uid.
     *
     * @return object
     */
    public static function findByUid($uid)
    {
        return self::where('uid', '=', $uid)->first();
    }
    /* Your model class code */
}

