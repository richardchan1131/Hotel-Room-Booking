<?php


namespace Modules\Admin\Crud\Components;


use Modules\Admin\Crud;

class BaseComponent
{
    protected $allData = [];
    protected $name = 'div';

    protected $curdModule;

    public function setData($data){
        $this->allData = $data;
    }
    public function setCurdModule($data){
        $this->curdModule = $data;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function data($key,$default = ''){
        return $this->allData[$key] ?? $default;
    }
    public function dataArray($key,$default = []){
        $res = $this->data($key,$default);
        if(!is_array($res)) return $default;
        return $res;
    }

    public function render(){
       $class = '';
       if($className = $this->data('class')) $class = "class='".e($className)."'";
       printf("<%s %s %s>",e($this->name),$class,$this->data("attr"));

       $children = $this->dataArray('children');

       if($text = $this->data("text")){
           echo $text;
       }

       if(!empty($children)){
           Crud::layout($this->curdModule,$children);
       }

       printf("</%s>",e($this->name));
    }
}
