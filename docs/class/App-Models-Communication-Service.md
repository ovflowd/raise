App\Models\Communication\Service
===============

Class Service.

A Service Model is a Schema Definition of
A Service and how it will be stored on the Database


* Class name: Service
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $id

The Unique Identifier of the Service
used on the Response.



```php
public string $id = ''
```

#### Details:
* Visibility: **public**

<hr>

### $name

The Service Name.

The Service name uses approaches for contextual Data
so we recommend using names that can related
of what exactly that service does

```php
public string $name
```

#### Details:
* Visibility: **public**

<hr>

### $parameters

Parameters of the Service.

The parameters are like the header definitions
defines what a Data must have when it's registered
unto a Service

```php
public array $parameters = array()
```

#### Details:
* Visibility: **public**

<hr>

### $returnType

Return Type of a Service.

This is like what the Service return exactly
and the returned data of the headers() definition
it's used as an response for a client

```php
public string $returnType = 'string'
```

#### Details:
* Visibility: **public**

<hr>

### $clientId

The Unique Client Identifier.

Each Service is related to an Service,
this identified which Client the Service is associated

```php
protected string $clientId = ''
```

#### Details:
* Visibility: **protected**

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

### getClientId

Get the Related Client Unique Identifier.



```php
string App\Models\Communication\Service::getClientId()
```

#### Details:
* Visibility: **public**



<hr>

### setClientId

Set the Unique Client Identifier
That is related to this Service.



```php
mixed App\Models\Communication\Service::setClientId(string or null $clientId)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $clientId | **string or null |  - the ClientId to be set |


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
| $clientTime | **float or null |  - Client Sent Time on UNIX_TIMESTAMP with milliseconds |


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
| $serverTime | **float or null |  - Server Time on UNIX_TIMESTAMP with milliseconds |


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
