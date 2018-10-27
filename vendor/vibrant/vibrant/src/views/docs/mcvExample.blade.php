@extends('vibrant::layouts.app')

@initBring
@bring('vibrant_bootstrap')
@bring('bs_theme_blueFlame')
@bring('codemirror@5.39.0')

@section('content')
    @include('vibrant::modules.partials._menu')
    <div class="page">
        <div class="container page-container">
            <h1 class="page-title pt-20">CRUD in 3 Steps </h1>
            <div class="pt-30">
                <div class="panel fadeIn-onLoad">
                    <div class="panel-heading">
                        <h3 class="panel-title">STEP 1. THE MODEL</h3>
                    </div>
                    <div class="panel-body">
                        <p>You can create powerful tables and CRUD fast and easy from any Laravel model class.
                            To accomplish this, first thing to do is to include the Vibrant Tablable
                            trait in your model. For example:</p>
                        <textarea class="code">
use Illuminate\Database\Eloquent\Model;
use Vibrant\Vibrant\Traits\Tablable;

class FakeSubscriber extends Model
{
    use Tablable;

    /* Your model class code */
}</textarea>
                        <p>Now, there are a few mandatory protected properties and constants you also have to include in your model. These are:</p>
                        <ul>
                            <li><strong>$searchable_fields</strong> - (array) Fields to include in queries when a search is performed.</li>
                            <li><strong>$available_fields</strong> - (array) Fields that will be available to show in the html table, these can be from the model's original table or appended attributes.</li>
                            <li><strong>$hidden_fields</strong> - (array) Fields included in the available fields array that are hidden by default. Users can toggle its visibility.</li>
                            <li><strong>$unsortable_fields</strong> - (array) Fields included in the available fields array that table cannot be sorted by.</li>

                        </ul>
                        <p>Your model now will look something similar to this:</p>
                        <textarea class="code">
class FakeSubscriber extends Model
{
    use Tablable;

    protected $searchable_fields = ['uid', 'first_name', 'last_name', 'email', 'phone', 'status' ];
    protected $available_fields = ['uid', 'first_name', 'last_name', 'email', 'gender', 'dob', 'phone', 'status', 'created_at', 'updated_at'];
    protected $unsortable_fields = ['phone'];
    protected $hidden_fields = ['created_at', 'updated_at'];

    /* Your model class code */
}</textarea>
                        <p>Let's declare our CRUD form right here. Yes! We can do this thanks to the vibForm component that accepts an array of fields and its parameters.
                            Notice how we are even telling the <span style="font-style: italic">VIEW</span> how to present this form. You can do this right at the Model,
                            at the Controller or at the View, it's really up to you.</p>
                        <textarea class="code">
/**
 * Example of a MCV FORM defined at the Model
 **/
public $form_fields = [
    'first_name' => ['row' => 'new', 'col_class' => 'col-sm-6', 'required' => true ],
    'last_name' => ['row' => 'same', 'col_class' => 'col-sm-6' ],
    'email' => ['row' => 'new', 'input' => 'email', 'col_class' => 'col-sm-8', 'required' => true ],
    'phone'=> ['row' => 'same', 'col_class' => 'col-sm-4' ],
    'gender'=> ['row' => 'new', 'col_class' => 'col-sm-4', 'input' => 'select',
        'items' => [
            ['label' => 'male', 'value' => 'male' ],
            ['label' => 'female', 'value' => 'female' ]
        ]
    ],
    'dob'=> ['row' => 'same', 'col_class' => 'col-sm-4', 'input' => 'datepicker', 'placeholder' => 'yyyy-mm-dd' ],
    'status'=> ['row' => 'same', 'col_class' => 'col-sm-4', 'input' => 'select',
        'items' => [
            ['label' => 'active', 'value' => 'active'],
            ['label' => 'inactive', 'value' => 'inactive'],
            ['label' => 'blocked', 'value' => 'blocked'],
        ]
    ],
    'uid'=>['input' => 'range']
];</textarea>



                        <p>That's all we need in our model for the basic set up. Not a big deal right?. More advanced implementations include declaring your own custom methods for searching, filtering and sorting. Please check the example files included in the package for more details
                            on options and customizations.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">STEP 2. THE CONTROLLER</h3>
                    </div>
                    <div class="panel-body">
                        <p>To make things really easy and quick we will just extend the provided CrudController and define a couple of things at the children's constructor.</p>
                        <textarea class="code">
use Vibrant\Vibrant\Controllers\CrudController as Controller;
use Illuminate\Http\Request;

class FakeSubscribersController extends Controller
{
    public function __construct()
    {
        $model = new FakeSubscriber(); //Data model
        $view_prefix = "vibrant::examples.crud"; //Prefix for the path of the CRUD blade views
        parent::__construct($model, $view_prefix);
    }
}</textarea>
                        <p>We just defined the model we want to CRUD and the path of the blade views that will handle the UI.</p>
                        <p>That's all we need for a basic controller. Again, if you're looking for more tips please check the provided controller in the examples folder.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">STEP 3. THE VIEW</h3>
                    </div>
                    <div class="panel-body">
                        <p>The final step in our road to a beauty and powerful CRUD is the View. Fortunately, the vibTable component and the work done in the previous steps make
                            our live easier now and we only have to worry about the table's look and behavior and not about the data it shows.
                            Play with the options in the component manager to get the settings exactly as you need it. Below you will see an example of the couple of lines you need to include
                            in your views.
                        </p>
                        <textarea class="code">
//index.blade.php - Records' table.
//... your page layout and content...
@verbatim@VibTable(array_merge($table_settings, [
        //You custom settings if need it. Example:
        //'include_card_view_toggle' => false,
        //'include_export' => false,
        //...
        ]))
@endVibTable @endverbatim</textarea>
                        <textarea class="code">
//create.blade.php - Create record form.
//... your page layout and content...
@verbatim@VibForm($form_settings) @endVibForm@endverbatim</textarea>
                        <textarea class="code">
//edit.blade.php - Edit record form.
//... your page layout and content...
@verbatim@VibForm($form_settings) @endVibForm@endverbatim</textarea>
                        <p>Notice that edit and create forms are called the same way at the view, just the passed $form_settings array is a little bit different.
                            These arrays ($table_settings and $form_settings) are create and passed to our views automatically.</p>
                        <p><span class="badge badge-lg badge-success">TIP</span> Remember to have a look to the example files to check the view conventions we used to make everything flow seamlessly.</p>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">EXTRA TIP: ROUTES SHORTCUT</h3>
                    </div>
                    <div class="panel-body">
                        <p>You don't need to worry about creating repetitive routes either. Use the provided 'crud' shortcut and get everything routed in a single line of code. For example:</p>
                        <textarea class="code">
//This creates default crud routes with for our FakeSubscribersController example
Route::crud('examples/crud', 'FakeSubscribersController');</textarea>
                        <p>We are all set. Check the result <a class="link" href="/backend/examples/crud" target="_blank">here</a>. </p>
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
