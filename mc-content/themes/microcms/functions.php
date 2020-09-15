<?php

function active($currect_page)
{
   $url = $_SERVER['REQUEST_URI'];

   if($currect_page == $url)
   {
      echo 'active';
   }
}
