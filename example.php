<?php

	//call the class using require_once //better for error checking
	
	require_once( 'classes/Url.php' );

	$test = "how are you friends https://www.google.com/";

	$getSite = new URL;


	//for performance improvement
	$getSite->SetConnTime(8);

	$filter_url = $getSite->FilterUrl($test);

	$getSite->SetUrl( $filter_url[0][0] );

	$data = $getSite->GetData();

	//getting all data into array

	//print_r($data);

	

	echo $data['title'];


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

	//echo $data['screenshot'];

	echo "<br>";

	//image if you want print all images using foreach loop

	if(isset($data['images'][0][1])){

		echo $data['images'][0][1].'/>';

	}
	
