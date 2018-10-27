<?php
/**
 * Navbar component
 *
 * Bootstrap’s powerful, responsive navigation header.
 *
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @param string $id Id of element|o
 * @param string $brandHtml Text or logo for branding|o|i=textarea|e=<span style="font-weight:300">App</span><strong>Brand</strong>
 * @param string $collapseAt Breakpoint at which the menu collapses, md if empty|o|i=select:[sm,md,lg,xl]
 * @param string $class Custom class for the component|o|
 *
 * @slot default <li class="nav-item active"><a class="nav-link"><i class='icon md-email mr-1'></i>Menu Item 1</a></li><li class="nav-item"><a class="nav-link"><i class='icon md-compass mr-1'></i>Menu Item 2</a></li><li class="nav-item"><a class="nav-link"><i class='icon md-globe mr-1'></i>Menu Item 3</a></li>
 * @slot extra_content
 */

if(!isset($collapseAt) || empty($collapseAt)){
    $collapseAt = 'md';
}
if(!isset($id) || empty($id)){
    $id = 'navbarSupportedContent';
}
if(!isset($extra_content)){
    $extra_content = '';
}
?>

@bring('vibrant_bootstrap')

<nav class="@if(isset($class)){{$class}}@endif navbar navbar-expand-{{$collapseAt}} navbar-light">
    @if(!empty($brandHtml))<a class="navbar-brand" href="#">{!! $brandHtml !!}</a>@endif
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#{{$id}}" aria-controls="{{$id}}" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="{{$id}}">
        <ul class="navbar-nav mr-auto">
            {{$slot}}
        </ul>
    </div>
    {{$extra_content}}
</nav>

