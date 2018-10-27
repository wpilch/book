<?php
/**
 * Carousel component
 *
 * A slideshow component for cycling through elements—images or slides of text—like a carousel.
 *
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $id Element Id|e=main-carousel
 * @param array:json $slides Json or array including image(url), caption(html,optional), overlay_color(color,optional)'|i=textarea|e=[{"image":"/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg",
        "caption":"<h2>Slide 1</h2><p>This is the tagline of slide 1</p>",
        "overlay_color":"rgba(0,0,0,0.3)"},
        {"image":"/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg",
        "caption":"<h2>Slide 2</h2><p>This is the tagline of slide 2</p>",
        "overlay_color":"rgba(71, 60, 241, 0.3)"},
        {"image":"/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg",
        "caption":"<h2>Slide 3<\/h2><p>This is the tagline of slide 3</p>",
        "overlay_color":"rgba(199, 95, 95, 0.3)"}]
 * @param string $caption_class This class will be applied to caption blocks|o
 * @param string $height Height of element|o|i=number:{0,1200,1,px}|e=305
 * @param bool:boolean $show_indicators Whether or not indicators are shown|o|i=switch:{yes,no}|e=false
 * @param bool:boolean $show_controls Whether or not controls are shown|o|i=switch:{yes,no}|e=true
 * @param bool:boolean $fade_effect Whether or not fade effect is applied|o|i=switch:{yes,no}|e=false
 * @param integer $interval Amount of time to delay between sliders|o|i=number:{0,20000,500}|e=3000
 * @param string $class Custom class for this component|o
 */

if(!is_array($slides)){
    $slides = json_decode($slides, true);
};
if(!isset($show_indicators)){
    $show_indicators = true;
}
if(!isset($show_controls)){
    $show_controls = true;
}
if(!isset($interval) || empty($interval) ){
    $interval = 3000;
}
if(!isset($fade_effect)){
    $fade_effect = false;
}
if(isset($height) && ($height == '0px')){
    $height = '100%';
}
$number_sliders = count($slides);
?>

@bring('vibrant_bootstrap')

<div class="slider @if(!empty($class)) {{$class}} @endif">
    <div class="carousel slide @if($fade_effect === true) carousel-fade  @endif" id="{{$id}}" data-ride="carousel" data-interval="{{$interval}}">
        @if($show_indicators === true)
        <ol class="carousel-indicators">
            @for ($i = 0; $i < $number_sliders ; $i++)
                <li @if($i==0) class="active" @endif data-slide-to="{{$i}}" data-target="#{{$id}}"></li>
            @endfor
        </ol>
        @endif
        <div class="carousel-inner" role="listbox"  @if(!empty($height))style="height: {{$height}}"@endif>
            @for ($i = 0; $i < $number_sliders ; $i++)
                <div class="carousel-item @if($i==0) active @endif" style="height: inherit">
                    <img class="w-100" src="{{$slides[$i]['image']}}" alt="..." style="height: inherit;" >
                    @if(isset($slides[$i]['caption']) && !empty($slides[$i]['caption']))
                        <div class="carousel-caption @if(!empty($caption_class)){{$caption_class}}@endif">
                            {!! $slides[$i]['caption'] !!}
                        </div>
                    @endif
                    @if(isset($slides[$i]['overlay_color']) && !empty($slides[$i]['overlay_color']))
                        <div class="container-overlay" style="background-color: {{ $slides[$i]['overlay_color'] }};"></div>
                    @endif
                </div>
            @endfor
        </div>
        @if($show_controls)
        <a class="carousel-control-prev" href="#{{$id}}" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="sr-only">{{__('vibrant::shared.previous')}}</span>
        </a>
        <a class="carousel-control-next" href="#{{$id}}" role="button" data-slide="next">
            <span class="carousel-control-next-icon " aria-hidden="true"></span>
            <span class="sr-only">{{__('vibrant::shared.next')}}</span>
        </a>
        @endif
    </div>
</div>
