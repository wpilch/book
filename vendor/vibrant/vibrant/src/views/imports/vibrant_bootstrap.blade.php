@bring('bootstrap@4.1.1')
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/vibrant/vibrant/global/css/bootstrap/vibrant-bootstrap.css')}}">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{asset('vendor/vibrant/vibrant/global/js/bootstrap/vibrant-bootstrap.js')}}"></script>
@endpush
@bring('vibrant_utilities')
