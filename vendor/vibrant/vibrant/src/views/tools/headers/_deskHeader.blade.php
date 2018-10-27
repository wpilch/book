<?php
    $layout = null;
    if(isset($select_handler) && !empty($select_handler)){
        $layout = 'options_select';
    }

    if(!isset($type) || empty($type)){
        $type = 'headerWithNoRow';
    }
?>
@component("vibrant::components.layouts.$type",['page_title' => $page_title, 'layout' => $layout])
    @slot('breadcrumb')
        <ol class="breadcrumb">
            @php
                $path = \Request::path();
                $resource_url = '';
                $path_array = explode('/',$path);
                $i = 1;
                $resourcesTotal = count($path_array);
                foreach ($path_array as $resource){
                    //Jump the 'Backend'
                    if($i > 1){
                        $resource_url .= "/$resource";
                        $resource_snaked = snake_case($resource);
                        if( $i == $resourcesTotal ) {
                            if( isset($includeCurrent) && ($includeCurrent === true) ){
                                echo '<li class="breadcrumb-item active">'.ucfirst(__("$package_tag::$app_name.$resource_snaked")).'</li>';
                            }
                        }else{
                            if( isset($ignore_resource) && ($ignore_resource === true) ) {
                                if($i != ($resourcesTotal-1)){
                                    if( ($i == ($resourcesTotal-2)) && isset($replace_last_resource)){
                                        $resource_snaked = $replace_last_resource['resourceName'];
                                        echo '<li class="breadcrumb-item"><a href="'.route($replace_last_resource['routeName'],$resource).'">'.ucfirst(__("$package_tag::$app_name.$resource_snaked")).'</a></li>';
                                    }
                                    else{
                                        echo '<li class="breadcrumb-item"><a href="'.url('backend'.$resource_url).'">'.ucfirst(__("$package_tag::$app_name.$resource_snaked")).'</a></li>';
                                    }
                                }
                            }
                            else{
                                if( isset($replace_last_resource) && ($i == ($resourcesTotal-1))){
                                    $resource_snaked = $replace_last_resource['resourceName'];
                                    echo '<li class="breadcrumb-item"><a href="'.route($replace_last_resource['routeName'],$resource).'">'.ucfirst(__("$package_tag::$app_name.$resource_snaked")).'</a></li>';
                                }
                                else{
                                    echo '<li class="breadcrumb-item"><a href="'.url('backend'.$resource_url).'">'.ucfirst(__("$package_tag::$app_name.$resource_snaked")).'</a></li>';
                                }
                            }
                        }
                    }
                    $i++;
                }
            @endphp
        </ol>
    @endslot
    @if(isset($back_btn) && !empty($back_btn))
        <a href="{{$back_btn}}" class="btn btn-back btn-round mr-5">
            <i class="icon md-chevron-left" aria-hidden="true"></i>
            <span class="text">{{__('vibrant::btn.back')}}</span>
        </a>
    @endif
    @if(isset($custom_buttons) && !empty($custom_buttons))
        {!! $custom_buttons !!}
    @endif
    @if(isset($include_button) && $include_button === true)
    <button @if(isset($btn_action)) onclick="window.location.href = '{{$btn_action}}'" @elseif(isset($btn_onclick)) onclick="{{$btn_onclick}}" @endif type="button" class="btn @if(isset($btn_style))btn-{{$btn_style}}@else btn-primary @endif btn-round waves-effect waves-light waves-round @if(isset($btn_classes)){{$btn_classes}}@endif">
        @if(isset($btn_icon)) <i class="icon {{$btn_icon}}" aria-hidden="true"></i> @endif
        <span class="text">{{$btn_text}}</span>
    </button>
    @endif
    @if(isset($select_handler) && !empty($select_handler))
        @slot('options_select')

        <div class="select-in-header-wrapper @if(isset($select_handler['wrapper_classes'])) {{$select_handler['wrapper_classes']}} @endif">
            <form @if(isset($select_handler['form_id'])) id="{{$select_handler['form_id']}}" @endif>
                @php
                    $label = (isset($select_handler['label'])) ? $select_handler['label'] : '';
                    $select_id = $select_handler['select_id'];
                    $select_name = (isset($select_handler['select_name'])) ? $select_handler['select_name'] : $select_id;
                    $select_options = $select_handler['select_options'];
                    $select_value = (isset($select_handler['select_value'])) ? $select_handler['select_value'] : '';
                    $select_style = (isset($select_handler['select_style'])) ? $select_handler['select_style'] : 'default';
                @endphp

                @component('vibrant::components.forms.horizontal.bootstrapSelect', [
                    'id' => $select_id,
                    'name' => $select_name,
                    'options' => $select_options,
                    'value' => $select_value,
                    'label' => $label,
                    'style' => $select_style,
                    'group_classes' => 'm-0',
                    'label_classes' => 'm-0 pb-0 text-right'
                ])@endcomponent
            </form>
        </div>
        @endslot
    @endif


@endcomponent


