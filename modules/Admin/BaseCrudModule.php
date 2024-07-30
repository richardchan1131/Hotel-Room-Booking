<?php


namespace Modules\Admin;


abstract class BaseCrudModule
{

    static $version = "1.0";

    public $model;

    public function index(){
        return  [];
    }
    public function create(){
        return  [];
    }
}
