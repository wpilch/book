<?php

    //Required:
    // table_id  - string
    // data_fields - array

    //Optional:
    // include_action_buttons -boolean
    // wrap_class - string
    // unsortables - array
    // hidden - array
    // headers - array ej. $header['data_field'] = custom_column_header
    // locale_prefix

    if(!isset($include_checkbox)){
        $include_checkbox = true;
    }
    if(!isset($include_action_column)){
        $include_action_column = false;
    }

    if(!isset($wrap_class)){
        $wrap_class = '';
    }
    if(!isset($include_action_bar)){
        $include_action_bar = false;
    }
    if(!isset($fields_unsortable)){
        $fields_unsortable = [];
    }
    if(!isset($fields_hidden)){
        $fields_hidden = [];
    }
    if(!isset($headers)){
        $headers = [];
    }
    $wrapper_id = $table_id.'_Wrapper';
?>
<div id="{{$wrapper_id}}" class="@if($include_action_column)table-with-action-column @endif {{$wrap_class}}" style="position: relative">
    @if($include_action_bar === true)
        <div class="" id="actionbar-{{$table_id}}" role="group" style="opacity: 0; visibility: hidden; transition: all 500ms;">
            {{$action_buttons}}
        </div>
    @endif
    <table id="{{$table_id}}" data-mobile-responsive="true" class="table-striped table-hover">
        <thead>
        <tr>
            @if(!($include_checkbox === false))
            <th data-checkbox="true"></th>
            @endif
            @foreach($fields_available as $data_field)
                <th data-field="{{$data_field}}" @if(!in_array($data_field, $fields_unsortable)) data-sortable="true" @endif @if(in_array($data_field, $fields_hidden)) data-visible="false" @endif>
                    @if(array_key_exists($data_field, $headers))
                        {{$headers[$data_field]}}
                    @else
                        @if(!empty($locale_prefix))
                            {{ucfirst(__("$locale_prefix.$data_field"))}}
                        @else
                            {{ucfirst( strtolower($data_field) )}}
                        @endif
                    @endif
                </th>
            @endforeach
            @if($include_action_column === true)
                <th class="action-column" data-formatter="actionColumnFormatter" data-events="actionColumnEvents" ></th>
            @endif
        </tr>
        </thead>
    </table>
</div>
