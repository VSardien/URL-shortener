<?php
//I am a router, do not touch me <3

require_once 'inc/inc.php';
use Models\API2;
if (!isset($_GET['red'])) {
    include_once('./home.php');
}
elseif (file_exists('./'.$_GET['red'].'.php')) {
    include_once ('./'.$_GET['red'].'.php');
}
else {
    $data = API2::find($_GET['red']);
    var_dump($data);
    if (!is_null($data)) {
        header('Location: https://www.'.$data->url);
        die();
    }
    else {
        die('404 not found');
    }
}