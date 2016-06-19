<?php
namespace PHPBricklinkAPI;

class BricklinkApiResponse{
	 protected $code;
	 protected $hasError;
	 protected $errorMessage;
	 protected $results;
	 private $rawResponse;

	 public function __construct($ch, $response){
		 	$this->rawResponse = $response;
			$responseObject = json_decode($response);
			$this->code = $responseObject->meta->code;
			if($this->hasError = ($this->code !== 200)){
				$this->errorMessage = $responseObject->meta->description;
			}else{
				$this->results = $responseObject->data;
			}
	 }

	 public function asJson(){
		 return $rawResponse;
	 }
}
