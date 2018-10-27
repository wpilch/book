<?php
/**
 * Switch component
 *
 * Switch input component for forms. Based on <a class="link" href="http://bootstrapswitch.site">bootstrapSwitch</a> plugin.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=switchInput
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $label Input label|o|e=Toggle state
 * @param string $label_position Define the position of label|o|i=select:{top,left,right}|d=top|e=top
 * @param string $label_class Class to modify input label style|o
 * @param string $value Predefined value for the switch, if provided it must match on_value or off_value|o|
 * @param string $on_value Value to be sent in a form when switch is on, default is 'on'|o|
 * @param string $off_value Value to be sent in a form when switch is off, default is 'off'|o|
 * @param string $on_label Label shown when switch is on, if empty label will be upper case of on_value|o|
 * @param string $off_label Label shown when switch is off, if empty label will be upper case of off_value|o|
 * @param string $on_color Color shown when switch is on, default is 'primary'|o|d=primary|i=select:{primary,info,success,warning,danger,default,muted}|e=primary
 * @param string $off_color Color shown when switch is off, default is 'default'|o|d=default|i=select:{primary,info,success,warning,danger,default,muted}|e=default
 * @param string $switch_size Size of the switch element, default is 'small'|o|d=small|i=select:{small,normal,large}|e=small
 * @param bool:boolean $isOn Predefined state of switch, default is on|o|i=switch:{on,off}|e=true|d=true
 * @param bool:boolean $required Whether or not the input is required, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $disabled Whether or not the input is disabled, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param bool:boolean $inline Whether or not to show input with inline format, default is false|o|d=false|i=switch:{yes,no}|e=false
 * @param string $inline_collapse_at Breakpoint for collapse the inline format, default is sm |o|d=sm|i=select:{xs,sm,md,lg,xl}|e=sm
 * @param integer $inline_label_width Width (in columns) of label when inline is used, default is 2|o|d=2|i=number:{0,12,1}|e=2
 * @param integer $inline_input_width Width (in columns) of label when inline is used, default is 10|o|d=10||i=number:{0,12,1}|e=10
 * @param string $text_help Help text for the input|o|
 * @param string $text_error Error text for the input|o|
 * @param string $invalid_feedback Client validation error text for the input|o|
 * @param string $tooltip_text Show tooltip with text|o|
 * @param string $tooltip_icon Icon class for tooltip, default is 'fa fa-info-circle'|o
 * @param string $required_indicator Symbol to indicate that field is required|o|d=*
 * @param string $attributes Adds the provided attributes to the switch element|o|
 * @param string $col_class Bootstrap grid class if need it (e. col-md-6)|o|
 * @param string $class Custom class for this component|o|
 */
if(isset($value)){
    $switch_value = $value;
}else{
    $switch_value = '';
}
if(empty($on_value)){
    $on_value = 'on';
}
if(empty($off_value)){
    $off_value = 'off';
}
if(empty($switch_value) || !in_array($switch_value,[$on_value, $off_value])){
    if(!isset($isOn) || !in_array($isOn, [true, false])){
        $isOn = true;
    }
}else{
    $isOn = ($switch_value == $on_value);
}
$value = $isOn;

if(empty($on_label)){
    $on_label = strtoupper($on_value);
}
if(empty($off_label)){
    $off_label = strtoupper($off_value);
}
if(empty($on_color)){
    $on_color = 'primary';
}
if(empty($off_color)){
    $off_color = 'default';
}
if(empty($switch_size)){
    $switch_size ='small';
}
if(!isset($attributes)){
    $attributes ='';
}
$attributes .= ' data-wrapper-class=vib-switch data-hidden-pair=hidden_'.$name.' data-on-color='.$on_color.' data-off-color='.$off_color.' data-size='.$switch_size.' data-on-value='.$on_value.' data-off-value='.$off_value.'  data-on-text='.$on_label.'  data-off-text='.$off_label;

if(empty($label_position)){
    $label_position = 'top';
}
?>

@bring('bs_switch')

@include('vibComponent::bootstrap.checkbox', [
    'plugin' => 'bSwitch',
    'disable_bs_custom' => true,
    'attributes' => $attributes,
    compact(
        'name',
        'id',
        'label',
        'label_class',
        'placeholder',
        'value',
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

@include('vibComponent::bootstrap.hidden', [
    'value' => $switch_value,
    'id' => 'hidden_'.$name,
    compact(
        'name'
    )
])
