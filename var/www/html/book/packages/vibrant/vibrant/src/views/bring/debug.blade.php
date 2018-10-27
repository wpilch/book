@php
    $bring = view()->make('vibrant::bring.bring')->getPath();
    require($bring)
@endphp
@if($required)
   {{var_dump($imported_packages)}}
@endif