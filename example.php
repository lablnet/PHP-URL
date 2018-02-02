<?php
require 'classes/Url.php';

$url = new URL;

//workfine githhub and others
//$url->SetUrl("https://github.com/");
//but in facebook case not work
$url->SetUrl("https://www.facebook.com/");
$data = $url->GetData();
//getting all data into array
//print_r($data);
    foreach ($data['title'] as $key => $value) {
   echo $value[0];
   }
  echo "<br>";
echo $data['url'];
echo "<br>";
echo $data['slug'];
echo "<br>";
//keywords
echo $data['keywords'];
echo "<br>";
//description
echo $data['description'];
echo "<br>";
//image if you want print all images using foreach loop
echo $data['images'][0][1].'/>';
