<?php
/**
 * Created by PhpStorm.
 * User: Wolverine
 * Date: 21.10.2019
 * Time: 21:24
 */

/**
 * Подключаем файл класса Form
 */
require_once( 'Form.php' );

$form = new classes\Form();
$arr = [
    "action" => "#",
    "method" => "GET"
];
echo $form->open($arr);

$arr = [
    "type" => "text",
    "name" => "url",
    "id" => "for_my_frame",
    "value" => "for_my_frame.html"
];
echo $form->input($arr);

$arr = [
    "name" => "submit_button",
    "id" => "submit",
    "value" => "Отправить"
];
echo $form->submit($arr);
echo $form->close();
include 'index.html';
