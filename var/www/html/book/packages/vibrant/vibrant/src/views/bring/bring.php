<?php
    global $imported_packages;
    $required = true;
    if( $imported_packages === null || in_array($package, $imported_packages)){
        $required = false;
    }else{
        $imported_packages[] = $package;
    }



