<?php

spl_autoload_register(function($name){
        require_once 'mc-core/'.str_replace('\\','/',$name).'.php';
});
