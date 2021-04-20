<?php
    namespace coldzero\Framework\Cfg;

    class Config{
        public static function init(){
            error_reporting(E_ALL);
            ini_set("display_errors",1);
            define('URL','http://localhost/');
        }
    }