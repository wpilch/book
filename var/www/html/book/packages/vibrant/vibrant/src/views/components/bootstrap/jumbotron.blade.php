<?php
/**
 * Jumbotron component
 *
 * Lightweight, flexible component for showcasing hero unit style content.
 *
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $id Element Id|e=example-jumbotron
 * @param string $bg_image Url of custom background image|o|e=/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg
 * @param string $overlay_color Color for the text of this component overlay|o|i=colorAlpha|e=rgba(20, 40, 75, 0.70)
 * @param string $text_color Color for the text of this component|o|i=color|e=#ffffff
 * @param bool:boolean $fluid Whether or not to make this component full width|o|i=switch:{yes,no}|e=false
 * @param string $class Custom class for this component|o|
 *
 * @slot default <h1 class="display-4">Hello, world!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
 */

if(!isset($fluid)){
    $fluid = false;
}
?>

@bring('vibrant_bootstrap')

<div id="{{$id}}" class="jumbotron @if(!empty($class)) {{$class}} @endif position-relative @if($fluid === true)jumbotron-fluid @endif @if(!empty($bg_image))with-background-image @endif" style="@if(!empty($bg_image))background-image: url('{{$bg_image}}'); @endif @if(!empty($text_color))color: {{$text_color}} @endif">
    @if(!empty($overlay_color))
        <div class="container-overlay" style="background-color: {{ $overlay_color }};"></div>
    @endif
    <div class="jumbotron-content position-relative @if($fluid === true)container-fluid @endif">
    {{ $slot }}
    </div>
</div>


