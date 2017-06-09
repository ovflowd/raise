App\Models\Communication\ServiceBag
===============

Class ServiceBag.

A Service Bag Model it's used
as a definition for a Service Register Definition

The ServiceBag definition isn't used as Service Definition
but as outer object Definition, since inside a ServiceBag
are stored set of Services


* Class name: ServiceBag
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $services

A set of Services that will be Registered.



```php
public array<mixed,\App\Models\Communication\Service> $services = array()
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

### 





```php
public \App\Models\Communication\Service 
```

#### Details:
* Visibility: **public**

<hr>

Methods
-------


### setServices

Stores a set of Services (ServiceModel)
inside a Service Bag.



```php
mixed App\Models\Communication\ServiceBag::setServices(array<mixed,\App\Models\Communication\Service> $services)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $services | array&lt;mixed,\App\Models\Communication\Service&gt; |  |


<hr>

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
| $clientTime | float or null |  - Client Sent Time on UNIX_TIMESTAMP with milliseconds |


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
| $serverTime | float or null |  - Server Time on UNIX_TIMESTAMP with milliseconds |


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
