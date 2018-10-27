<?php
    //backwards compatibility
    if(method_exists('\Vibrant\Vibrant\Library\VibrantTools', 'is_vibrant_package_installed')){
        $is_files_pkg_installed = \Vibrant\Vibrant\Library\VibrantTools::is_vibrant_package_installed('files');
    }else{
        $is_files_pkg_installed = false;
    }

    if(!isset($wrap_class)){
        $wrap_class = '';
    }

    if(!isset($unsortables)){
        $unsortables = [];
    }
    if(!isset($hidden)){
        $hidden = [];
    }
    if(!isset($headers)){
        $headers = [];
    }

    if(!isset($server_request_type)){
        $server_request_type = 'local';
    }else{
        if($server_request_type == 'jwt'){
            if(!isset($jwt_token)){
                abort('500', 'JWT token is requiered.');
            }
        }
    }

    if(!isset($filter_place_in_request)){
        $filter_place_in_request = 'params';
    }

    if(!isset($json_data_field)){
        $json_data_field = 'data';
    }

    if(!isset($filter_all_keyword)){
        $filter_all_keyword = '_all';
    }

    if(!isset($checkbox_behavior)){
        $checkbox_behavior = '';
    }

    if(!isset($include_action_bar)){
        $include_action_bar = false;
    }

    if(!isset($include_columns_toggle)){
        $include_columns_toggle = true;
    }

    if(!isset($include_refresh)){
        $include_refresh = false;
    }

    if(!isset($mobile_responsive)){
        $mobile_responsive = true;
    }

    if(!isset($include_options_dropdown)){
        $include_options_dropdown = false;
    }

    if(!isset($include_export)){
        $include_export = false;
    }else{
        if($include_export && (!isset($export_route_name))){
            if(!isset($export_route)){
                //Requires Files package
                if($is_files_pkg_installed){
                    abort('500', 'Export route is required.');
                }else{
                    $export_route = '';
                }
            }
        }
        if($include_export && (!isset($export_route_parameters))){
            $export_route_parameters = [];
        }
    }

    if(!isset($include_card_view_toggle)){
        $include_card_view_toggle = false;
    }

    $filter_items = [];
    $filter_url = '';
    $filter_query = '';

    if(!empty($filters)){
        foreach($filters as $data_field => $filterOption){
            $filter_items[] = $data_field;
            if($filter_place_in_request == 'url'){
                $filter_url .= "/\"+filter".ucfirst($data_field)."+\"";
            }else{
                $filter_query .= "$data_field=\"+filter".ucfirst($data_field)."+\"&";
            }
        }
    }
    if($server_request_type == 'jwt'){
        $token_param = "token=".$jwt_token;
    }else{
        $token_param = "_token=".csrf_token();
    }
    if(empty($order_by)){
        $order_by = 'updated_at';
    }
    if(empty($order_direction)){
        $order_direction = 'desc';
    }
    if(!isset($actionColumnHtml)){
        $actionColumnHtml = '';
    }
    if(empty($checkbox_groups_by_field)){
        $checkbox_groups_by_field = 'id';
    }
    if(empty($hide_if_own)){
        $hide_if_own = false;
    }
    if($hide_if_own === true && isset(\Auth::user()->$checkbox_groups_by_field)){
       $user_id = \Auth::user()->$checkbox_groups_by_field;
    }else{
        $user_id = '';
    }
    if(!isset($include_create_btn)){
        $include_create_btn = true;
    }
    if(empty($create_btn_label)){
        $create_btn_label = __('vibrant::btn.new');
    }
    if(empty($create_item_url)){
        $include_create_btn = false;
    }
    if(empty($height)){
        $height = '100%';
    }

    $wrapper_id = $table_id.'_Wrapper';
?>

<!-- Bootstrap table setup -->
<script>
    //Globals
    @foreach($filter_items as $filter_item)
        var filter{{ucfirst($filter_item)}} = '{{$filter_all_keyword}}';
    @endforeach
    var url = "{{$ajaxUrl}}{!! htmlspecialchars_decode($filter_url.'?'.$filter_query) !!}{{$token_param}}";
    $table = $('#{{$table_id}}');
    @if($include_action_bar)
        $actionbar = $('#actionbar-{{$table_id}}');
    @endif


    $(document).ready(function($) {
        $table.bootstrapTable({
            url: url,
            search: true,
            height: '{{$height}}',
            pagination: true,
            sidePagination: 'server',
            queryParamsType: '',
            queryParams: function(params) {
                var laravelParams = {
                    page: params.pageNumber,
                    limit: params.pageSize,
                    search: params.searchText,
                    sort_order: params.sortName,
                    sort_direction: params.sortOrder
                };
                return laravelParams;
            },
            dataField: '{{$json_data_field}}',
            showRefresh: @if($include_refresh) true @else false @endif,
            showToggle: @if($include_card_view_toggle) true @else false @endif,
            showColumns: @if($include_columns_toggle) true @else false @endif,
            showExport: @if($include_export) true @else false @endif,
            clickToSelect: false,
            maintainSelected: true,
            getAllSelections: true,
            sortName: '{{$order_by}}',
            sortOrder: '{{$order_direction}}',
            iconSize: 'outline',
            toolbar: '#actionbar-{{$table_id}}',
            mobileResponsive: @if($mobile_responsive) true @else false @endif,
            icons: {
                refresh: 'glyphicon-refresh',
                toggle: 'glyphicon-th-list',
                columns: 'glyphicon-eye-open',
                export: 'glyphicon-file'
            },
            stickyHeader: true,
            onColumnSwitch: function(){
                var hiddenColumnsRaw = $("#{{$table_id}}").bootstrapTable('getHiddenColumns');
                var hiddenColumnsArray = [];
                hiddenColumnsRaw.forEach(function(element) {
                    hiddenColumnsArray.push(element.field);
                });
                var hiddenColumnsString = hiddenColumnsArray.join(',');
                $.post( "{{route('backend.cookies.set')}}", { name: '{{$table_id}}_HiddenColumns', value: hiddenColumnsString, _token: '{{csrf_token()}}'} );
                return false;
            },
            {!! $checkbox_behavior !!}

        });

        //set Export
        setExport();

        //get and set Filter
        setFilter();

        //set Options
        setOptions();

        //set Create Btn
        setCreateBtn();

        //setTableHeight
        setTableHeight();

        //append loading icon
        $('#{{$wrapper_id}} .fixed-table-loading').prepend('<i class="fa fa-circle-o-notch fa-spin"></i>');

    });



    function setExport(isExpanded){
        $exportType = $('#{{$wrapper_id}} .export.btn-group');
        $exportType.addClass('display-flex');
        $exportType.prepend('' +
                '<div id="exp-{{$table_id}}" style="display: inline-block">'+
                '<select class="form-control custom-select" style="">'+
                '<option value="">{{__('vibrant::shared.export_shown')}}</option>'+
                @if($include_checkbox) '<option value="selected">{{__('vibrant::shared.export_selected')}}</option>'+ @endif
                @if($is_files_pkg_installed) '<option value="custom_all">{{__('vibrant::shared.export_all')}}</option>'+ @endif //Requires Files package
                '</select>'+
                '</div>');

        if(isExpanded === true){
            $exportType.wrap("<div class='export-wrap expanded display-flex' style='margin-left: 5px !important; cursor: pointer'></div>");
        }else{
            $exportType.wrap("<div class='export-wrap hide-export display-flex' style='margin-left: 5px !important; cursor: pointer'></div>");
        }


        //Toggle btn
        $exportWrap = $('#{{$wrapper_id}} .export-wrap');
        $exportWrap.prepend('<button class="btn btn-default toggle-export"><i class="icon wb-download"></i></button>');
        $exportToggleBtn = $('#{{$wrapper_id}} .export-wrap .toggle-export');
        $exportToggleBtn.click(function () {
            if($exportWrap.hasClass('expanded')){
                $exportWrap.removeClass('expanded');
                $exportWrap.addClass('hide-export');
            }else{
                $exportWrap.addClass('expanded');
                $exportWrap.removeClass('hide-export');
            }
        });

        $('#exp-{{$table_id}}').find('select').change(function () {
            var filterExpanded = getFilter();
            var exportOption = $(this).val();

            if (exportOption == 'custom_all'){
                $('#exp-{{$table_id}}').siblings($('.btn[title="Export data"]')).hide();
                $('#exp-{{$table_id}}').parent().append('' +
                        '<button class="btn btn-default btn-outline dropdown-toggle waves-effect export-all-dropdown" aria-label="export type" title="Export data" data-toggle="dropdown" type="button">'+
                        '<i class="glyphicon glyphicon-file"></i> <span class="caret"></span></button>'+
                         '<ul class="dropdown-menu" role="menu">' +
                            '<li role="dropdown-item" data-type="csv">' +
                                '<a onclick="exportAllToCsv()">CSV</a>' +
                            '</li>'+
                        '</ul>'+
                        '');

            }else{
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportOption
                });
                setExport(true);
                setFilter(filterExpanded);
                setOptions();
                setCreateBtn();
                setTableHeight();
                $('#{{$wrapper_id}} .fixed-table-loading').prepend('<i class="fa fa-circle-o-notch fa-spin"></i>');
                $('#exp-{{$table_id}} option[value='+$(this).val()+']').attr('selected','selected');
            }
        });
    }

    function getFilter(){
        @if(!empty($filters))
            var hasFilter = false;
            @foreach($filter_items as $filter_item)
                filter{{ucfirst($filter_item)}} = $('#{{$wrapper_id}} .filter-{{$filter_item}}').val();
                if($('#{{$wrapper_id}} .filter-{{$filter_item}}').val() != '{{$filter_all_keyword}}'){
                    hasFilter = true;
                }
            @endforeach
            return(hasFilter);
        @endif
    }

    function setFilter(isExpanded){
        @if(!empty($filters))
        $wraper = $('#{{$wrapper_id}} .columns-right');
        $wraper.prepend(''+
                '<div class="filters-super-wrap mr-5 margin-right-5 display-flex expanded"><button class="btn btn-default toggle-filters"><i class="glyphicon glyphicon-filter"></i></button>'+
                    '<div class="filters-wrap" style="display: none">'+
                        @foreach($filters as $data_field => $filterOptions)
                            @php
                                if(!is_array($filterOptions))
                                {
                                    $filterOptions = array($filterOptions);

                                }
                                if(array_key_exists($data_field, $headers))
                                    $filter_name = $headers[$data_field];
                                else{
                                    if(!empty($locale_prefix)){
                                        $filter_name = ucfirst(__("$locale_prefix.$data_field"));
                                    }
                                    else{
                                        $filter_name = ucfirst($data_field);
                                    }
                                }
                            @endphp
                            '<div class="filter-element" style="display: inline-block;">'+
                                '<select class="filter-{{$data_field}} form-control custom-select" style="border: none; background-color: #f1f6ff; border-radius: 0; height: 2.6em; cursor: pointer;">'+
                                    '<option value="{{$filter_all_keyword}}" selected>-- {{$filter_name}} --</option>'+
                                    @foreach($filterOptions as $itemOption)
                                            '<option value="{{$itemOption}}">{{$itemOption}}</option>'+
                                    @endforeach
                                '</select>'+
                            '</div>'+
                        @endforeach
                    '</div>'+
                '</div>');

        //Post filter on change
        $('#{{$wrapper_id}} .filter-element').change(function(){
            var filterExpanded = getFilter();
            $table.bootstrapTable('refreshOptions', {
                url: "{{$ajaxUrl}}{!! htmlspecialchars_decode($filter_url.'?'.$filter_query) !!}{{$token_param}}"
            });
            setExport();
            setFilter(filterExpanded);
            setOptions();
            setCreateBtn();
            setTableHeight();
            $('#{{$wrapper_id}} .fixed-table-loading').prepend('<i class="fa fa-circle-o-notch fa-spin"></i>');
        });

        //set expanded status
        if(isExpanded === true){
            $('#{{$wrapper_id}} .filters-super-wrap').addClass('expanded');
        }else{
            $('#{{$wrapper_id}} .filters-super-wrap').addClass('expanded');
        }

        //Toggle btn
        $filterToggleBtn = $('#{{$wrapper_id}} .toggle-filters');
        $filterToggleBtn.click(function () {
            if($('#{{$wrapper_id}} .filters-super-wrap').hasClass('expanded')){
                $('#{{$wrapper_id}} .filters-super-wrap').removeClass('expanded');
            }else{
                $('#{{$wrapper_id}} .filters-super-wrap').addClass('expanded');
            }
        });

        //Set filter values
        @foreach($filter_items as $filter_item)
                $('#{{$wrapper_id}} .filter-{{$filter_item}}').val(filter{{ucfirst($filter_item)}});
        @endforeach
        @endif
    }

    function setOptions(){
        $wraper = $('#{{$wrapper_id}} .columns-right');
        @if(isset($options_dropdown) && $include_options_dropdown)
            $wraper.append('<div class="dropdown">'+
                '<button type="button" class="btn btn-default dropdown-toggle ml-5" id="options-{{$table_id}}" data-toggle="dropdown" aria-expanded="true">'+
                '<i class="icon wb-settings"></i>'+
                '</button>'+
                    '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="options-{{$table_id}}" role="menu">'+
                        {!! $options_dropdown !!}
                    '</div>'+
                '</div>');
        @endif
    }

    function setCreateBtn(){
        $wraper = $('#{{$wrapper_id}} .columns-right');
        @if(!empty($create_item_url) && ($include_create_btn === true) )
            $wraper.append('<div class="">'+
                '<a href="{{$create_item_url}}" class="form-action-create btn btn-primary ml-1"><i class="icon wb-plus mr-5 margin-right-5"></i><span class="">{{$create_btn_label}}</span></button>'+
            '</div>');
        @endif
    }

    function setTableHeight(){
        @if($height == '100%')
        $('#{{$wrapper_id}} .fixed-table-container').addClass('p-0');
        @else
        $('#{{$wrapper_id}} .fixed-table-container').removeClass('p-0');
        @endif
    }

    //Requires Files package
    @if($is_files_pkg_installed)
    function exportAllToCsv(){
        @if($include_export)
            var url = '{{route($export_route_name, $export_route_parameters)}}';
            var params = {
                _token: '{{csrf_token()}}'
            };
            postJS(url, params);
        @endif
    }
    @endif

    @if(!(isset($custom_action_column) && $custom_action_column))
        function actionColumnFormatter(value, row, index) {
            let dropup = (index > 3) ? '' : '';
            @if($hide_if_own === true)
            let hideIfOwn = (row.{{$checkbox_groups_by_field}} === '{{$user_id}}') ? 'hide' : '';
            @else
            let hideIfOwn = '';
            @endif
            let actionColumnHtml = `
                <div class="btn-group `+dropup+`" role="group">
                <button type="button" class="btn btn-icon btn-sm btn-light dropdown-toggle no-carat btn-round" id="actionColumnDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="icon md-more-vert" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionColumnDropdown" role="menu">
                    {!! $actionColumnHtml !!}
                </div>
                `;
            return [actionColumnHtml].join('');
        }
    @endif

</script>
<!-- end Bootstrap table setup -->

