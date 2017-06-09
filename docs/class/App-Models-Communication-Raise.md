App\Models\Communication\Raise
===============

Class Raise.

The RAISe Model is a Base Model used as definition of data
that will be stored on the Database

This Model contains all items that are by default
stored on a Document


* Class name: Raise
* Namespace: App\Models\Communication
* This is an **abstract** class
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


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



<hr>

### setClientTime

Set manually clientTime
with the ability of setting the with the current microtime.



```php
mixed App\Models\Communication\Raise::setClientTime(float or null $clientTime)
```

#### Details:
* Visibility: **public**


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



<hr>

### setServerTime

Set manually serverTime
with the ability of setting the with the current microtime.



```php
mixed App\Models\Communication\Raise::setServerTime(float or null $serverTime)
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
