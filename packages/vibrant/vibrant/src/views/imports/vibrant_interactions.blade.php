@bring('toastr@2.1.4')
@bring('ladda@1.0.6')
@bring('alertify@1.0.11')

@push('scripts')
    <script type="text/javascript" src="{{asset('vendor/vibrant/vibrant/global/js/vibrant-interactions.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                toastr.success('{!! session('success') !!}');
            @endif
            @if(session('error'))
                toastr.error('{!! session('error') !!}');
            @endif
            @if(session('info'))
                toastr.info('{!! session('info') !!}');
            @endif
            @if(session('warning'))
                toastr.warning('{!! session('warning') !!}');
            @endif
        }, false);
    </script>
@endpush
