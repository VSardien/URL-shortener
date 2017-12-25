<?php
require_once 'inc/inc.php';
use Models\API;
use Models\API2;
header('Content-Type: application/json');
function random_str($length, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($char, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $char[random_int(0, $max)];
    }
    return $str;
}
if (isset($_GET['url'])) {
    $data = API::find($_GET['url']);
    if (is_null($data)) {
        $randomString = random_str(5);
        while (!is_null(API2::find($randomString))) $randomString = random_str(5);
        $details = [
            'url' => $_GET['url'],
            'shortened' => $randomString,
        ];
        $data = API::create($details);
    }
}
else {
    $data =  ['error' => '400','description' => 'Missing argument url'];
}
echo json_encode($data);