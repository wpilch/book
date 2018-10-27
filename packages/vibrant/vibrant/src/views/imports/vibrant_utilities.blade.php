@bring('es6-shim')
@bring('axios')
@bring('get-form-data')
@bring('postJs')
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/vibrant/vibrant/global/css/vibrant-utilities.css')}}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{asset('vendor/vibrant/vibrant/global/js/vibrant-utilities.js')}}"></script>
@endpush
