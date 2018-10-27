@extends('layouts.vibrant')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')

@section('content')
    <div class="page">
        <div class="container page-container">
            <div class="panel p-30 fadeIn-onLoad">
            <h4>Szanowni Państwo,</h4>
                <p>Bardzo prosimy o uzupełnienie danych kontaktowych, dane poza numerem telefonu komórkowego będą dostępne publicznie. </p>
                <p>Numer telefonu komórkowego, będzie widoczny tylko po zalogowaniu dla pracowników Sekretariatu ds. ogólnych, i ma na celu ułatwienie kontaktu w pilnych sytuacjach.</p>
                <p>Wszelkie problemy z działaniem książki adresowej proszę zgłaszać na adres wojtek.pilch@uj.edu.pl</p>
                <p style="color:orangered;">Państwa dane będą widoczne po zatwierdzeniu ich przez pracownika Sekretariatu ds. ogólnych</p>
                @include('vibComponent::html.divider', [
    //optional parameters:
    //'class' => '',
    'width' => '100%',
    'thickness' => '2px',
    'style' => 'dotted',
    'color' => 'orangered',
    'margin_top' => '10px',
    'margin_bottom' => '10px'
])
                @VibForm([
                //required parameters:
                'form_id' => 'generalForm',
                //optional parameters:
                'fields' => '[
                {"row":"new","col_class":"col-sm-2","input":"select","name":"tytuł","label":"tytuł","placeholder":"tytuł",
                "items":[]},
                {"row":"same","col_class":"col-sm-4", "input":"text","name":"imię","label":"Imię","placeholder":"Imię", "required":true},
                {"row":"same","col_class":"col-sm-4", "input":"text","name":"nazwisko","label":"Nazwisko","placeholder":"Nazwisko", "required":true},
                {"row":"same","col_class":"col-sm-2","input":"select","name":"status","label":"Status zatrudnienia","placeholder":"status",
                "items":[]},
                {"row":"new","col_class":"col-sm-4","input":"email","name":"email","label":"Email","placeholder":"Email", "required":true},
                {"row":"same","col_class":"col-sm-4","input":"text","name":"telefon","label":"Telefon","placeholder":"Telefon"},
                {"row":"same","col_class":"col-sm-4","input":"text","name":"pokój","label":"Pokój","placeholder":"Pokój"},
                {"row":"new","col_class":"col-sm-4","input":"text","name":"komórka","label":"Telefon komórkowy","placeholder":"Komórka","tooltip_text":"Numer tylko na użytek sekretariatu, używany w nagłych przypadkach."},

                {"row":"new","col_class":"col-sm-4","input":"select","name":"grupa","label":"Grupa","placeholder":"Grupa",
                "items":[]}
                ]',
                'buttons' => '{
                    "submit":{"label":"Zapisz","btn_class":"btn-primary"},
                    "cancel":{"label":"Anuluj","btn_class":"btn-light","link":"/"}
                }',
                //'cancel_link' => '/',
                //'cancel_label' => '',
                //'submit_label' => '',
                //'buttons_alignment' => '',
                //'buttons_order' => '',
                //'method' => '',
                'form_action' => '/person/store',
                //'btn_loading_animated' => true,
                'make_ajax_request' => false,
                //'include_crsf_token' => true,
                //'bootstrap_validation' => true,
                //'html5_validation' => false,
                //'disabled' => false,
                'autocomplete' => true,
                //'inline' => false,
                //'inline_collapse_at' => 'sm',
                //'inline_label_width' => '2',
                //'inline_input_width' => '10',
                //'size' => '',
                //'text_error' => '',
                //'invalid_feedback' => '',
                //'required_indicator' => '*',
                'ajax_success_message' => 'Rekord został dodany.',
                //'success_ajax_callback' => '',
                //'error_ajax_callback' => '',
                //'locale_prefix' => '',
                //'form_class' => ''
                ])

                @endVibForm

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
        $(document).ready(function ($) {
            var options = {!! $title_options !!};
            $.each(options, function(key, value) {
                $("select[name='tytuł']")
                    .append($("<option></option>")
                        .attr("value",key)
                        .text(value));
            });
        });
        $(document).ready(function ($) {
            var options = {!! $building_options !!};
            $.each(options, function(key, value) {
                $("select[name='grupa']")
                    .append($("<option></option>")
                        .attr("value",key)
                        .text(value));
            });
        });
        $(document).ready(function ($) {
            var options = {!! $status_options !!};
            $.each(options, function(key, value) {
                $("select[name='status']")
                    .append($("<option></option>")
                        .attr("value",key)
                        .text(value));
            });
        });

    </script>
@endsection


