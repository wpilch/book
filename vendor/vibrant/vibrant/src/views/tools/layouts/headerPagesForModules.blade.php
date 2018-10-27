<?php
/**
 * Created by Edgar Escudero Ramírez.
 * Date: 27/05/2017
 * Time: 12:53 AM
 */
?>
<div class="page-header page-header-bordered page-header-top">
    <div class="page-header-top-box">
        <h1 class="page-title"><span class="text-mute">{{$item_type}}:</span> {{$item_name}}</h1>
        <div class="page-header-actions">
            {{$slot}}
        </div>
    </div>
</div>
<div class="page-options">
    {{$active_option_label}}
</div>