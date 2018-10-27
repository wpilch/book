@bring('select2')
@push('styles')
    <link href="{{asset('vendor/vibrant/vibrant/global/vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet" />
@endpush
@push('scripts')
    <script>
        jQuery(document).ready( function (){
            initBSelect2();
        });

        function initBSelect2() {
            let select2options = {
                theme: 'bootstrap4'
            };
            jQuery("select").each(function (index) {
                if(jQuery(this).attr('data-plugin') === 'bSelect2'){
                    if(typeof jQuery(this).attr('data-placeholder') !== typeof undefined){
                        select2options.placeholder = jQuery(this).attr('data-placeholder');
                    }
                    if(typeof jQuery(this).attr('data-clearable') !== typeof undefined && jQuery(this).attr('data-clearable') === 'true'){
                        select2options.allowClear = true;
                    }else{
                        select2options.allowClear = false;
                    }
                    if(typeof jQuery(this).attr('data-selection-limit') !== typeof undefined){
                        select2options.maximumSelectionLength = Number(jQuery(this).attr('data-selection-limit'));
                    }
                    select2options.width = '100%';
                    jQuery(this).select2(select2options);
                }
            });
        }
    </script>
@endpush

