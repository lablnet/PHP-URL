<?php
require 'classes/Url.php';

$url = new URL;
$url->SetUrl("https://github.com/");
$data = $url->GetData();
//getting all data into array
//print_r($data);

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