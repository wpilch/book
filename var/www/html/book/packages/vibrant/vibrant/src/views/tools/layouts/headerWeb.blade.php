<div class="container">
    <div class="row">
        <div class="col-md-6 col-xl-7 header-title">
            @if(isset($breadcrumb)){{$breadcrumb}}@endif
            <h1 class="page-title">{{$page_title}}</h1>
        </div>
        <div class="col-md-6 col-xl-5 header-actions">
            <div class="page-header-actions">
                {{$slot}}
            </div>
            @if(isset($options_select)){{$options_select}}@endif
        </div>
    </div>
</div>
