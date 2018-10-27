<?php
/**
 * Divider component
 *
 * Create elements to separate content and apply different styles to them.
 *
 * @category Html
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $class Custom class for the component|o
 * @param string $width Width of line|o|i=number:{1,100,1,%}|e=100
 * @param string $thickness Thickness of line|o|i=number:{1,20,1,px}|e=2
 * @param string $style Style of line|o|i=select:{dotted,dashed,solid,double}|e=dotted
 * @param string $color Color of line|o|i=color|e=#6173d4
 * @param string $margin_top Space at the top of line|o|i=number:{1,100,1,px}|e=10
 * @param string $margin_bottom Space at the bottom of line|o|i=number:{1,100,1,px}|e=10
 */

if(!isset($width) || empty($width) ){
    $width = '100%';
}
if(!isset($thickness) || empty($thickness)){
    $thickness = '2px';
}
if(!isset($style) || empty($style)){
    $style = 'dotted';
}
if(!isset($color) || empty($color)){
    $color = '#e0e0e0';
}
if(!isset($margin_top) || empty($margin_top)){
    $margin_top = '10px';
}
if(!isset($margin_bottom) || empty($margin_bottom)){
    $margin_bottom = '10px';
}
?>

<div class="@if(isset($class)){{$class}}@endif" style="
        width: {{$width}};
        height: {{$thickness}};
        border-top: {{$thickness}} {{$style}} {{$color}};
        margin-top: {{$margin_top}};
        margin-bottom: {{$margin_bottom}};
        margin-left: auto;
        margin-right: auto;
    ">
</div>

