<?php
/**
 * Multiselect component
 *
 * Multiselect component for forms.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=multiselectInput
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $label Input label|o|e=Make your choice
 * @param string $label_class Class to modify input label style|o|
 * @param array:json $items Json or array including Option, checked(bool, optional) and disabled(bool, optional)|i=textarea|e=[{"label":"Option one",
"value":"1"},
{"label":"Option two", "value":"2"}]
 * @param array:json $values Json or array with predefined selected values|o|i=textarea|e=["1","2"]
 * @param string $size Size of input field|o|i=select:{normal,sm,lg}
 * @param bool:boolean $required Whether or not the input is required, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param string $text_help Help text for the input|o|
 * @param string $text_error Error text for the input|o|
 * @param string $invalid_feedback Client validation error text for the input|o|
 * @param string $tooltip_text Show tooltip with text|o|e=This tip will help you with your answer.
 * @param string $tooltip_icon Icon class for tooltip, default is 'fa fa-info-circle'|o
 * @param string $required_indicator Symbol to indicate that a field is required, default is *|o|d=*|e=*
 * @param string $col_class Bootstrap grid class if need it (e. col-md-6)|o|
 * @param string $class Custom class for this component|o|
 */
if(empty($id)){
    $id = $name;
}
if(!isset($label)){
    $label = empty($locale_prefix) ? ucwords(str_replace("_", " ", $name)) : $name;
}
if(!empty($locale_prefix)){
    $label = __($locale_prefix.".".$label);
}
if(!is_array($items)){
    $items = json_decode($items, true);
}
if(isset($values) && !is_array($values)){
    $values = json_decode($values, true);
}
if(!isset($required)){
    $required = false;
}
if(!isset($disabled)){
    $disabled = false;
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
if(empty($tooltip_icon)){
    $tooltip_icon = 'fa fa-info-circle';
}
if(!isset($required_indicator)){
    $required_indicator = '*';
}
?>

@bring('vibrant_bootstrap')

<div class="form-group @if(!empty($class)) {{$class}} @endif @if(!empty($col_class)) {{$col_class}} @endif @if($inline === true)row @endif @if(!empty($text_error))has-error @endif @if(!empty($tooltip_text))with-tooltip @endif">
    @if(!empty($label))
        <label class="@if(!empty($label_class)){{$label_class}} @endif @if($inline === true)  @if($inline_collapse_at == 'xs')col-{{$inline_label_width}} @else col-{{$inline_collapse_at}}-{{$inline_label_width}} @endif  col-form-label @endif" for="{{$id}}">@if($required === true)<span class="required-indicator">{{$required_indicator}}</span>@endif{!! $label !!}</label>
    @endif
    <div class="input-block input-multiselect @if($inline === true) @if($inline_collapse_at == 'xs')col-{{$inline_input_width}} @else col-{{$inline_collapse_at}}-{{$inline_input_width}} @endif col-form-label @endif">
        @if(!empty($tooltip_text))
            <div class="input-with-tooltip">
                @endif
                <select name="{{$name}}[]" multiple class="vib-input custom-select @if(!empty($size))custom-select-{{$size}} @endif" @if($disabled === true) disabled @endif  @if($required === true) required @endif>
                    @foreach($items as $item)
                        <option value="{{$item['value']}}" @if(isset($values) && (in_array($item['value'], $values)))selected @endif>{{$item['label']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">@if(!empty($invalid_feedback)){{$invalid_feedback}}@endif</div>
                @if(!empty($text_help))
                    <small id="{{$id}}HelpBlock" class="form-text text-muted text-help">{!! $text_help !!}</small>
                @endif
                <small class="form-text text-danger text-error ">@if(!empty($text_error)){!! $text_error !!}@endif</small>
                @if(!empty($tooltip_text))
            </div>
            <span class="input-tooltip">
            <i class="icon {{$tooltip_icon}}" data-toggle="tooltip" data-placement="bottom" title="{{$tooltip_text}}"></i>
        </span>
        @endif
    </div>
</div>

