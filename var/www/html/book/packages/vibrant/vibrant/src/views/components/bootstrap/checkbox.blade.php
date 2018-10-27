<?php
/**
 * Checkbox component
 *
 * Checkbox input component for forms.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=checkboxInput
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $label Input label|o|e=Check this custom checkbox
 * @param string $label_position Define the position of label|o|i=select:{top,left,right}|d=right|e=right
 * @param string $label_class Class to modify input label style|o
 * @param bool:boolean $value Predefined value of the input, default is off|o|i=switch:{on,off}|e=true
 * @param bool:boolean $required Whether or not the input is required, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disable_bs_custom If true it will display the original element, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param string $text_help Help text for the input|o|e=This tip will help you with your answer.
 * @param string $text_error Error text for the input|o|
 * @param string $invalid_feedback Client validation error text for the input|o|
 * @param string $tooltip_text Show tooltip with text|o|e=This tip will help you with your answer.
 * @param string $tooltip_icon Icon class for tooltip, default is 'fa fa-info-circle'|o
 * @param string $required_indicator Symbol to indicate that field is required|o|d=*
 * @param string $plugin Adds 'data-plugin' with the provided value to the input |o
 * @param string $attributes Adds the provided attributes to the input |o
 * @param string $col_class Bootstrap grid class if need it (e. col-md-6)|o|
 * @param string $class Custom class for this component|o|
 */

if(empty($id)){
    $id = $name;
}
if(!isset($label)){
    $label = empty($locale_prefix) ? ucwords(str_replace("_", " ", $name)) : $name;
}
if(empty($label_position)){
    $label_position = 'right';
}
if(!empty($locale_prefix)){
    $label = __($locale_prefix.".".$label);
}
if(!isset($required)){
    $required = false;
}
if(!isset($disabled)){
    $disabled = false;
}
if(!isset($disable_bs_custom)){
    $disable_bs_custom = false;
}
if(empty($tooltip_icon)){
    $tooltip_icon = 'fa fa-info-circle';
}
if(!empty($value) && ($value == 'on' ||  $value == '1' || $value === true)){
    $isChecked = true;
}else{
    $isChecked = false;
}
if(!isset($required_indicator)){
    $required_indicator = '*';
}
?>

@bring('vibrant_bootstrap')

<div class="form-group @if(!empty($class)) {{$class}} @endif @if(!empty($col_class)) {{$col_class}} @endif @if(!empty($text_error))has-error @endif @if(!empty($tooltip_text))with-tooltip @endif @if($inline === true)row @endif">
    <div class="input-block input-checkbox @if($inline === true) @if($inline_collapse_at == 'xs')col-{{$inline_input_width}} @else col-{{$inline_collapse_at}}-{{$inline_input_width}} @endif @if($inline_collapse_at == 'xs')offset-{{$inline_label_width}} @else offset-{{$inline_collapse_at}}-{{$inline_label_width}} @endif col-form-label @endif">
        @if(!empty($tooltip_text))
        <div class="input-with-tooltip">
        @endif
            <div class="@if($disable_bs_custom === false)custom-control custom-checkbox @endif">
                @if(!empty($label) && ($label_position === 'left' || $label_position === 'top'))
                    <label @if($label_position === 'top')style="display: block"@endif for="{{$id}}" class="@if($disable_bs_custom === false)custom-control-label @endif @if(!empty($label_class)){{$label_class}} @endif ">@if($required === true)<span class="required-indicator">{{$required_indicator}}</span>@endif{!! $label !!}</label>
                @endif
                <input type="checkbox" class="vib-input custom-control-input" id="{{$id}}" name="{{$name}}" aria-describedby="{{$id}}HelpBlock"
                        @if($isChecked)checked @endif
                        @if(!empty($value)) value="{{$value}}" @endif
                        @if($disabled === true) disabled @endif
                        @if($required === true) required @endif
                        @if(!empty($plugin))data-plugin="{{$plugin}}"@endif
                        @if(!empty($attributes)){{$attributes}}@endif
                >
                @if(!empty($label) && $label_position === 'right')
                    <label for="{{$id}}" class="@if($disable_bs_custom === false)custom-control-label @endif @if(!empty($label_class)){{$label_class}} @endif ">@if($required === true)<span class="required-indicator">{{$required_indicator}}</span>@endif{!! $label !!}</label>
                @endif
            </div>
            <div class="invalid-feedback">@if(!empty($invalid_feedback)){{$invalid_feedback}}@endif</div>
            @if(!empty($text_help))
                <small id="{{$id}}HelpBlock" class="form-text text-muted text-help">{!! $text_help !!}</small>
            @endif
            <small class="form-text text-danger text-error invalid-feedback">@if(!empty($text_error)){!! $text_error !!}@endif</small>
        @if(!empty($tooltip_text))
        </div>
        <span class="input-tooltip">
            <i class="icon {{$tooltip_icon}}" data-toggle="tooltip" data-placement="bottom" title="{{$tooltip_text}}"></i>
        </span>
        @endif
    </div>
</div>
