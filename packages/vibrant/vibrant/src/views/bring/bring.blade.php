<?php
    global $imported_packages;
    $required = true;
    if( $imported_packages === null || (!empty($package) && in_array($package, $imported_packages))){
        $required = false;
    }else{
        if(!empty($package)){
            $imported_packages[] = $package;
        }
    }
