@initBring
@extends('vibrant::layouts.barebone')

@bring('vibrant_utilities')

@section('body_attributes')style="height: auto; background-color: #f2f4f5;"@endsection

@section('content')
    <div class="in-iframe fadeIn-onLoad" style="margin: 15px">
    @if($directive == 'include')
        @include("$blade_path", $params)
    @elseif($directive == 'component')
        @component("$blade_path", $params)
            @foreach($slots as $key => $slot)
                @if(!empty($slot))
                    @if( $key === 'default')
                        {!! $slot !!}
                    @else
                        @slot($key)
                            {!! $slot !!}
                        @endslot
                    @endif
                @endif
            @endforeach
        @endcomponent
    @endif
    </div>
@endsection

@section('styles')
    @stack('framework_style')
    @stack('styles')
@endsection

@section('plugins')
    @stack('framework')
    @stack('plugins')
@endsection

@section('scripts')
    @stack('scripts')
    <script>
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode === 27) {
                //console.log('Esc key pressed iframe.');
                window.parent.document.onkeydown(evt);
            }
        }
    </script>
@endsection
