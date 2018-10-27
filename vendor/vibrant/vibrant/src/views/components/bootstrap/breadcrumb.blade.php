<?php
/**
 * Breadcrumb component
 *
 * Indicate the current page’s location within a navigational hierarchy that automatically adds separators via CSS.
 *
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param array:json $items Json or array including Label, Link(url,optional)|i=textarea|e=[{"label":"Home",
    "link":"http://yourapp.com/home"},
    {"label":"Library",
    "link":"http://yourapp.com/home/library"},
    {"label":"Data",
    "link":"http://yourapp.com/home/library/data"}]
 * @param string $class Custom class for the component|o
 */

if(!is_array($items)){
    $items = json_decode($items, true);
};
?>

@bring('vibrant_bootstrap')

<nav aria-label="breadcrumb @if(isset($class)){{$class}}@endif">
    <ol class="breadcrumb">
        @php $items_count = count($items); $counter = 0; @endphp
        @foreach($items as $item)
            @php($counter++)
            @if($counter == $items_count)
                <li class="breadcrumb-item active" aria-current="page">{{$item['label']}}</li>
            @else
                <li class="breadcrumb-item"><a @if(!empty($item['link'])) href="{{$item['link']}}" @endif> {{$item['label']}}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
