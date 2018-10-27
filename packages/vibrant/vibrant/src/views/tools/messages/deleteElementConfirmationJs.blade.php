@if( (isset($trigger) && !empty($trigger)))
<script>
    $('{{$trigger}}').click(function(){
        var self = $(this);
        alertify.okBtn("{{__('vibrant::btn.delete')}}").cancelBtn("{{__('vibrant::btn.cancel')}}")
                .confirm("@if(!isset($message)) <strong>{{__('vibrant::btn.delete_element_confirmation')}}</strong> @else {!! $message !!} @endif", function () {
                    @if(isset($delete_key) && !empty($delete_key))
                        var element = self.attr('data-delete-key');
                    @endif
                    @if((isset($delete_url) && !empty($delete_url)))
                        var url = '{{$delete_url}}';
                    @else
                        var url = self.attr('data-delete-url');
                    @endif
                    var parameters = {
                        @if(isset($delete_key) && !empty($delete_key))
                            {{$delete_key}}: element,
                        @endif
                        _token: '{{csrf_token()}}'
                    }
                    postJS(url, parameters);
                })
    });
</script>
@endif
