App\Models\Response\Log
===============

Class Log.

A model to describe a log entry


* Class name: Log
* Namespace: App\Models\Response
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $element

The Unique Identifier of the relative
logged entry (service, data, client, token).



```php
public string $element = null
```

#### Details:
* Visibility: **public**

<hr>

### $table

The respective table of the related
logged entry (service, data, client, token).



```php
public string $table
```

#### Details:
* Visibility: **public**

<hr>

### $token

The JWT Token used for the Session
if it's a request that requires Token auth.



```php
public mixed $token = null
```

#### Details:
* Visibility: **public**

<hr>

### $serverTime

The time when the server handled the operation and inserted it.



```php
protected float $serverTime
```

#### Details:
* Visibility: **protected**

<hr>

Methods
-------


### __construct

Log constructor.

Picks the result content of the result Response
and set the serverTime

Since every Response actually has a $code and a $message

```php
mixed App\Models\Response\Log::__construct()
```

#### Details:
* Visibility: **public**



<hr>

### setServerTime

Set manually serverTime
with the ability of setting the with the current microtime.



```php
mixed App\Models\Response\Log::setServerTime(float or null $serverTime)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $serverTime | float or null | Server Time on UNIX_TIMESTAMP with milliseconds |


<hr>

### encode

Get all public properties of the Model
It's used for the Response Mapping on Lists.



```php
array App\Models\Communication\Model::encode()
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



<hr>
