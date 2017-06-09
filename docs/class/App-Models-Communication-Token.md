App\Models\Communication\Token
===============

Class Token.

A Token Model is a Schema Definition of
A Token and how it will be stored on the Database


* Class name: Token
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $clientId

The Client Unique Identifier.

Each Token expires, but the Client Definition does not,
each Token it's related to an Unique Client,

Token changes, Clients doesn't not.

```php
public string $clientId
```

#### Details:
* Visibility: **public**

<hr>

### $expireTime

Token Expire Time.

When the Token goes expire,
in seconds.milliseconds on UNIX Timestamp

```php
public float $expireTime
```

#### Details:
* Visibility: **public**

<hr>

### $clientTime

The time when the Client requested the operation.



```php
public float $clientTime
```

#### Details:
* Visibility: **public**

<hr>

### $tags

Tags Identifiers.

Tags are used to contextual data filtering
and may be used to filter set of results

```php
public array $tags = array()
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

RaiseModel constructor.

Set the Timestamps of when RAISe handled
this model.

```php
mixed App\Models\Communication\Raise::__construct()
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)



<hr>

### setExpireTime

Set the Token Expire Time.



```php
\App\Models\Communication\Token App\Models\Communication\Token::setExpireTime()
```

#### Details:
* Visibility: **public**



<hr>

### setClientTime

Set manually clientTime
with the ability of setting the with the current microtime.



```php
mixed App\Models\Communication\Raise::setClientTime(float or null $clientTime)
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $clientTime | float or null | Client Sent Time on UNIX_TIMESTAMP with milliseconds |


<hr>

### getServerTime

Time when the server registered the Data.



```php
float App\Models\Communication\Raise::getServerTime()
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)



<hr>

### setServerTime

Set manually serverTime
with the ability of setting the with the current microtime.



```php
mixed App\Models\Communication\Raise::setServerTime(float or null $serverTime)
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)


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
