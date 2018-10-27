<?php
/**
 * VibrantTools class.
 *
 * Tool class with a variety of helper methods
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Library;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ViewErrorBag;
use Vibrant\Vibrant\Packages\DocBlock\DocBlock;

class VibrantTools
{

    public static function getHiddenColumnsFromCookie($table_name){
        $cookieHiddenColumns = Cookie::get("$table_name"."_HiddenColumns");
        $preferredHidden = (empty($cookieHiddenColumns)) ? null : (($cookieHiddenColumns == '_empty') ? [] : explode(",", $cookieHiddenColumns));
        return $preferredHidden;
    }

    public static function getTableSettingsFromModel($tablable_model, $preferredHiddenColumns = null){
        list($available_fields, $unsortable_fields, $hidden_fields) = $tablable_model->tableFields();
        if(!is_null($preferredHiddenColumns)){
            $hidden_fields = $preferredHiddenColumns;
        }
        $filters = $tablable_model->tableFilters();
        $filter_all_keyword = $tablable_model::$filter_all_keyword;
        $table_settings = compact('available_fields', 'unsortable_fields', 'hidden_fields', 'filters', 'filter_all_keyword');
        return $table_settings;
    }

    public static function getListFromModel($tablable_model, Request $request, Bool $force_id_request, $query = ''){
        //Init
        $table = $tablable_model->getTable();
        //Filters
        $filters = (!empty($tablable_model->tableFilters())) ? array_keys($tablable_model->tableFilters()) : null;
        if(count($filters) > 0) {
            foreach ($filters as $filter) {
                if (!(empty($request->$filter) || $request->$filter == $tablable_model::$filter_all_keyword)) {
                    $query = $tablable_model->filterBy([$filter => $request->$filter], $query);
                }
            }
        }
        //Search keywords
        if( $request->has('search') && !( empty($request->search) )){
            $query = $tablable_model->searchBy($request->search, $query);
        }
        //Execute query with optional sort and pagination
        $list = $tablable_model->doQuery($query, $request->limit, "$table.$request->sort_order", $request->sort_direction, $force_id_request);

        return $list;
    }

    public static function getEditFormFieldsFromModel($resource, ViewErrorBag $errors = null){
        if(isset($resource->form_fields)){
            $fields_parameters = $resource->form_fields;
        }else{
            if(method_exists($resource, 'getFormFields')){
                $fields_parameters = $resource->getFormFields();
            }
        }
        if(!isset($fields_parameters) || count($fields_parameters) == 0){
            return [];
        }

        $form_fields = [];
        foreach ($fields_parameters as $field => $field_parameters){
            if(
                (isset($field_parameters['crud_exclude']) && $field_parameters['crud_exclude'] == 'edit') ||
                (isset($field_parameters['crud_only_for']) && $field_parameters['crud_only_for'] != 'edit' )
            ){ continue; }

            $error_msg = '';
            if (!empty($errors) && $errors->has($field)) {
                $error_msg = $errors->first($field);
            }
            $form_fields[] = array_merge( $field_parameters, [
                'name' => $field,
                'value' => $resource->$field,
                'text_error' => $error_msg
            ]);
        }

        return $form_fields;
    }

    public static function getCreateFormFieldsFromModel($resource, ViewErrorBag $errors = null, $scope = null){
        if(isset($resource->form_fields)){
            $fields_parameters = $resource->form_fields;
        }else{
            if(method_exists($resource, 'getFormFields')){
                $fields_parameters = $resource->getFormFields();
            }
        }
        if(!isset($fields_parameters) || count($fields_parameters) == 0){
            return [];
        }
        $form_fields = [];

        foreach ($fields_parameters as $field => $field_parameters){
            if(
                (isset($field_parameters['crud_exclude']) && $field_parameters['crud_exclude'] == 'create') ||
                (isset($field_parameters['crud_only_for']) && $field_parameters['crud_only_for'] != 'create' )
            ){ continue; }
            $error_msg = '';
            if (!empty($errors) && $errors->has($field)) {
                $error_msg = $errors->first($field);
            }
            $field_data = [
                'name' => $field,
                'text_error' => $error_msg
            ];
            if(isset($scope[$field])){
                $field_data['value'] = $scope[$field];
            }
            $form_fields[] = array_merge( $field_parameters, $field_data);
        }

        return $form_fields;
    }

    public static function getRulesFromModel($model, $method = null){
        $rules = [];
        if(isset($model::$rules)){
            $rules = $model::$rules;
        }else{
            if(method_exists($model, 'getRules')){
                $rules = $model->getRules($method);
            }
        }
        return $rules;
    }



    //Removes question mark from url
    public static function cleanUrl($url){
        if(ends_with($url,'?')){
            $url = substr($url, 0, -1);
        }
        return $url;
    }

    /**
     * Returns a message array with success if file's type and extension are among the passed parameters
     *
     * @param string $filePath
     * @param array $validTypes - e.g. ['text/plain','text/csv']
     * @param array $validExtensions - e.g. ['txt', 'csv']
     * @return array
     */
    public static function validateFileTypeAndExtension(string $filePath, array $validTypes = [], array $validExtensions = []){
        //does the files actually exists??
        if( !File::exists($filePath) ) {
            return array('error' => 'File does not exist');
        }else{
            //will check both extension and MimeType
            $ext = File::extension($filePath);
            $fileType = File::mimeType($filePath);
            //check fileType
            if(!in_array($fileType, $validTypes)){
                $error = 'File is an invalid type: '.$fileType;
                return array('error' => $error);
            }
            //check ext
            if(!in_array($ext, $validExtensions)){
                $error = 'File has an invalid extension: '.$ext;
                return array('error' => $error);
            }
        }
        return array('success' => 'Type and extension are ok');
    }

    /**
     * Convert bytes value (string) to k m g t or p
     *
     * @param $size
     * @return string
     */
    public static function convertBytes($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    /**
     * Prepends a string to all keys in array
     *
     * @param $array
     * @param $prepend
     * @return array
     */
    public static function prepend_to_array_keys($array, $prepend){
        $newArray = [];
        foreach ($array as $oldKey => $value){
            $newArray[$prepend.$oldKey] = $value;
        }
        return $newArray;
    }

    /**
     * Removes items from first array which keys are not in second array
     *
     * @param array $target
     * @param array $theseKeysOnly
     */
    public static function remove_keys_not_in_array(array &$target, array $theseKeysOnly){
        $targetKeys = array_keys($target);
        $keysToRemove = array_diff($targetKeys, $theseKeysOnly);
        foreach ($keysToRemove as $keyToRemove){
            if(isset($target[$keyToRemove])){
                unset($target[$keyToRemove]);
            }
        }
    }

    /**
     * Cast valid date format and converts it to standard YYYY-MM-DD format, returns blank if cant
     *
     * @param string
     * @return string
     */
    public static function makeValidDateOrBlank($string) {
        //check if format is AAAA-MM-DD
        $d = \DateTime::createFromFormat('Y-m-d', $string);
        if(!($d && $d->format('Y-m-d') === $string)){
            //check if format is AAAA-M-D
            $d = \DateTime::createFromFormat('Y-n-j', $string);
            if(!($d && $d->format('Y-n-j') === $string)){
                //check if format is DD/MM/AAAA
                $d = \DateTime::createFromFormat('d/m/Y', $string);
                if(!($d && $d->format('d/m/Y') === $string)) {
                    //check if format is D/M/AAAA
                    $d = \DateTime::createFromFormat('d/m/Y', $string);
                    if(!($d && $d->format('j/n/Y') === $string)) {
                        return '';
                    }
                }
            }
        }
        return $d->format('Y-m-d');

    }

    /**
     * Cast numeric format for importing files, returns blank if cant
     *
     * @param string
     * @return string
     */
    public static function makeValidNumberOrBlank($string) {
        if(is_numeric($string)) {
            return $string;
        } else {
            return '';
        }
    }

    /**
     * Basic logging
     *
     * @param $log_path
     * @param $log_data
     * @return bool
     */
    public static function addLog($log_path, $log_data){
        if( ! (empty($log_path) || empty($log_data)) ){
            if (!is_dir(dirname($log_path))) {
                mkdir($log_path, 0777, true);
            }
            File::append($log_path, $log_data . "\n");
        }
        return false;
    }

    /**
     * Cast options to feed a select component from a given collection
     *
     * @param Collection $collection
     * @param $value_key
     * @param $label_key
     * @param bool $include_all
     * @param null $all_label
     * @return array|null
     */
    public static function getSelectOptions(Collection $collection, $value_key, $label_key, $include_all = false, $all_label = null){
        $options = null;
        if($include_all == true){
            if(empty($all_label)){
                $options[] = ['value' => '_all', 'label' => __('vibrant::shared.all_items')];
            }else{
                $options[] = ['value' => '_all', 'label' => $all_label];
            }
        }
        if(!empty($collection)){
            foreach ($collection as $item) {
                $options[] = ['value' => $item->$value_key, 'label' => $item->$label_key];
            }
        }
        return $options;
    }

    /**
     * Calculates how many minutes left until the current day finish
     *
     * @param null $time_zone
     * @return int
     */
    public static function minutesLeftForTheDay($time_zone = null){
        $now = (!empty($time_zone)) ? Carbon::now($time_zone) : Carbon::now();
        $end_of_day = Carbon::tomorrow($time_zone)->startOfDay();
        return $now->diffInMinutes($end_of_day);
    }

    /**
     * Get the storage absolute path from a given Url
     *
     * @param $url - Url of asset
     * @return bool|string - false if path was not found, otherwise returns path as string
     */
    public static function getStoragePathFromUrl($url){
        $url_array = explode('storage/', $url, 2);

        if(isset($url_array[1])) {
            $path = storage_path("app/public/".$url_array[1]);
            return $path;
        }

        return false;
    }

    /**
     * Get the storage relative path from a given Url
     * @param $url - Url of asset
     * @return bool|string - false if path was not found, otherwise returns path as string
     */
    public static function getRelativeStoragePathFromUrl($url){
        $url_array = explode('storage/', $url, 2);

        if(isset($url_array[1])) {
            return $url_array[1];
        }

        return false;
    }

    /**
     * Get the url of an stored element from its absolute path
     *
     * @param $path - Path of asset
     * @return bool|string - false if path was not found, otherwise returns path as string
     */
    public static function getUrlFromStoragePath($path){
        $path_array = explode(storage_path("app/public/"), $path, 2);

        if(isset($path_array[1])) {
            $url = url("storage/".$path_array[1]);
            return $url;
        }

        return false;
    }

    /**
     * Get a list of installed Vibrant packages by parsing composer.lock
     *
     * @param null $app_name
     * @param bool $only_visible
     * @return array
     */
    public static function get_vibrant_packages($app_name = null, bool $only_visible = false)
    {
        $file = base_path().'/composer.lock';
        $packages = json_decode(file_get_contents($file), true)['packages'];

        $vibrant_packages = [];

        foreach ($packages as $package) {
            list($package_vendor, $package_name) = explode('/',$package['name']);
            if ($package_vendor == 'vibrant') {
                $package_app_name = (isset($package['extra']['vibrant']['app_name'])) ? $package['extra']['vibrant']['app_name'] : '';
                $package_visible = (isset($package['extra']['vibrant']['visible']) && $package['extra']['vibrant']['visible'] == "true") ? true : false;
                $package_settings = (isset($package['extra']['vibrant']['settings'])) ? $package['extra']['vibrant']['settings'] : [];
                if(!empty($app_name)){
                    if($package_app_name == $app_name){
                        if($only_visible){
                            if($package_visible) {
                                $vibrant_packages[] = ['name'=>$package_name, 'app_name' =>$package_app_name, 'version'=>$package['version'], 'visible'=>$package_visible, 'settings'=>$package_settings ];
                            }
                        }else{
                            $vibrant_packages[] = ['name'=>$package_name, 'app_name' =>$package_app_name, 'version'=>$package['version'], 'visible'=>$package_visible, 'settings'=>$package_settings];
                        }
                    }
                }else{
                    $vibrant_packages[] = ['name'=>$package_name, 'app_name' =>$package_app_name, 'version'=>$package['version'], 'visible'=>$package_visible, 'settings'=>$package_settings];
                }
            }
        }

        return $vibrant_packages;
    }

    /**
     * Returns true if package is installed
     *
     * @param string $package_name
     * @param null $version
     * @param null $app_name
     * @return bool
     */
    public static function is_vibrant_package_installed($package_name, $version = null, $app_name = null)
    {
        $packages = self::get_vibrant_packages($app_name);
        if(count($packages) == 0){
            return false;
        }
        foreach($packages as $package){
            if($package['name'] == $package_name){
                if(!empty($version)){
                    if($package['version'] == $version){
                        return true;
                    }
                }else{
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Return names of all subdirectories of a given directory
     * @param  string $absolute_path,
     * @return array
     */
    public static function get_subdirectories($absolute_path){
        $dirs_full_path = glob( $absolute_path.'/*', GLOB_ONLYDIR);
        $directories = array_map(function($dir_path){
            return last(explode('/', $dir_path));
        },
            $dirs_full_path
        );
        return $directories;
    }

    /**
     * Return array with names of files within a directory that matches a pattern
     * @param string $absolute_path,
     * @param string|null $pattern
     * @return array
     */
    public static function get_dir_content($absolute_path, $pattern = null){
        if(!is_null($pattern)){
            $dirs_full_path = glob( $absolute_path.'/'.$pattern);
        }else{
            $dirs_full_path = glob( $absolute_path.'/*');
        }
        $content = array_map(function($dir_path){
            return last(explode('/', $dir_path));
        },
            $dirs_full_path
        );
        return $content;
    }


    /**
     * Return array of vibrant registered reusable components from a given folder
     *
     * @param $folder_path
     * @param $blade_path_prefix
     * @return array
     */
    public static function get_registered_components_from_folder($folder_path, $blade_path_prefix){
        $families = self::get_subdirectories($folder_path);
        $components = [];
        $paths = [];
        $root_group_name = ucfirst(__('vibrant::shared.general'));
        foreach ($families as $family){
            array_map(function($component_file_name) use (&$components, &$paths, $family, $root_group_name, $folder_path, $blade_path_prefix){
                $name = (explode('.', $component_file_name))[0];
                $blade_file_path = $folder_path."/$family/$name.blade.php";
                $component = self::parseComponentInfo($blade_file_path);
                if(isset($component['meta']['managed'])){
                    if(!empty($component['meta']['group'])){
                        $components[$family][$component['meta']['group']][] = $name;
                    }
                    else{
                        $components[$family][$root_group_name][] = $name;
                    }
                    if(substr($blade_path_prefix, -2) === '::'){
                        $paths["$family.$name"] = $blade_path_prefix."$family.$name";
                    }else{
                        $paths["$family.$name"] = $blade_path_prefix.".$family.$name";
                    }
                }
            },
                self::get_dir_content($folder_path."/".$family, '*.blade.php')
            );
            if(!empty($components[$family])){
                ksort($components[$family]);
            }
        }
        return compact('components', 'paths');
    }


    /**
     * Return array of vibrant registered reusable components
     * @return array
     */
    public static function get_registered_components(){
        $components = [];
        $paths = [];
        $custom_components_paths = config('vibrant.custom_components_paths');
        //get custom components
        if(!empty($custom_components_paths)){
            foreach ($custom_components_paths as $component_paths){
                $folder_path = $component_paths['folder_path'];
                $blade_path_prefix  = $component_paths['blade_path_prefix'];
                $found_custom_components = self::get_registered_components_from_folder($folder_path, $blade_path_prefix);
                $components = array_merge($components, $found_custom_components['components']);
                $paths = array_merge($paths, $found_custom_components['paths']);
            }
        }
        //get vibrant components
        $vibrant_components_path = base_path()."/packages/vibrant/vibrant/src/views/components";
        $vibrant_components_blade_prefix = 'vibComponent::';
        $found_vibrant_components = self::get_registered_components_from_folder($vibrant_components_path, $vibrant_components_blade_prefix);
        $components = array_merge($components, $found_vibrant_components['components']);
        $paths = array_merge($paths, $found_vibrant_components['paths']);
        return  compact('components', 'paths');
    }

    /**
     * Return first doc comment found in a file.
     * @param string $filename
     * @return string
     */
    public static function get_file_doc_block($filename)
    {
        if(!file_exists($filename)){
            abort("File doesn't exists");
        }
        $docComments = array_filter(
            token_get_all( file_get_contents( $filename ) ), function($entry) {
            return $entry[0] == T_DOC_COMMENT;
        }
        );
        $fileDocComment = array_shift( $docComments );
        return $fileDocComment[1];
    }

    /**
     * Return info of a given blade component
     *
     * @param $blade_file_path
     * @return array
     */
    public static function parseComponentInfo($blade_file_path)
    {
        $doc = self::get_file_doc_block($blade_file_path);
        $docBlock = new DocBlock($doc);
        $name = explode(' ', $docBlock->getShortDescription())[0];
        $description = $docBlock->getLongDescription();
        $tags = $docBlock->getTags();
        $meta = [];
        $slots = [];
        $links = [];
        $params = [];
        $s = 0;
        $l = 0;
        $t = 0;
        foreach($tags as $tag){
            if(get_class($tag) == 'gossi\docblock\tags\UnknownTag'){
                $meta[$tag->getTagName()] = $tag->getDescription();
            }
            if(get_class($tag) == 'Vibrant\Vibrant\Packages\DocBlock\Tags\SlotTag'){
                $slots[$s] = [
                    'label' => $tag->getType(),
                    'content' => $tag->getDescription()
                ];
                $s++;
            }
            if(get_class($tag) == 'Vibrant\Vibrant\Packages\DocBlock\Tags\LinkTag'){
                $links[$l] = [
                    'url' => $tag->getType(),
                    'label' => $tag->getDescription()
                ];
                $l++;
            }
            if(get_class($tag) == 'Vibrant\Vibrant\Packages\DocBlock\Tags\ParamTag'){
                $typeInfo = explode(':',$tag->getType());

                $params[$t] = [
                    'variable' => substr($tag->getVariable(), 1),
                    'type' => $typeInfo[0],
                    'example' => $tag->getExampleValue(),
                    'input' => $tag->getInputType(),
                    'options' => $tag->getInputOptions(),
                    'validation' => (isset($typeInfo[1])) ? $typeInfo[1] : '',
                    'description' => ucfirst($tag->getDescription()),
                    'required'=> $tag->getRequired(),
                    'default' => $tag->getDefault()
                ];
                $t++;
            }
        }
        return compact(
            'name',
            'description',
            'meta',
            'slots',
            'links',
            'params'
        );
    }

    /**
     * getRandomWeightedElement()
     * Taken from https://stackoverflow.com/questions/445235/generating-random-results-by-weight-in-php by Brad
     * Utility function for getting random values with weighting.
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
     * The return value is the array key, A, B, or C in this case.  Note that the values assigned
     * do not have to be percentages.  The values are simply relative to each other.  If one value
     * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
     * chance of being selected.  Also note that weights should be integers.
     *
     * @param array $weightedValues
     * @return int|string
     */
    public static function getRandomWeightedElement(array $weightedValues) {
        $rand = mt_rand(1, (int) array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }

    /**
     *
     */
    public static function getRandomPassword($length = 8,  $uc = null, $nb = null, $sp = null){
        $lowecase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $number = '1234567890';
        $special = '!#$%&*+-:?[]{|}';
        $chars = [];
        if($uc === null){
            $uc = (bool)random_int(0, 1);
        }
        if($nb === null){
            $nb = (bool)random_int(0, 1);
        }
        if($sp === null){
            $sp = (bool)random_int(0, 1);
        }
        if($uc === true){
            $chars[] = substr($uppercase, mt_rand(0,strlen($uppercase) - 1), 1);
        }
        if($nb === true){
            $chars[] = substr($number, mt_rand(0,strlen($number) - 1), 1);
        }
        if($sp === true){
            $chars[] = substr($special, mt_rand(0,strlen($special) - 1), 1);
        }
        $lc_to_fill =  $length - count($chars);
        if($lc_to_fill > 0){
            for($i=0;$i<=$lc_to_fill;$i++){
                $chars[] = substr($lowecase, mt_rand(0,strlen($lowecase) - 1), 1);
            }
            shuffle($chars);
            $password = implode('', $chars);
        }else{
            $password = substr(implode('',$chars), 0, $length);
        }
        return $password;
    }
}
