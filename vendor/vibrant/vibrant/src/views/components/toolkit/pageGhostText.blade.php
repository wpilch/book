<?php
/**
 * PageGhostText component
 *
 * This is a muted text you can use as placeholder for empty panels or tables.
 *
 * @category Layouts
 * @directive component
 * @version 1.0
 * @author E. Escudero <eescudero@aerobit.com>
 * @copyright E. Escudero <eescudero@aerobit.com>
 * @managed
 *
 * @slot default <i class='icon md-boat' style='font-size: 40px'></i><br>Your text with html goes here
 * @param string $class Custom class for the component|o
 */
?>

@bring('bs_theme_blueFlame')

<div class="@if(isset($class)){{$class}}@endif page to-the-top">
    <div class="page-content">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="ghost-text mt-80 font-weight-700 text-center">
                    {{$slot}}
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
