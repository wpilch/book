@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('vibrant_utilities')

@section('content')

    <div class="page fadeIn-onLoad">
        <div class="container-fluid page-container">
            <div class="panel p-30">
                <h4>Książka adresowa</h4>
                @VibTable($table_settings)
                @slot('action_column_buttons')
                    <button class="action-accept dropdown-item" role="menuitem"><i class="icon md-check mr-2"
                                                                                   aria-hidden="true"></i>Accept
                    </button>
                @endslot
                @slot('action_bar_buttons')
                    <button class="action-bulk-accept float-left mr-1 btn btn-secondary"><i class="icon md-check"
                                                                                            aria-hidden="true"></i>
                    </button>
                @endslot
                @endVibTable
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @stack('framework_style')
    @stack('styles')
    <!-- Your custom styles here! -->
@endsection

@section('plugins')
    @stack('framework')
    @stack('plugins')
    <!-- Your custom plugins here! -->
@endsection

@section('scripts')
    @stack('scripts')
    <script>
        window.actionColumnEvents['click .action-accept'] = function (e, value, row) {
            alertify.okBtn("Accept").cancelBtn("{{__('vibrant::btn.cancel')}}")
                .confirm("<strong>Please confirm you want to accept item.</strong>", function () {
                    let url = '{{ url('/backend/person/crud') }}/accept/'+row.id;
                    let param = {
                        _token: '{{csrf_token()}}',
                        _method: 'post'
                    };
                    postJS(url, param);
                });
        };
        $('.action-bulk-accept').click(function(){
            alertify.okBtn("Accept").cancelBtn("{{__('vibrant::btn.cancel')}}")
                .confirm("<strong>Please confirm you want to accept items.</strong>", function () {
                    let items = $actionbar.attr('data-items');
                    let url = '{{ url('/backend/person/crud') }}'+'/bulkAccept';
                    let parameters = {
                        items: items,
                        _token: '{{csrf_token()}}'
                    };
                    postJS(url, parameters);
                });
        });
    </script>
@endsection
