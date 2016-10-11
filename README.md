# PHP-Bricklink-API

A PHP class method to access the Bricklink API using cURL library.

##Usage

```
$BricklinkApi = new /PHPBricklinkApi/BricklinkAPI([
  'tokenValue' => {TOKEN},
  'tokenSecrect' => {TOKEN_SECRET},
  'consumerKey' => {CONSUMER_KEY},
  'consumerSecret' => {CONSUMER_SECRET}
]);

$response = $BricklinkApi->request({HTTP_METHOD}, {API_PATH}, {PARAMS})
              ->execute();
```

## Prerequisites

* PHP 5.5+
* cURL library extension

### Create A Bricklink Instance

```
new /PHPBricklinkApi/BricklinkApi($params);
```

__Returns__

Returns a new instance of the BricklinkApi class.

__Constructor Parameters $params__

Passed as an associative array of keys and values. Accepted key values are:

* *$endpoint*: Allows you to overide the default Bricklink Api endpoint.
* *$consumerKey*: The consumer secret for your Bricklink API account. Value found at [Bricklink API Registration Page](https://www.bricklink.com/v2/api/register_consumer.page)
* *$consumerSecret*: The consumer secret for your Bricklink API account. Value found at [Bricklink API Registration Page](https://www.bricklink.com/v2/api/register_consumer.page)
* *$tokenValue*: The token key from your Bricklink API Access Tokens. Value found at [Bricklink API Registration Page](https://www.bricklink.com/v2/api/register_consumer.page)
* *$tokenSecret*: The token secret from your Bricklink API Access Tokens. Value found at [Bricklink API Registration Page](https://www.bricklink.com/v2/api/register_consumer.page)
* *$isDevelopment*: Allows unsecure connections for easier localhost development.


### Create a Request

```
$BricklinkApi->request($httpMethod, $apiPath, $params);
```

A shorthand can also be used to create a request and execute it.
```
$BricklinkApi->get($apiPath,$params=[]);
```
is equivalent to 
```
$BricklinkApi->request("GET", $apiPath, $params);
```
And so on for the other common REST methods.
```
$BricklinkApi->post($apiPath,$params=[]);
``` 
```
$BricklinkApi->put($apiPath,$params=[]);
``` 
```
$BricklinkApi->delete($apiPath,$params=[]);
```

__Returns__

Returns your BricklinkApi instance to enable chaining.

__Parameters__

* *$httpMethod*: Use the common REST methods. i.e. - GET, POST, PUT, DELETE
* *$apiPath*: The relative path of the api. Should include a leading `/`.
* *$params*: An associative array, according to the [Bricklink API docs] (http://apidev.bricklink.com/redmine/projects/bricklink-api/wiki). 
```$params = [
'box' => true,
'instructions' => true];```

### Execute request

```
$BricklinkApi->request($httpMethod, $apiPath, $params)->execute();
```

__Returns__

Returns and instance of BricklinkApiResponse
