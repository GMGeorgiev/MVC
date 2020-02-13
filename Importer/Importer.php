<?php

namespace importer;

use core\Model\Model;
use app\models;

class Importer
{
    private $menu = array();
    public function readFile($csvFile)
    {
        $file = fopen($csvFile, "r");
        $menu = array();
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $menu[] = $data;
        }

        $headers = array_shift($menu);
        foreach ($menu as $value) {
            array_push($this->menu, $this->replace_key($value, $headers));
        }
        fclose($file);
        return $this;
    }


    private function replace_key(array $menu, array $keys)
    {
        $tempArray = array();
        foreach ($menu as $key => $menuItem) {
            $tempArray[str_replace("?", '', utf8_decode($keys[$key]))] = $menuItem;
        }
        return $tempArray;
    }


    public function import(string $className, array $optional)
    {
        foreach ($this->menu as $menuItem) {
            $model = "app\\models\\{$className}";
            $temp_model = new $model();
            $temp_model->setPropertyValues($menuItem);
            $temp_model->setPropertyValues($optional);
            $temp_model->save();
        }
    }
}
