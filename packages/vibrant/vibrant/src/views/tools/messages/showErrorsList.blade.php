<?php
    if(!isset($classes)){
        $classes = '';
    }
    if(!isset($dismissible)){
        $dismissible = false;
    }
    if(!isset($header)){
        $header = __('vibrant::shared.something_went_wrong');
    }
?>
@if ($errors->any())
    <div class="error-list {{$classes}}">
        <div class="error-list-header"> {!! $header !!} </div>
        <div class="alert alert-danger @if($dismissible) alert-dismissible fade show @endif" role="alert">
            @if($dismissible)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @endif
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

