<?php
/**
 * Created by PhpStorm.
 * User: Wolverine
 * Date: 20.10.2019
 * Time: 17:40
 */
$url = $_GET["my_url"];
$page = file_get_contents($url);
echo json_encode($page);