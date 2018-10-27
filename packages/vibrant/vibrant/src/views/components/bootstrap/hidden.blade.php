<?php
/**
 * Hidden input component
 *
 * Component for hidden fields in a form.
 *
 * @group Form
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Input name|e=hiddenInput
 * @param string $id Input Id, if empty it takes tha same value as $name|o|
 * @param string $value Predefined value for the input|o|
 */
?>

@include('vibComponent::bootstrap.input', [
    'type' => 'hidden',
    'label' => '',
    'placeholder' => '',
    compact(
        'name',
        'id',
        'value'
    )
])
