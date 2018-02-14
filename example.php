<?php

//Check if the environment has access to outside urls
if( ini_get( 'allow_url_fopen' ) ) {
	
	//call the class using require_once //better for error checking
	require_once( 'classes/Url.php' );

	$test = "how are you friends https://github.com/";

	$getSite = new URL;

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

	//image if you want print all images using foreach loop

	echo $data['images'][0][1].'/>';
	
} else {
	
	die( "Check Your Ini File Settings &amp; Set allow_url_fopen to true|1 " );
	
}
