<?php
/**
 * vibForm component
 *
 * Component for building bootstrap form's.
 *
 * @group MCV Components
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 *
 * @alias VibForm
 * @managed
 *
 * @slot default
 * @slot custom_buttons
 *
 * @param string $form_id Form Id Id|e=generalForm
 * @param array:json $fields Json or array including Input(e. Text, Select, etc) and every desired parameter|o|i=textarea|e=[{"row":"new","col_class":"col-sm-4", "input":"text",
 * "name":"name","label":"Name","placeholder":"Name","text_help":"help here"},
 * {"row":"same","col_class":"col-sm-8","input":"email","name":"email","label":"Email","placeholder":"Email","text_help":"help here email", "required":true},
 * {"input":"url","name":"site","label":"Site","placeholder":"Site"},
 * {"input":"password","name":"password","label":"Password","placeholder":"Password"},
 * {"input":"select","name":"Select","label":"Example of select","placehoder":"Select one option","items":[{"label":"Option one","value":"single 1"},{"label":"Option two", "value":"single 2"}],"value":"single 2"},
 * {"input":"multiselect","name":"MultiSelect","label":"Example of multi-select","items":[{"label":"Option one","value":"multi 1"},{"label":"Option two", "value":"multi 2"}],"values":["multi 1","multi 2"]},
 * {"input":"radio","name":"radios","label":"Radio","items":[{"label":"Option one","value":"1"},{"label":"Option two", "value":"Option two","disabled":"true"},{"label":"Option three", "value":"dummy value", "checked":"true"}]},
 * {"input":"checkbox","name":"checkbox","label":"Checkbox"}]
 * @param array:json $buttons Json or array including Alignment(left,right,center -optional-), Order(inverse -optional-), Submit/Cancel/Reset(label, btn_class, disabled, link(for cancel only) -optional-). If this parameter is not present, the form will show the submit button only |o|i=textarea|e={"submit":{"label":"Submit","btn_class":"btn-primary"},
 * "cancel":{"label":"Cancel","btn_class":"btn-light","link":""}}
 * @param string $cancel_link Defines the url to go when the cancel button is clicked, also makes the cancel button to show. Overridden by the $buttons array |o
 * @param string $cancel_label Defines the label of the cancel button. Overridden by the $buttons array |o
 * @param string $submit_label Defines the label of the submit button. Overridden by the $buttons array |o
 * @param string $buttons_alignment Possible values: right, left or center. Overridden by the $buttons array |o
 * @param string $buttons_order Possible values: inverse. Overridden by the $buttons array |o
 * @param string $method Http method for the form submit, default is post|o|d=post|i=select:{get,post,put,path,delete}
 * @param string $form_action Url for the form submit|o||i=textarea|e=/backend/components/catchRequest
 * @param bool:boolean $btn_loading_animated Whether or not to show loading animation in submit button, default is true|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $make_ajax_request Whether or not to make the request asynchronously, default is false|o|d=false|i=switch:{yes,no}|e=true
 * @param bool:boolean $include_crsf_token Whether or not to include laravel's crsf token in a hidden input, default is true|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $bootstrap_validation Whether or not bootstrap validation is applied, default is true|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $html5_validation Whether or not the html5 validation is applied, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $autocomplete Whether or not the input is autocompleted, default is false|o|d=false|i=switch:{yes,no}|e=true
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param string $size Size of input field|o|i=select:{normal,sm,lg}
 * @param string $text_error Error text for the input|o|
 * @param string $invalid_feedback Client validation error text for the input|o
 * @param string $required_indicator Symbol to indicate that a field is required, default is *|o|d=*|e=*
 * @param string $ajax_success_message Message that pops up if Ajax call is successful, if empty nothing will show|o|e=The item was updated successfully.
 * @param string $success_ajax_callback Javascript callback when Ajax is successful|o
 * @param string $error_ajax_callback Javascript callback when Ajax has errors|o
 * @param string $locale_prefix If not empty this prefix will be added to labels and placeholders |o
 * @param string $form_class Custom class for this form|o|
 *
 * @link /backend/examples/crud CRUD implementation
 */

if(isset($fields) && !is_array($fields)){
    $fields = json_decode($fields, true);
}
if(isset($buttons) && !is_array($buttons)){
    $buttons = json_decode($buttons, true);
}
if(!isset($disabled)){
    $disabled = false;
}
if(!isset($include_crsf_token)){
    $include_crsf_token = true;
}
if(!isset($bootstrap_validation)){
    $bootstrap_validation = true;
}
if(!isset($html5_validation)){
    $html5_validation = !$bootstrap_validation;
}
if(empty($make_ajax_request)){
    $make_ajax_request = false;
}
if(empty($size) || !in_array($size, ['sm','lg'])){
    $size = '';
}
if(!isset($inline)){
    $inline = false;
}
if(empty($inline_collapse_at) || !in_array($inline_collapse_at, ['xs','sm','md','lg','xl'])){
    $inline_collapse_at = 'sm';
}
if(empty($inline_label_width) || !in_array($inline_label_width, ['0','1','2','3','4','5','6','7','8','9','10','11','12'])){
    $inline_label_width = '2';
}
if(empty($inline_input_width) || !in_array($inline_input_width, ['0','1','2','3','4','5','6','7','8','9','10','11','12'])){
    $inline_input_width = '10';
}
if(!isset($required_indicator)){
    $required_indicator = '*';
}
if(isset($buttons) && !is_array($buttons)){
    $buttons = json_decode($buttons, true);
}
$available_methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
if(empty($method) || !in_array(strtoupper($method), $available_methods)){
    $method = 'POST';
}else{
    $method = strtoupper($method);
}

if(!isset($buttons)){
    $submit_btn_label = !empty($submit_label) ? $submit_label : __('vibrant::btn.save');
    $cancel_btn_label = !empty($cancel_label) ? $cancel_label : __('vibrant::btn.cancel');
    if(empty($cancel_link)){
        $buttons = [
            'submit' => [
                'label' => $submit_btn_label
            ]
        ];
    }else{
        $buttons = [
            'submit' => [
                'label' => $submit_btn_label
            ],
            'cancel' => [
                'label' => $cancel_btn_label,
                'link' => $cancel_link
            ]
        ];
    }
    if(!empty($buttons_alignment)){
        $buttons['alignment'] = $buttons_alignment;
    }
    if(!empty($buttons_order)){
        $buttons['order'] = $buttons_order;
    }
}
if(!isset($btn_loading_animated)){
    $btn_loading_animated = true;
}
if(!isset($ajax_success_message)){
    $ajax_success_message = __('vibrant::shared.update_success');
}
if(!isset($custom_buttons)){
    $custom_buttons = '';
}
?>

@bring('vibrant_bootstrap')
@bring('vibrant_interactions')

<form
    id="{{$form_id}}"
    @if($make_ajax_request === true)
        @if($bootstrap_validation != true)onsubmit="event.preventDefault(); handelAjaxForm()" @endif
    @else
        @if($btn_loading_animated === true && $bootstrap_validation != true)onsubmit="laddaBtn.start()" @endif
        @if($method != 'GET' && $method != 'POST') method="POST" @else method="{{$method}}" @endif
        action="{{$form_action}}"
    @endif
    class="@if(!empty($form_class)) {{$form_class}} @endif @if($bootstrap_validation === true)needs-bs-validation @if($make_ajax_request === true)is-ajax @endif @endif"
    @if($bootstrap_validation === true || $html5_validation === false)novalidate @endif

>
    @if($include_crsf_token === true && $method != 'GET'){{csrf_field()}} @endif
    @if($method != 'GET' && $method != 'POST') @method($method) @endif
    @if(!empty($fields) && is_array($fields))
        @php $rowIsOpen = false; $counter = 0; @endphp
        @foreach($fields as $field)
            @php
                if(empty($field['input'])){
                    $field['input'] = 'text';
                }
            @endphp
            @php
                $params = $field;
                unset($params['input']);
                if(empty($params['col_class']) && !empty($params['row']) && $inline === false){
                    $params['col_class'] = 'col-auto';
                }
                if($inline === true){
                    unset($params['col_class']);
                }
            @endphp
            @if(!empty($params['row']) && $params['row'] =='new' && $inline === false )
                @if($rowIsOpen === false)
                    <div class="form-row align-items-center">
                    @php $rowIsOpen = true; @endphp
                @else
                    @if($counter > 0)
                        </div>
                        <div class="form-row align-items-center">
                        @php $rowIsOpen = true; @endphp
                    @endif
                @endif
            @endif
            @if(empty($params['row']) && $inline === false)
                @if($rowIsOpen === true)
                    @if($counter > 0)
                        </div>
                        @php
                            $rowIsOpen = false;
                        @endphp
                    @endif
                @endif
            @endif
            @include("vibrant::components.bootstrap.".$field['input'], $params)

            @php $counter++; @endphp
        @endforeach
        @if($rowIsOpen === true)
            </div>
            @php $rowIsOpen = false; @endphp
        @endif
    @endif
    {{$slot}}
    @if(!empty($buttons))
    <div class="form-group row mt-3 @if(!empty($buttons['alignment']))text-{{$buttons['alignment']}} @endif" @if(!empty($buttons['alignment']))style="width: 100%" @endif>
        <div class="@if($inline === true) @if($inline_collapse_at == 'xs')col-{{$inline_input_width}} @else col-{{$inline_collapse_at}}-{{$inline_input_width}} @endif @if($inline_collapse_at == 'xs')offset-{{$inline_label_width}} @else offset-{{$inline_collapse_at}}-{{$inline_label_width}} @endif @else col-12 @endif">
        @if(empty($buttons['order']) || $buttons['order'] != 'inverse')
            @if(!empty($buttons['submit']['label']))
            <button type="submit" class="mr-1 btn @if(!empty($buttons['submit']['btn_class'])) {{$buttons['submit']['btn_class']}} @else btn-primary @endif" @if((!empty($buttons['submit']['disabled']) && $buttons['submit']['disabled'] === true) || $disabled == true)disabled @endif>{!! $buttons['submit']['label'] !!}</button>
            @endif
            @if(!empty($buttons['cancel']['label']))
                <a role="button" @if(!empty($buttons['cancel']['link'])) href="{{$buttons['cancel']['link']}}"@endif class="mr-1 btn @if(!empty($buttons['cancel']['btn_class'])) {{$buttons['cancel']['btn_class']}} @else btn-light @endif" @if(!empty($buttons['cancel']['disabled']) && $buttons['cancel']['disabled'] === true)disabled @endif>{!! $buttons['cancel']['label'] !!}</a>
            @endif
            @if(!empty($buttons['reset']['label']))
                <button type="reset" class="mr-1 btn @if(!empty($buttons['reset']['btn_class'])) {{$buttons['reset']['btn_class']}} @else btn-light @endif" @if(!empty($buttons['reset']['disabled']) && $buttons['reset']['disabled'] === true)disabled @endif>{!! $buttons['reset']['label'] !!}</button>
            @endif
        @else
            @if(!empty($buttons['reset']['label']))
                <button type="reset" class="mr-1 btn @if(!empty($buttons['reset']['btn_class'])) {{$buttons['reset']['btn_class']}} @else btn-light @endif" @if(!empty($buttons['reset']['disabled']) && $buttons['reset']['disabled'] === true)disabled @endif>{!! $buttons['reset']['label'] !!}</button>
            @endif
            @if(!empty($buttons['cancel']['label']))
                <a role="button" @if(!empty($buttons['cancel']['link'])) href="{{$buttons['cancel']['link']}}"@endif  class="mr-1 btn @if(!empty($buttons['cancel']['btn_class'])) {{$buttons['cancel']['btn_class']}} @else btn-light @endif" @if(!empty($buttons['cancel']['disabled']) && $buttons['cancel']['disabled'] === true)disabled @endif>{!! $buttons['cancel']['label'] !!}</a>
            @endif
            @if(!empty($buttons['submit']['label']))
                <button type="submit" class="mr-1 btn @if(!empty($buttons['submit']['btn_class'])) {{$buttons['submit']['btn_class']}} @else btn-primary @endif" @if((!empty($buttons['submit']['disabled']) && $buttons['submit']['disabled'] === true) || $disabled == true)disabled @endif>{!! $buttons['submit']['label'] !!}</button>
            @endif
        @endif
        {{$custom_buttons}}
        </div>
    </div>
    @endif
</form>

@push('scripts')
    <script>
        @if($btn_loading_animated === true)
            let submitButton = document.getElementById( '{{$form_id}}').querySelector('button[type="submit"]');
            let laddaBtn = Ladda.create( submitButton );
        @endif
        function handelAjaxForm(){
            @if($btn_loading_animated === true)
                laddaBtn.start();
            @endif
            let form = document.querySelector('#{{$form_id}}');
            let formData = getFormData(form);
            axios({
                method:@if($method != 'GET' && $method != 'POST')'post'@else'{{strtolower($method)}}'@endif,
                url: '{{$form_action}}',
                data: formData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            }).then(function (response) {
                //handle success
                @if($btn_loading_animated === true)
                    laddaBtn.stop();
                @endif
                $('#{{$form_id}}').removeClass('was-validated');
                if(response.data.hasOwnProperty('error')){
                    handleAjaxFormErrors(response.data.error);
                }else{
                    @if(!empty($ajax_success_message))
                        toastr.success('{{$ajax_success_message}}');
                    @endif
                }
                @if(!empty($success_ajax_callback)){!! $success_ajax_callback !!} @endif
            }).catch(function (error) {
                //handle error
                @if($btn_loading_animated === true)
                    laddaBtn.stop();
                @endif
                $('#{{$form_id}}').removeClass('was-validated');
                if (error.response) {
                    // The request was made and the server responded
                    if(error.response.data.hasOwnProperty('errors')){
                        handleAjaxFormErrors(error.response.data.errors);
                    }
                } else if (error.request) {
                    console.log('Error! The request was made but no response was received.');
                    console.log('Error:',error.request);
                } else {
                    console.log('Error! Something happened in setting up the request that triggered an Error');
                    console.log('Error:', error.message);
                }
                @if(!empty($error_ajax_callback)){!! $error_ajax_callback !!} @endif
            });
            return false;
        }
        function handleAjaxFormErrors(errors){
            //console.log(errors);
            if (Object.keys(errors).length === 0){
                return false;
            }

            Object.keys(errors).forEach(key => {
                $("#{{$form_id}} input[name="+key+"]").closest('.form-group').addClass('has-error');
                $("#{{$form_id}} input[name="+key+"]").siblings('.text-error').text(errors[key]);
            });
        }
        function afterBsValidationNoAjax(){
            @if($btn_loading_animated === true)
                laddaBtn.start();
            @endif
        }
    </script>
@endpush
