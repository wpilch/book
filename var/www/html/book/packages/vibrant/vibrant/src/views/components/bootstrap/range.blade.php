<?php
/**
 * Range component
 *
 * Range input for forms.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=sliderInput
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $label Input label|o|e=Select a range
 * @param string $label_class Class to modify input label style|o
 * @param string $placeholder Placeholder for the input|o|e=Select a range
 * @param string $value Predefined value for the input|o|
 * @param string $size Size of input field|o|i=select:{normal,sm,lg}
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param bool:boolean $required Whether or not the input is required, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $autocomplete Whether or not the input is autocompleted, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $read_only Whether or not the input is read only, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $text_help Help text for the input|o
 * @param bool:boolean $text_help_keep Whether or not maintain help text always visible, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $text_error Error text for the input|o
 * @param string $invalid_feedback Client validation error text for the input|o|
 * @param string $tooltip_text Show tooltip with text|o
 * @param string $tooltip_icon Icon class for tooltip, default is 'fa fa-info-circle'|o
 * @param string $prepend Prepend text or icon to this input|o
 * @param string $prepend_raw Prepend html or another component to this input|o|i=textarea
 * @param string $append Append text or icon to this input|o
 * @param string $append_raw Append html or another component to this input|o|i=textarea
 * @param string $required_indicator Symbol to indicate that a field is required, default is *|o|d=*
 * @param string $col_class Bootstrap grid class if need it (e. col-md-6)|o|
 * @param string $attributes Adds the given attributes to the input |o
 * @param string $class Custom class for this component|o|
 */
if(!isset($attributes)){
    $attributes ='';
}
$attributes .= ' data-extra-classes=vib-range';
?>

@bring('jq_ionRangeSlider@2.2.0')

@include('vibComponent::bootstrap.input', [
    'type' => 'text',
    'plugin' => 'rangeSlider',
    'attributes' => $attributes,
    compact(
        'name',
        'id',
        'label',
        'label_class',
        'placeholder',
        'value',
        'size',
        'inline',
        'inline_collapse_at',
        'inline_label_width',
        'inline_input_width',
        'required',
        'autocomplete',
        'read_only',
        'disabled',
        'text_help',
        'text_help_keep',
        'text_error',
        'tooltip_text',
        'tooltip_icon',
        'prepend',
        'prepend_raw',
        'append',
        'append_raw',
        'class'
    )
])
