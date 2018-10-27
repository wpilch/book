<?php
/**
 * vibTable component
 *
 * Component for fast building of powerful ajax data tables based on the <a class="link" href="https://github.com/wenzhixin/bootstrap-table" target="_blank">bootstrap-table plugin.</a>
 *
 * @group MCV Components
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 *
 * @alias VibTable
 * @managed
 *
 * @slot action_bar_buttons
 * @slot action_column_buttons
 *
 * @param string $id Id of the table element. You can also use $table_name to set Id |e=exampleTable
 * @param string $ajax_url Url that responses requests on the model with json rows|e=/backend/examples/crud/listing
 * @param string:json $available_fields Json or array including those fields of the model that are available in the table|e=["uid", "first_name", "last_name", "email", "gender", "dob", "phone", "status", "created_at", "updated_at"]
 * @param string:json $hidden_fields Json or array including those available fields that are hidden by default in the table|o|e=["created_at", "updated_at"]
 * @param string:json $unsortable_fields Json or array including those available fields that have not sortable capability in the table|o|e=["phone"]
 * @param string:json $filters Json or array of fields that can be used as filters in the table|o|e={"status":["active","inactive","blocked"]}
 * @param bool:boolean $include_card_view_toggle Shows a button to toggle between card and table view|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $include_export Include export options|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $include_create_btn Whether or not to include 'create item' button, default is true|o|d=true|i=switch:{yes,no}|e=true
 * @param string $create_item_url Url of the form to create item, required if want to include 'create item' button |o
 * @param string $create_btn_label Label for the 'create item' button |o|e=New
 * @param array:json $crud_permissions Json or array with allowed CRUD actions, if not present all actions will be allowed|o|i=textarea|d=["create","read","update","delete"]|e=["create","read","update","delete"]
 * @param bool:boolean $mobile_responsive Auto toggle between card and table view depending on screen size|o|d=true|i=switch:{yes,no}|e=false
 * @param bool:boolean $include_checkbox_column Adds a column to the left with a checkbox for every row|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $include_action_bar Shows a set of action buttons at the top of the table when a checkbox is selected.
 If set to true you need to use slot 'action_bar_buttons' to specify buttons to display and define js actions for each of them. A delete button is provided as default example|o|d=false|i=switch:{yes,no}|e=false
 * @param string $checkbox_groups_by_field Default is id, but any available field can be used. An array of values form this field is created when rows are checkboxed, the array stored as html data in element 'actionbar'|o
 * @param bool:boolean $include_action_column Adds a column to the right with a 'options' button that opens a drop-down menu.
 if set to true you need to use slot 'action_column_buttons' and define actions with html anchors or using js method 'window.actionColumnEvents'. An example is provided by default|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $custom_action_column Turn this on to change the look of the action column. To do this define your own 'actionColumnFormatter' js function at the view|o|d=false|i=switch:{yes,no}|e=false
 * @param string $height Height of table in pixels, leave it 0 or empty to auto-size|o|d=542|e=542|i=number:{0,1200,1}
 * @param string $locale_prefix Sets the lang file/namespace to use for translations|o
 * @param string $order_by Sets the field to sort by (default is 'updated_at')|o|d=updated_at
 * @param string $order_direction Sets the direction to order (default is 'desc')|o|d=desc|i=select:{asc,desc}
 * @param string $class Custom class for this component|o|
 *
 * @link /backend/examples/crud CRUD implementation
 */

if(isset($table_name)){
    $id = $table_name;
}
if(isset($available_fields) && !is_array($available_fields)){
    $available_fields = json_decode($available_fields, true);
}
if(isset($hidden_fields) && !is_array($hidden_fields)){
    $hidden_fields = json_decode($hidden_fields, true);
}
if(isset($unsortable_fields) && !is_array($unsortable_fields)){
    $unsortable_fields = json_decode($unsortable_fields, true);
}
if(isset($filters) && !is_array($filters)){
    $filters = json_decode($filters, true);
}
if(empty($checkbox_groups_by_field)){
    $checkbox_groups_by_field = 'id';
}
if(!isset($include_checkbox_column)){
    $include_checkbox_column = false;
    $include_action_bar = false;
}else{
    if(!isset($include_action_bar)){
        $include_action_bar = true;
    }
}
if(!isset($include_action_column)){
    $include_action_column = false;
}
if(!isset($custom_action_column)){
    $custom_action_column = '';
}
if(!isset($include_card_view_toggle)){
    $include_card_view_toggle = true;
}
if(!isset($include_export)){
    $include_export = true;
}
if(!isset($mobile_responsive)){
    $mobile_responsive = true;
}
if(!isset($locale_prefix)){
    $locale_prefix = '';
}
if(!isset($filters)){
    $filters = null;
}
if(empty($filter_all_keyword)){
    $filter_all_keyword = '_all';
}
if(empty($height)){
    $height = '0';
}
if(!isset($class)){
    $class = '';
}
//action bar, action columns & crud settings
if(!isset($include_create_btn)){
    $include_create_btn = true;
}
if(empty($create_btn_label)){
    $create_btn_label = __('vibrant::btn.new');
}
if(empty($create_item_url)){
    $create_item_url = '';
    $include_create_btn = false;
}
if(!isset($action_bar_buttons)){
    $action_bar_buttons = '';
}else{
    $include_action_bar = true;
    $include_checkbox_column = true;
}
if(!isset($order_by)){
    $order_by = 'updated_at';
}
if(!isset($order_direction)){
    $order_direction = 'desc';
}
//Permissions
if(!isset($crud_permissions)){
    $crud_permissions = ['create','read','update','delete'];
}elseif(!is_array($crud_permissions)){
    $crud_permissions = json_decode($crud_permissions, true);
    if(!is_array($crud_permissions)){
        $crud_permissions = [];
    };
}else{
    $crud_permissions = array_intersect($crud_permissions, ['create','read','update','delete']);
}
//CRUD action - Create
if(!in_array('create', $crud_permissions)){
    $include_create_btn = false;
    $create_item_url = '';
}
//CRUD action - Bulk Delete
if(!empty($rest_base_url) && in_array('delete', $crud_permissions)){
    $include_action_bar = true;
    $include_checkbox_column = true;
    $action_bar_buttons .= '<button class="action-bulk-delete btn btn-secondary"><i class="icon md-delete" aria-hidden="true"></i></button>';
}
if(!isset($action_column_buttons)){
    $action_column_buttons = '';
}else{
    $include_action_column = true;
}
//CRUD action - Update, Delete
if(!empty($rest_base_url) && (in_array('update', $crud_permissions) || in_array('delete', $crud_permissions)) ){
    $include_action_column = true;
    if(!empty($action_column_buttons)){
        $action_column_buttons .= '<div class="dropdown-divider"></div>';
    }
    if(in_array('update', $crud_permissions)){
        $action_column_buttons .= '<a href="'.$rest_base_url.'/`+row.'.$checkbox_groups_by_field.'+`/edit" class="dropdown-item action-edit" role="menuitem"><i class="icon md-edit mr-2" aria-hidden="true"></i>'.__('vibrant::btn.edit').'</a>';
    }
    if(in_array('delete', $crud_permissions)){
        $action_column_buttons .= '<button class="dropdown-item action-destroy" role="menuitem"><i class="icon md-delete mr-2" aria-hidden="true"></i>'.__('vibrant::btn.delete').'</button>';
    }
}
?>

@bring('bs_table@1.12.1')
@bring('vibrant_interactions')

<div class="fadeIn-onLoad {{$class}}">
    @component('vibrant::tools.tableBootstrap.html',[
        'table_id' => $id,
        'fields_available' => $available_fields,
        'fields_unsortable' => $unsortable_fields,
        'fields_hidden' => $hidden_fields,
        'include_checkbox' => $include_checkbox_column,
        'include_action_bar' => $include_action_bar,
        'include_action_column' => $include_action_column,
        'locale_prefix' => $locale_prefix
    ])
        @if($include_action_bar)
            @slot('action_buttons')
                {!! $action_bar_buttons !!}
            @endslot
        @endif
    @endcomponent
</div>

@push('scripts')
    @component('vibrant::tools.tableBootstrap.js',[
        'table_id' => $id,
        'ajaxUrl' => $ajax_url,
        'include_checkbox' => $include_checkbox_column,
        'checkbox_groups_by_field' => $checkbox_groups_by_field,
        'include_action_bar' => $include_action_bar,
        'include_action_column' => $include_action_column,
        'custom_action_column' => $custom_action_column,
        'filters' => $filters,
        'filter_all_keyword' => $filter_all_keyword,
        'include_card_view_toggle' => $include_card_view_toggle,
        'include_create_btn' => $include_create_btn,
        'create_item_url' => $create_item_url,
        'create_btn_label' => $create_btn_label,
        'mobile_responsive' => $mobile_responsive,
        'include_export' => $include_export,
        'filter_place_in_request' => 'params',
        'height' => $height,
        'locale_prefix' => $locale_prefix,
        'order_by' => $order_by,
        'order_direction' => $order_direction,
    ])
        @if($include_action_column)
            @slot('actionColumnHtml')
                {!! $action_column_buttons !!}
            @endslot
        @endif
        @if($include_checkbox_column && $include_action_bar)
            @slot('checkbox_behavior')
                onCheck: function(){
                var selected_rows = $table.bootstrapTable('getSelections');
                setGroupActions(selected_rows);
                $actionbar.addClass('visible');
                },
                onUncheck: function(){
                var selected_rows = $table.bootstrapTable('getSelections');
                setGroupActions(selected_rows);
                if(selected_rows.length == 0){
                $actionbar.removeClass('visible');
                }
                },
                onCheckAll: function(){
                var selected_rows = $table.bootstrapTable('getSelections');
                setGroupActions(selected_rows);
                $actionbar.addClass('visible');
                },
                onUncheckAll: function(){
                $actionbar.removeClass('visible');
                }
            @endslot
        @endif
    @endcomponent
    @if($include_checkbox_column && $include_action_bar)
        <script>
            function setGroupActions(selected_rows){
                if(selected_rows.length > 0 ){
                    getGroupActions(selected_rows);
                }
            }
            function getGroupActions(selected_rows){
                var items = [];

                selected_rows.forEach(function(item){
                    items.push(item['{{$checkbox_groups_by_field}}']);
                });

                $actionbar.attr('data-items', items.toString());
            }
        </script>
    @endif
    @if(!empty($rest_base_url) && !empty($crud_permissions)  )
    <script>
        if(window.actionColumnEvents == null) {
            window.actionColumnEvents = {}
        }
        //Behavior of crud buttons in the action column
        @if(in_array('delete', $crud_permissions))
            window.actionColumnEvents['click .action-destroy'] = function (e, value, row) {
                alertify.okBtn("{{__('vibrant::btn.delete')}}").cancelBtn("{{__('vibrant::btn.cancel')}}")
                .confirm("<strong>{{__('vibrant::btn.delete_element_confirmation')}}</strong>", function () {
                    let url = '{{$rest_base_url}}/'+row.{{$checkbox_groups_by_field}};
                    let param = {
                        _token: '{{csrf_token()}}',
                        _method: 'DELETE'
                    };
                    postJS(url, param);
                });
            };
        @endif
        //Behavior of the crud buttons in the action bar
        @if(in_array('delete', $crud_permissions))
            $('.action-bulk-delete').click(function(){
                alertify.okBtn("{{__('vibrant::btn.delete')}}").cancelBtn("{{__('vibrant::btn.cancel')}}")
                .confirm("<strong>{{__('vibrant::btn.delete_items_confirmation')}}</strong>", function () {
                    let items = $actionbar.attr('data-items');
                    let url = '{{$rest_base_url}}'+'/bulkDelete';
                    let parameters = {
                        items: items,
                        _token: '{{csrf_token()}}'
                    };
                    postJS(url, parameters);
                });
            });
        @endif
    </script>
    @endif
@endpush
