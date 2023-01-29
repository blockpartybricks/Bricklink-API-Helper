<?php
namespace PHPBricklinkApi;

class BricklinkApiResponse{
	public $code;
	public $hasError;
	public $errorMessage;
	public $results;
	public $rawRequest;
	private $rawResponse;

	public function __construct($ch, $response){
		$this->rawResponse = $response;
		$this->rawRequest = curl_getinfo($ch)['url'];
		$responseObject = json_decode($response);
		$this->code = (string) $responseObject->meta->code;

		if($this->hasError = (substr($this->code,0,1) !== '2')){
			$this->errorMessage = $responseObject->meta->description;
		}else{
			//The call can be successful, but not have any data.
			//By explicitly checking, we avoid warnings
			$this->results = (isset($responseObject->data)? $responseObject->data : true );
		}
	}

	public function asJson(){
		return $rawResponse;
	}
}