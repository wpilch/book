<?php

namespace Vibrant\Vibrant;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class VibrantServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $vendor = 'vibrant';
        $app_name = 'backend';
        $package_tag = 'vibrant';
        $package_folder = 'vibrant';
        $package_name = 'vibrant';

        //Public assets
        $this->publishes([
            __DIR__.'/assets' => public_path("vendor/vibrant/vibrant"),
        ], 'vibrant_components_public_assets');

        //Config file
        $this->mergeConfigFrom(
            __DIR__."/config/$package_name.php", $package_tag
        );
        $this->publishes([
            __DIR__."/config/$package_name.php" => config_path("$package_name.php"),
        ], 'vibrant_components_config');

        //Translations
        $this->loadTranslationsFrom(__DIR__.'/lang', $package_tag);
        $this->publishes([
            __DIR__.'/lang' => resource_path("lang/vendor/$package_folder"),
        ], 'vibrant_components_translations');

        //Views
        $this->loadViewsFrom(__DIR__.'/views', $package_tag);
        $this->loadViewsFrom(__DIR__.'/views/components', 'vibComponent');
        $this->publishes([
            __DIR__.'/views' => resource_path("views/vendor/$package_folder"),
        ], 'vibrant_components_views');

        //Routes
        include __DIR__.'/routes/web.php';

        //Composer
        View::composer(
            "$package_tag::*", function ($view) use($package_name, $package_tag, $app_name, $vendor) {

            //Package details for views
            $group_name = 'apps';

            //Get calling controller and action
            $module_name = '';
            $action = app('request')->route()->getAction();
            if(!empty($action['controller'])) {
                $controller = class_basename($action['controller']);
                $controller_array = explode('@', $controller);
                $controller = $controller_array[0];
                $action = (!empty($controller_array[1])) ? $controller_array[1] : '';
                $module_name = strtolower(str_replace('Controller', '', $controller));
            }
            if(empty($module_name) || $module_name === 'view'){
                $view->with(compact('group_name', 'vendor', 'app_name', 'package_name', 'package_tag', 'action'));
            }else{
                $view->with(compact('group_name', 'vendor', 'app_name', 'package_name', 'package_tag', 'module_name', 'action'));
            }

        });

        //Blade
        Blade::component('vibrant::components.bootstrap.vibTable', 'VibTable');
        Blade::component('vibrant::components.bootstrap.vibForm', 'VibForm');
        //Bring
        Blade::include('vibrant::bring.init', 'initBring');
        Blade::include('vibrant::bring.debug', 'debugBring');
        Blade::directive('bring', function($expression)
        {
            if(empty($expression)){
                abort('500', 'Expression is missing');
            }
            $expression = substr($expression, 1, -1);
            $parameters = explode('|',$expression);
            $package_array = explode('@',$parameters[0]);
            $package = $package_array[0];
            unset($package_array[0]);
            $version = implode('@',$package_array);
            $path = '';
            unset($parameters[0]);
            foreach ($parameters as $parameter){
                $param_array = explode('=',$parameter);
                $key = $param_array[0];
                unset($param_array[0]);
                $value = implode('=',$param_array);
                switch ($key){
                    case 'version':
                        $version = $value;
                        break;
                    case 'path':
                        $path = $value;
                        break;
                    default:
                }
            }
            $view = "vibrant::bring.package";
            return "<?php echo \$__env->make('{$view}', array_except(get_defined_vars(), ['__data', '__path']))->with(['package'=>'{$package}', 'version'=>'{$version}', 'path' =>'{$path}'])->render(); ?>";
        });
    }

    public function register()
    {
        \Vibrant\Vibrant\Macros\Routing\Router::registerMacros();
    }
}
