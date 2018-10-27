<div class="page-header page-header-top px-10">
    <div class="page-header-top-box">

        <div class="row">
            <div class="col-10 col-md-6 col-xl-7 header-title">

                @if(isset($breadcrumb)){{$breadcrumb}}@endif
                <h1 class="page-title">{{$page_title}}</h1>


            </div>
            <div class="col-2 col-md-6 col-xl-5 header-actions">
                <div class="page-header-actions">
                    {{$slot}}
                </div>
                @if(isset($options_select)){{$options_select}}@endif
            </div>
        </div>

    </div>
</div>
