@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('vibrant_utilities')

@section('content')
    @include('vibrant::modules.partials._menu')
    <div class="page fadeIn-onLoad">
        <div class="container-fluid page-container">
            <div class="panel p-30">
                <h4>{{ucfirst(__('vibrant::shared.table_of_items', ['items' => __('vibrant::shared.data')]))}}</h4>
                @VibTable($table_settings)
                    <!-- Examples of customization: -->
                    @slot('action_column_buttons')
                        <button class="action-custom dropdown-item" role="menuitem"><i class="icon md-favorite mr-2" aria-hidden="true"></i>Custom</button>
                    @endslot
                    @slot('action_bar_buttons')
                        <button class="action-bulk-custom float-left mr-1 btn btn-secondary"><i class="icon md-favorite" aria-hidden="true"></i></button>
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
    <script>
        //Examples of customization:
        //Behavior of the action column buttons included in 'action_column_buttons' slot
        window.actionColumnEvents = {
            'click .action-custom': function (e, value, row) {
                console.log(row);
                alert('custom action');
            }
        };
        //Behavior of the top buttons shown when one or more row's checkboxes are selected (included in 'action_bar_buttons' slot)
        $('.action-bulk-custom').click(function(){
            let items = $actionbar.attr('data-items');
            console.log(items);
            alert('custom bulk action');
        });
    </script>
    @stack('scripts')
@endsection
