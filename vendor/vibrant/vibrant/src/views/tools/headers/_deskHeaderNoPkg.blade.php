<?php
if(!isset($main_app_name)){
    $main_app_name = 'Backend';
    $main_app_route = '';
}
$layout = null;
if(isset($select_handler) && !empty($select_handler)){
    $layout = 'options_select';
}

?>
@component('vibrant::tools.layouts.headerWithNoRow',['page_title' => $page_title, 'layout' => $layout])
    @slot('breadcrumb')
    <ol class="breadcrumb">
        @php
            $path = \Request::path();
            $resource_url = '';
            $path_array = explode('/',$path);
            $i = 1;
            $resourcesTotal = count($path_array);
            $app_route = (empty($main_app_route)) ? '' : route($main_app_route);
            if(!empty($main_app_name)){
                echo '<li class="breadcrumb-item"><a href="'.$app_route.'">'.ucfirst($main_app_name).'</a></li>';
            }
            foreach ($path_array as $resource){
                //Jump the 'Backend'
                if($i > 1){
                    $resource_url .= "/$resource";
                    $resource_snaked = snake_case($resource);
                    if( $i == $resourcesTotal) {
                        echo '<li class="breadcrumb-item active">'.ucfirst(__("$package_tag::$package_name.$resource_snaked")).'</li>';
                    }else{
                        if( !(isset($ignore_resource) && ($ignore_resource === true) && ($i == ($resourcesTotal-1))) ) {
                            echo '<li class="breadcrumb-item"><a href="'.url('backend'.$resource_url).'">'.ucfirst(__("$package_tag::$package_name.$resource_snaked")).'</a></li>';
                        }

                    }
                }
                $i++;
            }
        @endphp
    </ol>
    @endslot
@if(isset($include_button) && $include_button === true)
<button onclick="window.location.href = '{{$btn_action}}'" type="button" class="action-create-category btn @if(isset($btn_color))btn-{{$btn_color}}@else btn-primary @endif btn-round waves-effect waves-light waves-round">
    <i class="icon {{$btn_icon}}" aria-hidden="true"></i>
    <span class="text hidden-sm-down">{{$btn_text}}</span>
</button>
@endif
@endcomponent


