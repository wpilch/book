<?php
/**
 * Textarea component
 *
 * General component for textarea in a form.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=textArea
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $label Input label|o|e=Label example
 * @param string $label_class Class to modify input label style|o|e=text-right
 * @param string $placeholder Placeholder for the input|o|e=e. focus here to show a tip
 * @param string $value Predefined value for the input|o|i=textarea
 * @param integer $rows Visible number of lines|o|d=4|i=number:{1,100,1}|e=4
 * @param integer:integer $maxlength Maximum number of characters allowed|o
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param bool:boolean $required Whether or not the input is required, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $resize Whether or not the textarea is resizeable, default is true|o|d=true|i=switch:{yes,no}|e=true
 * @param bool:boolean $autocomplete Whether or not the input is autocompleted, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $read_only Whether or not the input is read only, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $text_help Help text for the input|o|e=This tip will help you with your answer.
 * @param bool:boolean $text_help_keep Whether or not maintain help text always visible, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $text_error Error text for the input|o|
 * @param string $invalid_feedback Client validation error text for the input|o|
 * @param string $tooltip_text Show tooltip with text|o|e=This tip will help you with your answer.
 * @param string $tooltip_icon Icon class for tooltip, default is 'fa fa-info-circle'|o
 * @param string $prepend Prepend text or icon to this input|o
 * @param string $prepend_raw Prepend html or another component to this input|o|i=textarea
 * @param string $append Append text or icon to this input|o
 * @param string $append_raw Append html or another component to this input|o|i=textarea
 * @param string $required_indicator Symbol to indicate that a field is required, default is *|o|d=*
 * @param string $col_class Bootstrap grid class if need it (e. col-md-6)|o|
 * @param string $locale_prefix If not empty this prefix will be added to labels and placeholders |o
 * @param string $plugin Adds 'data-plugin' with the provided value to the input |o
 * @param string $attributes Adds the provided attributes to the input |o
 * @param string $class Custom class for this component|o|
 */

if(empty($id)){
    $id = $name;
}
if(!isset($label)){
    $label = empty($locale_prefix) ? ucwords(str_replace("_", " ", $name)) : $name;
}
if(!isset($placeholder)){
    $placeholder = empty($locale_prefix) ? ucwords(str_replace("_", " ", $name)) : $name;
}
if(empty($value)){
    $value = '';
}
if(!empty($locale_prefix)){
    $label = __($locale_prefix.".".$label);
    $placeholder = __($locale_prefix.".".$placeholder);
}
if(!isset($resize)){
    $resize = true;
}
if(!isset($required)){
    $required = false;
}
if(!isset($read_only)){
    $read_only = false;
}
if(!isset($disabled)){
    $disabled = false;
}
if(empty($rows)){
    $rows = 4;
}
if(!isset($inline)){
    $inline = false;
}
if($inline === true && empty($label_class)){
    $label_class = 'text-sm-right';
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
if(!isset($autocomplete) || $autocomplete !== true ){
    $autocomplete = 'nope';
}else{
    $autocomplete = 'on';
}
if(!isset($text_help_keep)){
    $text_help_keep = false;
}
if(empty($tooltip_icon)){
    $tooltip_icon = 'fa fa-info-circle';
}
if(!isset($required_indicator)){
    $required_indicator = '*';
}
?>

@bring('vibrant_bootstrap')

<div class="form-group @if(!empty($class)) {{$class}} @endif @if(!empty($col_class)) {{$col_class}} @endif @if(!empty($text_error))has-error @endif @if($inline === true)row @endif @if(!empty($tooltip_text))with-tooltip @endif">

    @if(!empty($label))
        <label class="@if(!empty($label_class)){{$label_class}} @endif @if($inline === true)  @if($inline_collapse_at == 'xs')col-{{$inline_label_width}} @else col-{{$inline_collapse_at}}-{{$inline_label_width}} @endif  col-form-label @endif" for="{{$id}}">@if($required === true)<span class="required-indicator">{{$required_indicator}}</span>@endif{!! $label !!}</label>
    @endif

    <div class="input-block @if($inline === true) @if($inline_collapse_at == 'xs')col-{{$inline_input_width}} @else col-{{$inline_collapse_at}}-{{$inline_input_width}} @endif col-form-input @endif">

        @if(!empty($tooltip_text))
        <div class="input-with-tooltip">
        @endif
            <div class=" @if(!empty($append_raw) || !empty($append) ||!empty($prepend_raw) || !empty($prepend))input-group @endif">
                @if(!empty($prepend_raw) || !empty($prepend))
                    <div class="input-group-prepend">
                        @if(!empty($prepend_raw)) {!! $prepend_raw !!} @endif
                        @if(!empty($prepend))
                            <span class="input-group-text">{!! $prepend !!}</span>
                        @endif
                    </div>
                @endif
                <textarea class="vib-input @if($read_only === true)form-control-plaintext @else form-control @endif @if(!empty($size))form-control-{{$size}} @endif"
                        id="{{$id}}"
                        name="{{$name}}"
                        @if(!empty($rows)) rows="{{$rows}}" @endif
                        @if(!empty($maxlength)) maxlength="{{$maxlength}}" @endif
                        aria-describedby="{{$id}}HelpBlock"
                        @if(!empty($placeholder)) placeholder="{{$placeholder}}" @endif
                        autocomplete="{{$autocomplete}}"
                        @if($disabled === true) disabled @endif
                        @if($resize === false) style="resize: none;" @endif
                        @if($read_only === true) readonly @endif
                        @if($required === true) required @endif
                        @if(!empty($plugin))data-plugin="{{$plugin}}"@endif
                        @if(!empty($attributes)){{$attributes}}@endif>@if(!empty($value)){{$value}}@endif</textarea>
            </div>
            <div class="invalid-feedback">@if(!empty($invalid_feedback)){{$invalid_feedback}}@endif</div>
            @if(!empty($text_help))
                <small id="{{$id}}HelpBlock" class="form-text text-muted text-help @if($text_help_keep === false)show-on-input-focus @endif">{!! $text_help !!}</small>
            @endif
            <small class="form-text text-danger text-error">@if(!empty($text_error)){!! $text_error !!}@endif</small>
            @if(!empty($append_raw) || !empty($append))
                <div class="input-group-append">
                    @if(!empty($append_raw)) {!! $append_raw !!} @endif
                    @if(!empty($append))
                        <span class="input-group-text">{!! $append !!}</span>
                    @endif
                </div>
            @endif
        @if(!empty($tooltip_text))
        </div>
        <span class="input-tooltip">
            <i class="icon {{$tooltip_icon}}" data-toggle="tooltip" data-placement="bottom" title="{{$tooltip_text}}"></i>
        </span>
        @endif

    </div>

</div>


