<?php
/**
 * Accordion component
 *
 * Toggle the visibility of content.
 *
 * @directive include
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $id Element Id|e=accordion
 * @param array:json $items Json or array including Header, Icon(optional), Body(html) and Opened('true'/'false', optional)|i=textarea|e=[{"header":"Header one",
"icon":"md-smartphone-iphone",
"body": "<div class='text-center text-muted pb-1'><i class='icon md-boat' style='font-size: 38px'></i><br>Your html goes here</div>",
"opened":"true"},
{"header":"Header two",
"icon":"md-airplane",
"body":"<div class='text-center text-muted pb-1'><i class='icon md-boat' style='font-size: 38px'></i><br>Your html goes here</div>",
"opened":"false"},
{"header":"Header without icon",
"body":"<div class='text-center text-muted pb-1'><i class='icon md-boat' style='font-size: 38px'></i><br>Your html goes here</div>",
"opened":"false"}]
 * @param string $icon_open Icon to open accordion, 'md-chevron-down' if empty|o
 * @param string $icon_close Icon to close accordion, 'md-chevron-up' if empty|o|e=md-minus
 * @param string $class Custom class for this component|o
 */

if(!is_array($items)){
    $items = json_decode($items, true);
};
if(empty($icon_open)){
    $icon_open = 'md-chevron-down';
};
if(empty($icon_close)){
    $icon_close = 'md-chevron-up';
};
?>

@bring('vibrant_bootstrap')

<div id="{{$id}}" class="accordion @if(!empty($class)) {{$class}} @endif">
    @php $items_count = count($items); $counter = 0; @endphp
    @foreach($items as $item)
        @php($counter++)
        <div class="card @if(!empty($item['opened']) && $item['opened'] == 'true')is-open @endif">
            <div class="card-header" id="heading{{$counter}}">
                <h5 class="card-header-block mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$counter}}" @if(!empty($item['opened']) && $item['opened'] == 'true')aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$counter}}">
                        @if(!empty($item['icon']))<i class="icon {{$item['icon']}} mr-1"></i> @endif {{$item['header']}}<i class="open-icon icon {{$icon_open}} mr-3"></i><i class="close-icon icon {{$icon_close}} mr-3"></i>
                    </button>
                </h5>
            </div>

            <div id="collapse{{$counter}}" class="collapse @if(!empty($item['opened']) && $item['opened'] == 'true')show @endif" aria-labelledby="heading{{$counter}}" data-parent="#{{$id}}">
                <div class="card-body">
                    {!! $item['body'] !!}
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>
        $('#{{$id}}').on('shown.bs.collapse', function () {
            $('#{{$id}}').find('.card').each(function(index, item){
                if($(item).find('.collapse').hasClass('show')){
                    $(item).addClass('is-open');
                }else{
                    $(item).removeClass('is-open');
                }
            });
        });
        $('#{{$id}}').on('hidden.bs.collapse', function () {
            $('#{{$id}}').find('.card').each(function(index, item){
                if($(item).find('.collapse').hasClass('show')){
                    $(item).addClass('is-open');
                }else{
                    $(item).removeClass('is-open');
                }
            });
        });
    </script>
@endpush
