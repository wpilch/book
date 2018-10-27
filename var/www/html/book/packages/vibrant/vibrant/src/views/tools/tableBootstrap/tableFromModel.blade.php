@php
/**
*   Defaults
**/

    //$include_checkbox - adds a column to the left with a checkbox for every row
    if(!isset($include_checkbox_column)){
        $include_checkbox_column = false;
        $include_action_bar = false;
        $checkbox_groups_by_field = '';
    }else{
        //$include_action_bar - shows a set of action buttons at the top of the table when a checkbox is selected
        //if set to true you need to use slot 'action_bar_buttons' to specify buttons to display and define js actions for each of them
        if(!isset($include_action_bar)){
            $include_action_bar = true;
        }
        //$checkbox_groups_by_field - an array of values form this field is created when rows are checkboxed, the array stored as html data in element 'actionbar'
        //Default is uid, but any available field (including Id) can be used
        if(!isset($checkbox_groups_by_field)){
            $checkbox_groups_by_field = 'uid';
        }
    }

    //$include_action_column - adds a column to the right with a 'options' button that opens a drop-down menu
    //if set to true you need to use slot 'action_column_buttons' and define actions with html anchors or using js method 'window.actionColumnEvents'
    if(!isset($include_action_column)){
        $include_action_column = false;
    }

    //$custom_action_column - you can define your own 'actionColumnFormatter' js function at the view
    if(!isset($custom_action_column)){
        $custom_action_column = false;
    }

    //$locale_prefix - sets the lang file/namespace to use for translations
    if(!isset($locale_prefix)){
        $locale_prefix = 'Vibrant::shared';
    }

    //$filters - Pass filters array as defined in Model
    if(!isset($filters)){
        $filters = [];
    }
    if(!isset($filter_all_keyword)){
        $filter_all_keyword = '_all';
    }

    //$aja_url - Mandatory. Sets the url that lists the resource element
    //$table_id - Mandatory.
@endphp

<div class="panel border-thick fadeIn-onLoad">
    <div class="panel-body pt-10 pb-0">
        @component('vibrant::tools.tableBootstrap.html',[
            'table_id' => $table_id,
            'fields_available' => $available,
            'fields_unsortable' => $unsortables,
            'fields_hidden' => $hidden,
            'include_checkbox' => $include_checkbox_column,
            'include_action_bar' => $include_action_bar,
            'include_action_column' => $include_action_column,
            'locale_prefix' => $locale_prefix,
        ])
            @if($include_action_bar)
                @slot('action_buttons')
                    {!! $action_bar_buttons !!}
                @endslot
            @endif
        @endcomponent
    </div>
</div>

@push('styles')
    @include('vibrant::partials.bootstrapTables._styles')
@endpush

@push('scripts')
    @include('vibrant::partials.bootstrapTables._scripts')
    @component('vibrant::tools.tableBootstrap.js',[
        'table_id' => $table_id,
        'ajaxUrl' => $ajax_url,
        'include_checkbox' => $include_checkbox_column,
        'checkbox_groups_by_field' => $checkbox_groups_by_field,
        'include_action_bar' => $include_action_bar,
        'include_action_column' => $include_action_column,
        'custom_action_column' => $custom_action_column,
        'filters' => $filters,
        'filter_all_keyword' => $filter_all_keyword,
        'filter_place_in_request' => 'params',
        'height' => 542,
        'include_card_view_toggle' => true,
        'locale_prefix' => $locale_prefix
    ])
        @if($include_action_column)
            @slot('actionColumnHtml')
                {!! $action_column_buttons !!}
            @endslot
        @endif
        @if($include_checkbox_column)
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
    @if($include_checkbox_column)
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
@endpush

