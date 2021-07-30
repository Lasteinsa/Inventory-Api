<?php 

spl_autoload_register(function($class){
    require_once('core/'.$class.'.php');
});

// define('BASE_URL'  , 'http://localhost/t-gadgetapi/');
// define('BASE_LINK' , $_SERVER["DOCUMENT_ROOT"].'/t-gadgetapi/asset/');

?>