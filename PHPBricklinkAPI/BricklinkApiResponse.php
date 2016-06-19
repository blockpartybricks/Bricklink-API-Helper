<?php
namespace PHPBricklinkAPI;

class BricklinkApiResponse{
	 public $code;
	 public $results;
	 private $rawResponse;

	 public function __construct($ch, $response){
		 	$this->rawResponse = $response;
			$this->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$this->results = json_decode($response);
	 }

	 public function asJson(){
		 return $rawResponse;
	 }
}
