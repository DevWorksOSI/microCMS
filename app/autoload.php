<?php

spl_autoload_register(function($name){
        require_once 'app/'.str_replace('\\','/',$name).'.php';
});