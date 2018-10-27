<?php
//required:
//- modal_body

if(!isset($modal_class)){
    $modal_class = '';
}
if(!isset($top_close_control)){
$top_close_control = '<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>';
}
?>
<!-- Modal -->
<div class="modal {{$modal_class}} fade" @if(isset($modal_id))id="{{$modal_id}}" aria-hidden="true" aria-labelledby="{{$modal_id}}"@endif
    @if(isset($modal_options)){{$modal_options}}@endif
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-sidebar modal-sm">
        <div class="modal-content">
            <div class="modal-header @if(isset($header_class)){{$header_class}}@endif">
                @if(isset($modal_header))
                    {{$modal_header}}
                @else
                    {{$top_close_control}}
                    @if(isset($modal_title))
                        <h4 class="modal-title">{{$modal_title}}</h4>
                    @endif
                @endif
            </div>
            <div class="modal-body @if(isset($body_class)){{$body_class}}@endif">
                {{$modal_body}}
            </div>
            @if(isset($modal_footer))
            <div class="modal-footer @if(isset($footer_class)){{$footer_class}}@endif">
                {{$modal_footer}}
            </div>
            @endif
        </div>
    </div>
</div>
<!-- End Modal -->
