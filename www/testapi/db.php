<?php
require 'lib.php';
if (!OpenConfig::SAFE_MODE) {
    //@$data = file_get_contents('data.dat');
    $data = FileHandler::getFileContent('data.dat');
} else {
    $data = '{"保密":"根据OpenConfig::SAFE_MODE设置，不展示模拟存储数据"}';
}

header('Content-Type: application/json; charset=UTF-8');
echo $data;
