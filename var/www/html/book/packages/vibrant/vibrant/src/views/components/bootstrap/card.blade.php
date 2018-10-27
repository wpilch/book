<?php
/**
 * Card component
 *
 * Flexible and extensible content container with multiple variants and options.
 *
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @slot default <div class="text-center text-muted pb-4"><i class='icon md-boat' style='font-size: 40px'></i><br>Your html goes here</div>
 * @slot header_slot
 * @slot footer_slot
 * @slot card_img_overlay_slot
 *
 * @param string $title Title of the card|o|e=This is a card
 * @param string $text Text of the card|o|i=textarea|e=Some quick example text to build on the card title and make up the bulk of the cards content.
 * @param string $bg_image Url of custom background image|o|e=/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg
 * @param string $img_overlay_color Color of the image overlay|o|i=colorAlpha|e=rgba(50, 99, 190, 0.33)
 * @param string $btn_text Text of the card button|o|e=Go to link
 * @param string:url $btn_link Link of the card button|o|e=https://google.com
 * @param string $img_position Position of the card image, top if empty|o|i=select:{top,bottom}|e=top
 * @param string $btn_position Position of the card button, left if empty|o|i=select:{center,left,right}|e=center
 * @param string $width Width of card|o|i=number:{0,1200,1,px}|e=320
 * @param string $img_height Height of card's image|o|i=number:{0,1200,1,px}|e=200
 * @param string $class Custom class for this component|o
 */

if(isset($width) && ($width == '0px')){
    $width = 'auto';
}
if(isset($img_height) && ($img_height == '0px')){
    $img_height = 'auto';
}
if(empty($btn_position) || !in_array($btn_position, ['center','left','right']) ){
    $btn_position = 'left';
}
if(empty($img_position) || $img_position != 'bottom'){
    $img_position = 'top';
}
?>


@bring('vibrant_bootstrap')

<div class="@if(isset($class)){{$class}}@endif card" @if(!empty($width))style="width: {{$width}}"@endif>
    @if(!empty($header_slot))<div class="card-header">{{$header_slot}}</div> @endif
    @if(!empty($bg_image) && $img_position == 'top')
        <div class="card-img-container" style="position: relative">
            <img class="card-img-top" src="{{$bg_image}}" @if(!empty($img_height))style="height: {{$img_height}}" @endif alt="...">
            @if(!empty($card_img_overlay_slot))
            <div class="card-img-overlay">
                {{$card_img_overlay_slot}}
            </div>
            @endif
            @if(!empty($img_overlay_color))
                <div class="container-overlay" style="background-color: {{ $img_overlay_color }};"></div>
            @endif
        </div>
    @endif
    <div class="card-body">
        @if(!empty($title))
        <h5 class="card-title">{{$title}}</h5>
        @endif
        @if(!empty($text))
        <p class="card-text">{{$text}}</p>
        @endif
        {{$slot}}
        @if(!empty($btn_text))
            <div class="text-{{$btn_position}}">
                <a @if(isset($btn_link))href="{{$btn_link}}"@endif class="btn btn-primary">{{$btn_text}}</a>
            </div>
        @endif
    </div>
    @if(!empty($bg_image) && $img_position == 'bottom')
        <div class="card-img-container" style="position: relative">
            <img class="card-img-bottom" src="{{$bg_image}}" @if(!empty($img_height))style="height: {{$img_height}}" @endif alt="...">
            @if(!empty($card_img_overlay_html))
            <div class="card-img-overlay">
                {{$card_img_overlay_slot}}
            </div>
            @endif
            @if(!empty($img_overlay_color))
                <div class="container-overlay" style="background-color: {{ $img_overlay_color }};"></div>
            @endif
        </div>
    @endif
    @if(!empty($footer_slot))<div class="card-footer">{{$footer_slot}}</div> @endif
</div>


