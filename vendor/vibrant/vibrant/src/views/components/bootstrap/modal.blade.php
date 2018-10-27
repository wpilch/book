<?php
/**
 * Modal component
 *
 * Add dialogs to your site for lightboxes, user notifications, or completely custom content.
 *
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $id Element Id|e=example-modal
 * @param string $btn_label Label of modal button, modal externally handled if empty|o|e=<i class='icon md-collection-text mr-2'></i>Launch modal
 * @param string $btn_class Classes to modify modal button|o|e=btn-primary
 * @param bool:boolean $lightbox_mode Show modal as lightbox|o|i=switch:{yes,no}|e=false
 * @param string $header Text of modal header|o|e=Modal header
 * @param string $btn_ok_label Label of modal's ok button|o|e=<i class='icon md-check mr-2'></i>Ok
 * @param string $btn_ok_class Classes to modify modal's ok button|o|e=btn-primary
 * @param string $btn_close_label Label of modal's cancel button|o|e=<i class='icon md-close mr-2'></i>Close
 * @param string $btn_close_class Classes to modify modal's cancel button|o|e=btn-secondary
 * @param string $class Custom class for this component|o|
 *
 * @slot default <blockquote>
Your html here! Lorem ipsum dolor sit amet, consectetuer
adipiscing elit. Aenean commodo ligula eget dolor.
Aenean massa <strong>strong</strong>. Cum sociis
natoque penatibus et magnis dis parturient montes,
nascetur ridiculus mus. Donec quam felis, ultricies
nec, pellentesque eu, pretium quis, sem. Nulla consequat
massa quis enim. Donec pede justo, fringilla vel,
aliquet nec, vulputate eget, arcu. In <em>em</em>
enim justo, rhoncus ut, imperdiet a, venenatis vitae,
justo. Nullam <a class="external ext" href="#">link</a>
dictum felis eu pede mollis pretium.
</blockquote>
 * @slot footer_html
 */

if(empty($btn_class)){
    $btn_class = 'btn-primary';
}
if(empty($lightbox_mode)){
    $lightbox_mode = false;
}
if(empty($btn_ok_class)){
    $btn_ok_class = 'btn-primary';
}
if(empty($btn_close_class)){
    $btn_close_class = 'btn-secondary';
}
?>

@bring('vibrant_bootstrap')

    @if(!empty($btn_label))
    <button type="button" class="btn {{$btn_class}}" data-toggle="modal" data-target="#{{$id}}">
        {!! $btn_label !!}
    </button>
    @endif

    <div class="modal @if(($lightbox_mode == true))modal-lightbox @endif @if(!empty($class)){{$class}} @endif fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="{{$id}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if(!empty($header) && $lightbox_mode != true)
                    <h5 class="modal-title" id="{{$id}}Label">{{$header}}</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{$slot}}
                </div>
                @if($lightbox_mode != true)
                    @if(!empty($footer_html) || !empty($btn_close_label) || !empty($btn_ok_label) )
                        <div class="modal-footer">
                            @if(!empty($btn_close_label))
                            <button type="button" class="action-cancel-{{$id}} btn {{$btn_close_class}}" data-dismiss="modal">{!! $btn_close_label !!}</button>
                            @endif
                            @if(!empty($btn_ok_label))
                            <button type="button" class="action-ok-{{$id}} btn {{$btn_ok_class}}">{!! $btn_ok_label !!}</button>
                            @endif
                            @if(!empty($footer_html))
                                {{$footer_html}}
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>


