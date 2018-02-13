<?php

//Check if the environment has access to outside urls
if( ini_get( 'allow_url_fopen' ) ) {
	
	//call the class using require_once //better for error checking
	require_once( 'classes/Url.php' );

	$getSite = new URL( 'https://github.com/' );

	$data = $getSite->GetData();

	//getting all data into array

	//print_r($data);

	foreach ( $data['title'] as $key => $value) {

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
	
} else {
	
	die( "Check Your Ini File Settings &amp; Set allow_url_fopen to true|1 " );
	
}
