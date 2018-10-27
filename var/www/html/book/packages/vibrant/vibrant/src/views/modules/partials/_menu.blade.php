@php
    $class = (!empty($right_spot)) ? 'navbar-with-right-spot' : '';
@endphp
@component('vibComponent::bootstrap.navbar', compact('class'))
    <li class="nav-item @if(isset($module_name) && $module_name == 'components') active @endif">
        <a class="nav-link" href="{{route('backend.components')}}">{{ucfirst(__('vibrant::vibrant.components'))}}</a>
    </li>
    <li class="nav-item @if(isset($module_name) && $module_name == 'add_components') active @endif">
        <a class="nav-link" href="{{route('backend.docs.add_components')}}">{{ucfirst(__('vibrant::vibrant.add_components'))}}</a>
    </li>
    <li class="nav-item @if(isset($module_name) && $module_name == 'fakesubscribers') active @endif">
        <a class="nav-link" href="/backend/examples/crud">{{ucfirst(__('vibrant::vibrant.crud_example'))}}</a>
    </li>
    <li class="nav-item @if(isset($module_name) && $module_name == 'mcv_example') active @endif">
        <a class="nav-link" href="{{route('backend.docs.mcv_example')}}">{{ucfirst(__('vibrant::vibrant.implement_mcv'))}}</a>
    </li>
    <li class="nav-item @if(isset($module_name) && $module_name == 'view_tools') active @endif">
        <a class="nav-link" href="{{route('backend.docs.view_tools')}}">{{ucfirst(__('vibrant::vibrant.guide_for_views'))}}</a>
    </li>
    @slot('extra_content')
        @if(!empty($right_spot))
        <div class="navbar-right-spot">
            {!! $right_spot !!}
        </div>
        @endif
    @endslot
@endcomponent

