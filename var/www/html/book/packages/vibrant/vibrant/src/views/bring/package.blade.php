@php
    $custom_view = config('vibrant.bring_imports_blade_path').".".$package;
    $custom_view_exists = view()->exists($custom_view);
    $bring = view()->make('vibrant::bring.bring')->getPath();
    require($bring)
@endphp
@if($required === true)
    @if(empty($path))
        @if($custom_view_exists)
            @include($custom_view, ['version' => $version])
        @else
           @include("vibrant::imports.$package", ['version' => $version])
        @endif
    @else
        @include($path.".".$package, ['version' => $version])
    @endif
@endif

