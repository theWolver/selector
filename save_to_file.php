<?php
/**
 * Created by PhpStorm.
 * User: Wolverine
 * Date: 20.10.2019
 * Time: 17:26
 */
$url = $_POST["my_url"];         //URL из input.value
$str = $_POST["selectors_id"];   //event.target.id
$str1 = $_POST["selectors_class"];//event.target.className
$tag = $_POST["tag"];           //event.target.tagName
$tag = mb_strtolower($tag);     //переводим в нижний регистр

$doc=new DomDocument();         //Инициализируем класс DomDocument
//$doc->loadHTMLFile($url);       //Загружаем в класс HTML-страничку из URL полученного по AJAX

//error_reporting(E_ALL | E_STRICT);
$url = json_decode($url); //переводим полученную строку html-тегов из json-строки в html-строку
libxml_use_internal_errors(true);
$doc->loadHTML($url);     //загружаем HTML из строки
libxml_clear_errors();
//Извлекаем из документа все теги $_GET["tags"]
$tags = $doc->getElementsByTagName($tag);

//Перебираем массив полученных элементов тега $tags
$i=0;
$count=0; //счётчик для опреледения наличия и id и class
/**
 * @var $domElement DOMElement
 */
foreach ($tags  as $my_tag)
{
//проверяем наличие атрибута - id/class у тега
        if ($tags->item($i)->hasAttribute('id'))
        {
            //если атрибут есть - сравниваем его с переданным по AJAX в $_GET["selectors"]
            if ($tags->item($i)->getAttribute('id') == $str) {
                $domElement = $tags->item($i);  //запоминаем найденный узел DOM в $domElement
                $str = '#' . $str;
                $count++;
            }
            //если есть id и оно равно установленному нами #my_frame_click
            if ($tags->item($i)->getAttribute('id') == "my_frame_click") {
                $domElement = $tags->item($i);
                $str = $tag . ":nth-child(" . (int)($i + 1) . ")";
                break;
            }
//аналогичная проверка для атрибута 'class',
//при условии что id есть всегда потому если его нет мы всё равно принудительно устанавливаем его, поэтому этот if вложен в if для id
            if ($tags->item($i)->hasAttribute('class'))
                if ($tags->item($i)->getAttribute('class') == $str1)
                {
                    $domElement = $tags->item($i);
                    $str = '.' . $str1;
                    $count++;
                }
        }
//если у узла есть и id и class (count=2)
        if ($count == 2)
        {
            $domElement = $tags->item($i);
            $str = '#' . $_GET["selectors_id"] . '.' . $str1;
            break;
        }
        //если же у узла нет вообще никакого css-селектора (count=0) тут должно быть чтото типо if($str== "my_frame_click")
        /*  if((!$tags->item($i)->hasAttribute('id'))&&(!$tags->item($i)->hasAttribute('class'))&&($count==0))
          {
              $domElement = $tags->item($i);
              $str = $tag . ":nth-child(".(int)($i+1).")";
          }*/
    $i++;
}

//создаём ассоциативный массив с начальным элементом = значению из $str
$a = array( 0 => $str . "\r\n");
$b = array( 0 => $tag . "\r\n");
$str = $str.' > ';
$i = 1;

//проходим по узлам DOM вверх аж до body
while($domElement->parentNode->tagName!="body")
{
    $id = $domElement->parentNode->getAttribute('id');
    $class = $domElement->parentNode->getAttribute('class');
    if(!empty($id))
        $str = '#' . $id . ' > ';
    if(!empty($class))
        $str = '.' . $class . ' > ';
    if((!empty($id))&&(!empty($class)))
        $str = '#' . $id . '.' . $class.' > ';
    if((empty($id))&&(empty($class)))
        $str = $domElement->parentNode->tagName.' > ';
    $a[$i] = $str;
    $b[$i] = $domElement->parentNode->tagName.' > ';
    $i++;
    $domElement = $domElement->parentNode;
}
//записываем в массив сам body согласно условию поставленной задачи
$str = "body > ";
$a[$i] = $str;
$b[$i] = $str;
//делаем инверсию массива
$reversed = array_reverse($a);
$reversed2 = array_reverse($b);
//выводим значения ассоциативного массива в файл .txt
file_put_contents('my_json.json', $reversed, FILE_APPEND);
file_put_contents('my_json.json', $reversed2, FILE_APPEND);
echo json_encode($reversed);

