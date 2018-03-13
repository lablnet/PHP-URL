<?php

	/**
	 * This package can extract url and grap screenshort form url.
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link     https://github.com/Lablnet/PHP-URL
	 *
	 */
class URL {
	
	protected $url; // Set the url

	private $tags = []; // For Meta Tags

	private $connTime; // For Connection time

	 /**
	 * Unset these when object died
	 *	
	 * @return void
	 */	 
	public function __destruct(){

		unset($this->url);

		unset($this->tags);

		unset($this->connTime);

	}
	/**
	 * Set Connection time for feching
	 * @param  $time ex 10
	 * @return void
	 */	 	
	public function SetConnTime($time){

		if(is_numeric($time) && is_int($time)){

			$this->connTime = $time;

		}else{

			$this->connTime = 10;

		}

	}
	/**
	 * Set the url
	 * @param  $url valid url of web
	 * @return void
	 */	 
	public function SetUrl( $url ){

		if(self::IsUrl($url)){

			$this->url = $url;

			self::MetaTags();

		}else{

			return false;

		}

	}
	 /**
	 * Get meta tags form url
	 *
	 * @return mix-data
	 */	 		
	public function MetaTags(){

		$doc = new DOMDocument();

		@$doc->loadHTML(self::FetchUrl());

		 $metas = $doc->getElementsByTagName('meta');

		$title = $doc->getElementsByTagName('title');

		if(isset($title->item(0)->nodeValue)){

        	$this->tags['title'] = $title->item(0)->nodeValue;

   		}

   		for ($i = 0; $i < $metas->length; $i++){

    		$meta = $metas->item($i);

	    		if($meta->getAttribute('name') == 'description'){

	       			$description = $meta->getAttribute('content');

	       		}

	    		if($meta->getAttribute('name') == 'keywords'){

	       		$keywords = $meta->getAttribute('content');

	       		}


	    		if($meta->getAttribute('name') == 'author'){

	       		$author = $meta->getAttribute('content');

	       		}	       		

	    		if($meta->getAttribute('name') == 'geo_position'){

	       		$geo_position = $meta->getAttribute('content');

	       		}	 

       		}

       		if(isset($description)){

       			$this->tags['description'] = $description;

       		}

       		if(isset($keywords)){

       			$this->tags['keywords'] = $keywords;

       		}

       		if(isset($author)){

       			$this->tags['author'] = $author;

       		}

       		if(isset($geo_position)){

       			$this->tags['geo_position'] = $geo_position;

       		}

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
		
		$stringlength = count( $char  ); //Used Count because its an array now
		
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
	public function FetchUrl(){

		if(isset($this->url) && !empty($this->url)){

			$curl_init = curl_init($this->url);

			curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, $this->connTime);

			curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($curl_init);

			curl_close($curl_init);

            return $response;

		}else{

			return false;

		}	

	}
	/**
	 * Fetch title
	 * @return string
	 */	
	public function FetchTitle(){
		
		if(preg_match( "/<title.*?>[\n\r\s]*(.*)[\n\r\s]*<\/title>/", $this->FetchUrl(), $title ) ){

			if (isset($title[1])){
				
				if ($title[1] == ''){
                  
					 if(isset($this->tags['title'])) {

						return $this->tags['title'];

					}else{

						return "Sorry! No title found on [{$this->url}]";

					}
			
				}
            
				$title = $title[1];
            
				return trim($title);
			
			}elseif(isset($this->tags['title'])) {

				return $this->tags['title'];

		}else{

				return "Sorry! No title found on [{$this->url}]";

		}
			
		}elseif(isset($this->tags['title'])) {

				return $this->tags['title'];

		}else{

				return "Sorry! No title found on [{$this->url}]";

		}	
			
		
	}	
	
	/** Added
	 * Fetch author
	 * @return string
	 */	
	public function FetchMetaAuthor(){

		if( isset( $this->tags['author'] ) ){

			return $this->tags['authors'];

		}else{

			return "Sorry! No Author found";

		}

	}
	
	/**
	 * Fetch keywords
	 * @return string
	 */	
	public function FetchMetaKeywords(){

		if( isset( $this->tags['keywords'] ) ){

			return $this->tags['keywords'];

		}else{

			return "Sorry! No Keywords found";

		}

	}	
	
	/** Added
	 * Fetch description
	 * @return string
	 */	
	public function FetchMetaDescription(){

		if( isset( $this->tags['description'] ) ){

			return $this->tags['description'];

		}else{

			return "Sorry! No Description found";

		}

	}
	
	/** Added
	 * Fetch geo positioning
	 * @return string
	 */	
	public function FetchMetaGeoPos(){

		if( isset( $this->tags['geo_position'] ) ){

			return $this->tags['geo_position'];

		}else{

			return "Sorry! No Geo Position found";

		}

	}
	
	/**
	 * Fetch images form url
	 * @return string
	 */	
	public function FetchImages(){

		preg_match_all( '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui', $this->FetchUrl(), $images );

		if( isset( $images ) ){

			return $images;

		}else{

			return "Sorry! No image found";

		}

	}
	/**
	 * Capture web screenshot using google api
	 * @return blob
	 */	
	public function CaptureUrl(){
		
		if(!empty( $this->url )){

               $curl_init = curl_init("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url={$this->url}&screenshot=true");

               curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, $this->connTime);

              curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);

               $response = curl_exec($curl_init);

               curl_close($curl_init);

		//call Google PageSpeed Insights API
			
		//decode json data
		$googlepsdata = json_decode( $response,true );
		
		//screenshot data
		$snap = $googlepsdata['screenshot']['data'];
		
		$snap = str_replace(array( '_','-' ),array( '/','+' ),$snap ); 	
	
		return $snap;

	 }else{

	 	return false;

	 }
		
	}

	/**
	 * Filters all url from string
	 * @param $url valid url of web
	 * @return array
	 */				
	public function FilterUrl($url){

		if(preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $url, $match)){

			return $match;

		}else{

			return false;

		}

	}
	/**
	 * Check url is avilable or not
	 * @param $url url of web to be checked
	 * @return boolean
	 */		
	public function IsUrl($url)
       {
               
               if(!filter_var($url, FILTER_VALIDATE_URL)){
                       return false;
               }

               $curl_init = curl_init($url);

               curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, $this->connTime);

               curl_setopt($curl_init, CURLOPT_HEADER, true);

              curl_setopt($curl_init, CURLOPT_NOBODY, true);

              curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);

               $response = curl_exec($curl_init);

               curl_close($curl_init);

               if ($response){

               		return true;

               }else{

               		return false;

               }

               
       }
	/**
	 * get back all data
	 * @return array
	 */	
	public function GetData(){
		$arr = [
		
			'url' => $this->url,

			'slug' => $this->Slug(6),

			'title' => $this->FetchTitle(),

			'keywords' => $this->FetchMetaKeywords(),

			'description' => $this->Clean( $this->FetchMetaDescription() ),

			'screenshot' => $this->CaptureUrl(),

			'images' => $this->FetchImages()
			
		];

		return $arr;

	} // end method
	
} // end class
