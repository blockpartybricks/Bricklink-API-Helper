<?php
namespace PHPBricklinkApi;

class BricklinkApi{
	private $endpoint = 'https://api.bricklink.com/api/store/v1';
	private $tokenValue;
	private $tokenSecret;
	private $consumerKey;
	private $consumerSecret;
	private $isDevelopment = false;
	private $oauthVersion = '1.0';

	public function __construct($params){
		foreach($params as $key=>$value){
			if(property_exists($this,$key)){
				$this->{$key} = $value;
			}
		}
	}

	public function get($url, $params=[]){
		return $this->request('GET', $url, $params)->execute();
	}

	public function post($url, $params=[]){
		return $this->request('POST', $url, $params)->execute();
	}

	public function put($url, $params=[]){
		return $this->request('PUT', $url, $params)->execute();
	}

	public function delete($url, $params=[]){
		return $this->request('DELETE',$url,$params)->execute();
	}

	public function request($method, $url, $params=[]){
		$request = new BricklinkApiRequest([
			'method'=>$method,
			'path'=> $url,
			'params' => $params
			]);
		$request->authorization = $this->getAuthorizationHeader($url, $request);
		$this->request = $request;

		return $this;
	}

	public function execute(){
		$request = $this->request;
		$ch = curl_init();
		$curl_url=$request->path."?Authorization=".$request->authorization;
		if("GET"==$request->method && count($request->params))
		{
			$curl_url=$request->path."?".http_build_query($request->params)."&Authorization=".$request->authorization;
		}
		curl_setopt($ch, CURLOPT_URL, $this->endpoint.$curl_url);

		if($this->isDevelopment){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		if($request->method == 'DELETE' || $request->method == 'PUT')
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->method);
		}
		if($request->method=='PUT')
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->params));
		}
		if($request->method=='POST')
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->params));
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			//Execute
		$response = curl_exec($ch);
			//Create Response Object
		$BricklinkApiResponse = new BricklinkApiResponse($ch, $response);
			//Close and return response
		curl_close($ch);
		return $BricklinkApiResponse;
	}
	private function getAuthorizationHeader($url, $request){
		 //Generate Random String
		$random = substr( md5(rand()), 0, 7);
		 //Build authorization Object
		$authorization = [
			'oauth_consumer_key' => $this->consumerKey,
			'oauth_nonce' => $random,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_signature' => null,
			'oauth_timestamp' => (string) time(),
			'oauth_token' => $this->tokenValue,
			'oauth_version' => $this->oauthVersion
		];
		 //Add authorization signature
		$authorization['oauth_signature'] = $this->generateSignature($request, $authorization);
		 //Turn into a url encoded json object
		$jsonAuthorization = json_encode($authorization);
		return rawurlencode($jsonAuthorization);
	}

	private function generateSignature(BricklinkApiRequest $request, array $authorization){
		$parameters = $authorization;
		if($request->method=="GET"){
			$parameters = array_merge($parameters, $request->params);
		}
		ksort($parameters);
		$paramterString = http_build_query($parameters);

		$signature_basestring = $request->method.'&'.rawurlencode($this->endpoint.$request->path).'&'.rawurlencode($paramterString);
		$secretstring = $this->consumerSecret.'&'.$this->tokenSecret;
		$signature = base64_encode(hash_hmac('sha1', $signature_basestring, $secretstring, true));
		return $signature;
	}
}