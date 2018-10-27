@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('codemirror@5.39.0')

@section('content')
    @include('vibrant::modules.partials._menu')
    <div class="page">
        <div class="container page-container">
            <h1 class="page-title pt-20">Add Components to Manager</h1>
            <div class="pt-30">
                <div class="panel fadeIn-onLoad">
                    <div class="panel-heading">
                        <h3 class="panel-title">¿HOW DOES IT WORK?</h3>
                    </div>
                    <div class="panel-body">
                        <p>Our component manager allows to show, in a clean and interactive UI, all the parameters accepted by a component, indicating if they are required or not,
                            displaying a description or tip text and, more importantly, permitting to change the parameters values and see the resultant component in real time.
                            Also, the UI shows the proper input control for every parameter and is capable to validate the inputs according to each component's documented rules.
                        </p>
                        <p>We put special care to make very easy adding new components to the manager. All you have to do is documenting your component following certain conventions.
                        </p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">EXAMPLE</h3>
                    </div>
                    <div class="panel-body">
                        <textarea class="code">@verbatim
/**
* NameOfComponent component
*
* Brief description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
*
* @directive component
* @managed
*
* @slot default <h3>This is the default slot with no name</h3>
* @slot name_of_custom_slot
*
* @param string $id Id of the element|e=exampleElement
* @param string:json $parameters Json or array of filters|o|e={"status":["active","inactive","blocked"]}
* @param bool:boolean $option On-off option|o|d=true|i=switch:{yes,no}|e=true
*/

Your component Blade/HTML code HERE

@endverbatim</textarea>
                        <p>It is really easy to get started. Check the components included in the package to get familiar with a little more advanced examples.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">PHPDOC BLOCK</h3>
                    </div>
                    <div class="panel-body">
                        <p>The component's phpdoc block must include the following elements in order to make it compatible with the component manager.</p>
                        <ul>
                            <li><span class="ita-bold-text">NAME</span> - The name of your component.</li>
                            <li><span class="ita-bold-text">DESCRIPTION</span> - A brief description of what your component does, it may include html markup.</li>
                            <li><span class="ita-bold-text">@directive</span> - What kind of blade directive your component will use (component or include). This tag is mandatory.</li>
                            <li><span class="ita-bold-text">@managed</span> - If this tag is not present, the component manager will ignore this component.</li>
                            <li><span class="ita-bold-text">@@slot</span> - In case your component uses the 'component' directive you may use this tag to interact with the slots included in your component.
                                <br>It uses the form: @@slot slot_name example_slot_content. Where slot_name should be 'default' for the anonymous blade slot of the component.</li>
                            <li><span class="ita-bold-text">@param</span> - Definition of every parameter accepted by the component. See below for more detail.</li>
                        </ul>
                        <p>With this information in its phpDoc, your component will be included in the component manager. The key to be able to play with your component in th CM is
                        in the <strong>@param</strong> tag. This key tag has the following structure:</p>
                            <span style="color: #00274f">&nbsp;&nbsp;&nbsp;&nbsp;@param</span><br>
                            <span style="color: #00274f">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;variable_type[:laravel_validation_parameter]</span><br>
                            <span style="color: #00274f">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$parameter_name</span><br>
                            <span style="color: #00274f">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[description][|o][|i=type_of_input:{comma_separated_input_parameters}][|d=default_value][|e=example_value]</span><br>
                        <div style="margin-left: 15px">
                            <p style="margin-bottom: 0px">Where:</p>
                            <ul>
                                <li><strong>variable_type</strong> - Php variable type (ie. string, array, bool)</li>
                                <li><strong>laravel_validation_parameter</strong> - If you wish to make server side validation of the input (ie. url, integer, array)</li>
                                <li><strong>description</strong> - Brief text for explanation or help on the parameter</li>
                                <li><strong>o</strong> - If included, the parameter is marked as optional</li>
                                <li><strong>i</strong> - Indicates the type of input to show at the UI, if not included the input will be text</li>
                                <li><strong>type_of_input</strong> - text, textarea, select:{options_separated_by_comma}, number:{min,max,step,units}, color, colorAlpha or switch:{on_label,off_label}</li>
                                <li><strong>d</strong> - Pass the default value of the parameter to the UI</li>
                                <li><strong>e</strong> - Pass the example value of the parameter to the UI</li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">OPTIONAL TAGS</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li><span class="ita-bold-text">@group</span> - Tells the UI to show the component as part of a specific group in the menu.
                                If not present the UI will include it in the 'General' group.</li>
                            <li><span class="ita-bold-text">@alias</span> - If your component has a blade alias you can tell the UI to use it by declaring this tag</li>
                            <li><span class="ita-bold-text">@link</span> - Optional tag to include a link in form of a button below the component description.
                                <br>It uses the form: @link url button_label</li>
                            <li><span class="ita-bold-text">@version</span> - Version of the component.</li>
                            <li><span class="ita-bold-text">@author</span> - Author of the component.</li>
                            <li><span class="ita-bold-text">@copyright</span> - Copyright notes of the component.</li>
                        </ul>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">COMPONENTS FOLDER</h3>
                    </div>
                    <div class="panel-body">
                        <p>You can use any view folder you want for your components files. By default, the CM will look for
                        custom components at:<br>
                        <strong style="margin-left: 30px">Resources/Views/Components</strong><br>
                        And therefore, it will use following view path for them:<br>
                        <strong style="margin-left: 30px">components.<span style="font-style: italic">you_component_file_name</span></strong><br>
                        </p>
                        <p>To change the custom component folder or add additional ones, go to the 'vibrant' file in the config folder
                            and modify the 'custom_components_paths' parameter to your needs.</p>
                    </div>
                </div>
            </div>
        </div>
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
@endsection
