<?php
/**
 * Tablable trait.
 *
 * Trait class to build html tables from any Laravel model
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Traits;

trait Tablable
{
    /**
     * Table attributes.
     */
    public static $filter_all_keyword = '_all';
    protected $default_pagination_size = 10;
    protected $max_pagination_size = 100;

    /**
     * Enable filters
     *
     * @param $filters_array
     * @param null $query
     * @return $this|null
     */
    public function filterBy($filters_array, $query = null)
    {
        if(empty($query)){
            $query = self::select($this->availableTableFields());
        }

        foreach ($filters_array as $parameter => $value){
            $query = $query->where( $parameter , '=', $value);
        }

        return $query;
    }

    /**
     * Enable searches
     *
     * @param null $query
     * @param $keywords
     * @return $this|null
     */
    public function searchBy($keywords, $query = null)
    {
        if(empty($query)){
            $query = self::select($this->availableTableFields());
        }

        // Keyword
        if (!empty(trim($keywords))) {
            foreach (explode(' ', trim($keywords)) as $keyword) {
                $query = $query->where(function ($q) use ($keyword) {
                    foreach ($this->searchable_fields as $searchable_field) {
                        $q = $q->orwhere($searchable_field, 'like', '%' . $keyword . '%');

                    }
                });
            }
        }

        return $query;
    }

    /**
     * Enable searches and query's
     *
     * @param $query
     * @param null $sort_order
     * @param string $sort_direction
     * @param null $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function doQuery($query, $limit = null, $sort_order = null, $sort_direction = 'asc', $force_id_request = false){
        if(empty($query)){
            $query = self::select($this->availableTableFields());
        }

        //Sort
        if(!empty($sort_order)){
            list($sort_order, $query) = $this->beforeSort($sort_order, $query);
            $query = $query->orderBy($sort_order, $sort_direction);
        }

        //Paginate
        if(empty($limit)){
            $limit = $this->default_pagination_size;
        }
        if($limit > $this->max_pagination_size){
            $limit = $this->max_pagination_size;
        }

        //if forced id request
        $query = $query->addSelect($this->getTable().".id");

        return $query->distinct()->paginate($limit);

    }

    /**
     * Pre-processing sorting
     *
     * @param $query
     * @param $sort_order
     * @return array
     */
    public function beforeSort($sort_order, $query){
        //pre-processing both $sort_order and $query here
        return ([$sort_order, $query]);
    }

    /**
     * Table configuration
     *
     * @return array
     */
    public function tableFields(){
        $available = $this->available_fields;
        $unsortables = $this->unsortable_fields;
        $hidden = $this->hidden_fields;

        return (array($available,$unsortables,$hidden));
    }

    /**
     * Filters configuration
     *
     * @return array
     */
    public function tableFilters(){

        //
        //Override this in your actual model if want filters enabled.
        //
        //$filters['data_field'] = [array of options];
        //
        //Ej.
        //Gender Filter
        //$filters['gender'] = ['male', 'female'];

        $filters = null;

        return ($filters);
    }

    public function availableTableFields(){
        $appendedFields = (isset($this->appends)) ? $this->appends : [];
        $fieldsUsedByAppendedFields = (isset($this->fields_used_by_appends)) ? $this->fields_used_by_appends : [];
        $queryFields = array_merge(array_diff($this->available_fields, $appendedFields), $fieldsUsedByAppendedFields);
        $result = array_map(function($field){
            return $this->getTable().'.'.$field;
        }, $queryFields);
        return $result;
    }
}
