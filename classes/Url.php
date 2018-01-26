<?php
	/**
	 * This package can extract url and grap screenshort form url.
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link     https://github.com/Lablnet/PHP-URL
	 */
class URL
{
	//set the url
	private $url;

	/**
	 * Set the url
	 * @param  $url valid url of web
	 * @return void
	 */	 
	public function SetUrl( $url ){

		$this->url = $url;

	}

	/**
	 * Get the url
	 * @return url
	 */		
	public function GetUrl(){

		return $this->url;

	}	

	/**
	 * Clean/remove html tags
	 * @param  $string
	 * @return string
	 */		
	public function Clean($str){
		return strip_tags($str);
	}
	/**
	 * Generating random slugs
	 * @param  $length
	 * @return string
	 */		
	public function Slug($length){
		$char = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
		$stringlength = count( $char  ); //Used Count because its array now
		
		$randomString = '';
		
		for ( $i = 0; $i < $length; $i++ ) {
			
			$randomString .= $char[rand( 0, $stringlength - 1 )];
			
		}
		
		return $randomString;
		
	}
	/**
	 * Get content form url
	 * @param $url valid url of web
	 * @return raw data
	 */			
	public function FetchUrl( $url ){

		return file_get_contents($url);

	}
	/**
	 * Fetch title
	 * @return string
	 */	
	public function FetchTitle(){

		$url = $this->FetchUrl($this->GetUrl());

		preg_match_all("/<title>(.+)<\/title>/i", $url, $title);

		if(isset($titles[1][0])){

			return $titles[1][0];

		}else{

			return "Sorry! No title found";

		}

	}	
	/**
	 * Fetch keywords
	 * @return string
	 */	
	public function FetchKeywords(){

		$tags = get_meta_tags($this->GetUrl());

		if(isset($tags['keywords'])){

			return $tags['keywords'];

		}else{

			return "Sorry! No Keywords found";

		}

	}	
	/**
	 * Fetch Description
	 * @return string
	 */	
	public function FetchDescription(){

		$url = $this->FetchUrl($this->GetUrl());

		preg_match_all("/<h1>(.+)<\/h1>/i", $url, $paragraphs);

		if(isset($paragraphs[0][0]) and isset($paragraphs[0][1])){

			return $paragraphs[0][0] . ' ' . $paragraphs[0][1] . ' ' .$paragraphs[0][2];

		}else{

			return "Sorry! No description found";

		}

	}	
	/**
	 * Fetch images form url
	 * @return string
	 */	
	public function FetchImages(){

		$url = $this->FetchUrl($this->GetUrl());

		preg_match_all('/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui', $url, $images);

		if(isset($images)){

			return $images;

		}else{

			return "Sorry! No image found";

		}

	}
	/**
	 * Capture web screenshort using google api
	 * @return blob
	 */	
	public function CaptureUrl(){
		//getting url
		$siteURL = $this->GetUrl();
		//call Google PageSpeed Insights API
		$googlepsdata = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url={$siteURL}&screenshot=true");
			//decode json data
		$googlepsdata = json_decode($googlepsdata,true);
		//screenshot data
		$snap = $googlepsdata['screenshot']['data'];
		$snap = str_replace(array('_','-'),array('/','+'),$snap); 	
		return $snap;
	}

	/**
	 * get back all data
	 * @return array
	 */	
	public function GetData(){
		$array = 
		[

			'url' => $this->GetUrl(),

			'slug' => $this->Slug(6),

			'title' => $this->FetchTitle(),

			'keywords' => $this->FetchKeywords(),

			'description' => $this->Clean($this->FetchDescription()),

			'screenshort' => $this->CaptureUrl(),

			'images' => $this->FetchImages(),
			
		];

		return $array;

	}	
}