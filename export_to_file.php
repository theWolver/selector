<?php
/**
 * Created by PhpStorm.
 * User: Wolverine
 * Date: 29.10.2019
 * Time: 16:06
 */

$title = $_POST["title"]."\r\n";           //значение поля Title
$subtitle = $_POST["subtitle"]."\r\n";     //значение поля SubTitle
$intro_text = $_POST["intro_text"]."\r\n"; //значение поля Intro Text
$date = $_POST["date"]."\r\n";             //значение поля Date
$author = $_POST["author"]."\r\n";         //значение поля Author
$content = $_POST["content"]."\r\n";       //значение поля Content

//выводим значения полей в файл .json
file_put_contents('export.json', $title, FILE_APPEND);
file_put_contents('export.json', $subtitle, FILE_APPEND);
file_put_contents('export.json', $intro_text, FILE_APPEND);
file_put_contents('export.json', $date, FILE_APPEND);
file_put_contents('export.json', $author, FILE_APPEND);
file_put_contents('export.json', $content, FILE_APPEND);
