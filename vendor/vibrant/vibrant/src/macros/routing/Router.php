<?php

namespace Vibrant\Vibrant\Macros\Routing;
use Illuminate\Support\Facades\Route as DefaultRouter;


/**
 *
 */
class Router
{
    public static function registerMacros()
    {
        if (!DefaultRouter::hasMacro('crud')) {
            DefaultRouter::macro('crud', function ($url, $controller, $parameters_names = []) {
                DefaultRouter::group([], function () use ($url, $controller, $parameters_names) {
                    $nested_parameters = explode('.', $url);
                    $nested_parameters_counter = count($nested_parameters);
                    if($nested_parameters_counter > 1){
                        $urlOrNested = '';
                        $i = 1;
                        foreach ($nested_parameters as $nested_parameter){
                            if($i == $nested_parameters_counter ){
                                $urlOrNested .= '/'.$nested_parameter;
                            }else{
                                if(!empty($parameters_names[$nested_parameter])){
                                    $urlOrNested .= '/'.$nested_parameter.'/{'.$parameters_names[$nested_parameter].'}';
                                }else{
                                    $urlOrNested .= '/'.$nested_parameter.'/{'.str_singular($nested_parameter).'}';
                                }
                            }
                            $i++;
                        }
                        $nameBase = strtolower($url);
                    }else{
                        $urlOrNested = $url;
                        $nameBase = strtolower(str_replace($url,'/','.'));
                    }
                    DefaultRouter::get($urlOrNested . '/listing', $controller . '@listing')->name($nameBase.'.listing');
                    DefaultRouter::post($urlOrNested . '/bulkDelete', $controller . '@bulkDelete')->name($nameBase.'.bulkDelete');
                    if(count($parameters_names) > 0){
                        DefaultRouter::resource($url, $controller)->parameters($parameters_names);
                    }else{
                        DefaultRouter::resource($url, $controller);
                    }
                });
            });
        }
    }
}
