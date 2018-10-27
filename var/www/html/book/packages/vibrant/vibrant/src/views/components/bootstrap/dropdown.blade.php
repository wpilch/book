<?php
/**
 * Dropdown component
 *
 * Toggle contextual overlays for displaying lists of links.
 *
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @slot <div class="text-center text-muted pb-1"><i class='icon md-boat' style='font-size: 38px'></i><br>Your html goes here</div>
 *
 * @param string $id Element Id|e=example-dropdown
 * @param string $label Dropdown button label|e=Dropdown button
 * @param array:json $items Json or array including Label, Icon(optional), Link(url,optional) and Status(optional), use 'divider' for a separation, and 'header' for section labels|i=textarea|e=[
{"label":"Action",
"link":"http://yourapp.com/home"},
{"header":"Group name"},
{"label":"Grouped option",
"link":"http://yourapp.com/home/library/data1"},
{"label":"Disabled option",
"status": "disabled",
"link":"http://yourapp.com/home/library"},
"divider",
{"label":"Delete",
"icon":"icon md-delete"}]
 * @param bool:boolean $split Split dropdown button|o|i=switch:{yes,no}|e=false
 * @param string $variant Dropdown button variant, primary if empty|o|i=select:{primary,secondary,success,info,warning,danger}|e=primary
 * @param string $direction Direction of the dropdown menu|o|i=select:{normal,dropup,dropright,dropleft}
 * @param string $alignment Alignment of the dropdown menu|o|i=select:{left,right}
 * @param string $size Size of dropdown button|o|i=select:{normal,sm,lg}
 * @param bool:boolean $block Make dropdown button full width|o|i=switch:{yes,no}|e=false
 * @param string $button_attributes Special options for the component e.'data-offset' |o
 * @param string $class Custom class for the component|o
 */


if(!is_array($items)){
    $items = json_decode($items, true);
};
if(empty($variant)){
    $variant = 'primary';
}
if(empty($direction) || !in_array($direction, ['dropup','dropright','dropleft'])){
    $direction = '';
}
if(empty($alignment) || $alignment != 'right'){
    $alignment = '';
}
if(empty($size) || !in_array($size, ['sm','lg'])){
    $size = '';
}
if(!isset($block)){
    $block = false;
}
if(!isset($split) || $split !== true){
    $split = false;
}

/*Additional available slots:
$bottom_html
*/
?>

@bring('vibrant_bootstrap')

<div id="{{$id}}" class="dropdown @if(isset($class)){{$class}}@endif">
    <div class="btn-group @if(!empty($direction)){{$direction}}@endif @if($block === true)btn-block @endif">
        @if($split)
            <button class="main-btn btn btn-{{$variant}} @if(!empty($size))btn-{{$size}}@endif @if($block === true)btn-block @endif" type="button">
                {!! $label !!}
            </button>
        @endif
        <button class="btn btn-{{$variant}} @if(!empty($size))btn-{{$size}}@endif @if(!$split) @if($block === true)btn-block @endif @endif dropdown-toggle @if($split)dropdown-toggle-split @endif" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @if(!empty($button_attributes)){{$button_attributes}}@endif >
            @if(!$split){!! $label !!}@else<span class="sr-only">Toggle Dropdown</span>@endif
        </button>
        <div class="dropdown-menu @if(!empty($alignment)) dropdown-menu-{{$alignment}} @endif">
            {{$slot}}
            @foreach($items as $item)
                @if(!empty($item['label']))
                    <a class="dropdown-item action-{{$item['label']}} @if(!empty($item['status'])) {{$item['status']}} @endif" @if( !( empty($item['link']) || (!empty($item['status']) && $item['status'] == 'disabled') ) ) href="{{$item['link']}}" @endif> @if(!empty($item['icon'])) <i class="{{$item['icon']}} mr-1"></i> @endif {{$item['label']}}</a>
                @else
                    @if(!empty($item['header']))
                        <span class="dropdown-header">{{$item['header']}}</span>
                    @else
                        <div class="dropdown-divider"></div>
                    @endif
                @endif
            @endforeach
            @if(!empty($bottom_html))
                {{$bottom_html}}
            @endif
        </div>
    </div>
</div>

