<?php
/**
 * PackageCard component
 *
 * A long description here
 *
 * @category Cards
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $name Name of package|e=Hover me to see the effect
 * @param string $description Description of the package|i=textarea|e=This is an example of the description that can be used for a package
 * @param string:url $url Url of the package's home|e=http://mentor.test/home
 * @param string $class Custom class for the component|o
 * @param string:url $bg_image Url of custom background image|o
 * @param string $icon Css class of custom icon for the package e. 'fa fa-spinner fa-spin'|o
 * @param string $info_tag If present, will show a info tag with the text|o
 * @param string $height Set card height e. '250px', otherwise will use 200px|o
 * @param string $overlay_color RGB Color for the card overlay e. '200,200,100'|o
 */

if(!isset($bg_image) || empty($bg_image)){
    $bg_image = '/vendor/vibrant/vibrant/app/img/dummy/dashboard-header.jpg';
}
if(!isset($icon) || empty($icon)){
    $icon = 'md-layers';
}
?>

@bring('bs_theme_blueFlame')

<div class="@if(isset($class)){{$class}}@endif card package-card">
    <a href="{{$url}}">
        <div class="card-header cover overlay overlay-hover animation-hover">
            <img class="cover-image h-200 overlay-figure overlay-scale" src="{{$bg_image}}" @if(isset($height))style="height: {{$height}} !important;"@endif alt="...">
            <div class="overlay-panel overlay-background-fixed p-0" @if(isset($overlay_color) && !empty($overlay_color)) style="background-color: rgba({{$overlay_color}}, 0.8) !important;" @endif>
                <div class="overlay-upper">
                    <div class="o-content py-20 px-30">
                        <div class="o-content-block float-left">
                            <i class="icon {{$icon}} font-size-60 mr-20" aria-hidden="true"></i>
                            <div class="text-break">{{$name}}</div>
                        </div>
                    </div>
                    @if(isset($info_tag) && !empty($info_tag))
                    <div class="info badge badge-info">{{$info_tag}}</div>
                    @endif
                </div>
                <div class="overlay-lower">
                    <div class="py-20 px-30">
                        <div class="float-left">
                            <p class="mb-20 text-nowrap">
                                <span class="text-break">{{$description}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


