<?php
class ConfigLoader
{
    public function loadJsonConfigGroup($path, $file = null)
    {
        $path = ROOT_DIR .'/Config'. $path . '/';
        if($file) {
            return json_decode(file_get_contents($path . $file), true);
        }
        $raw_files = scandir($path);
        foreach($raw_files as $file){
            if (is_file($path . $file)) $files[] = $path . $file;
        }
        foreach($files as $file) {
            $configs = array_merge($configs, json_decode(file_get_contents($file[$o]), true));
        }
        return $configs;
    }
}