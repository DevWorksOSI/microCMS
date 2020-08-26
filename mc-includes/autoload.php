<?php

spl_autoload_register(function($name){
        require_once 'core/'.str_replace('\\','/',$name).'.php';
});
