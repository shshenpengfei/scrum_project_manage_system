  <link rel="stylesheet" href="styles2222/css/screen.css" />
  <link rel="stylesheet" href="styles2222/css/gantti.css" />
<?php

require('lib/gantti.php'); 

date_default_timezone_set('UTC');
setlocale(LC_ALL, 'en_US');

$data = array();

$data[] = array(
  'label' => '首页增加行业分类导航 静态页面制作',
  'start' => '2012-04-20', 
  'end'   => '2012-05-12'
);

$data[] = array(
  'label' => '首页增加行业分类导航 逻辑处理',
  'start' => '2012-04-22', 
  'end'   => '2012-05-22', 
  'class' => 'important',
);

$data[] = array(
  'label' => '首页增加行业分类导航 业务处理',
  'start' => '2012-05-25', 
  'end'   => '2012-06-20',
  'class' => 'urgent',
);

$data[] = array(
  'label' => '首页增加行业分类导航 功能测试',
  'start' => '2012-05-25', 
  'end'   => '2012-06-20',
  'class' => 'urgent',
);

$gantti = new Gantti($data, array(
  'title'      => 'Demo',
  'cellwidth'  => 25,
  'cellheight' => 35
));

echo $gantti;

?>