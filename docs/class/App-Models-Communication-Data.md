App\Models\Communication\Data
===============

Class Data.

A Data Model is a Schema Definition of
A Data and how it will be stored on the Database


* Class name: Data
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $serviceId

Each Data it's associated to a specific Service.

serviceId is the Unique Service Identifier
that needs to be stored on the data to link it.

```php
public string $serviceId = null
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

### $parameters

An array that contains the parameters of the
Service related to this Data.



```php
public array $parameters = array()
```

#### Details:
* Visibility: **public**

<hr>

### $values

A Set of Data.

A data set contain an array
of data that follows a service parameters pattern
an data element need to include values for all
the parameters of an service.

```php
public array $values = array()
```

#### Details:
* Visibility: **public**

<hr>

### $clientTime

The time when the Client requested the operation.



```php
protected float $clientTime
```

#### Details:
* Visibility: **protected**

<hr>

### $tags

Tags Identifiers.

Tags are used to contextual data filtering
and may be used to filter set of results

```php
protected array $tags = array()
```

#### Details:
* Visibility: **protected**

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

### setServiceId

Set a serviceId.

This method verifies if the given serviceId
exists, if doesn't, throws an validation error.

```php
mixed App\Models\Communication\Data::setServiceId(string $serviceId)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $serviceId | **string** | the service identifier
                         related to this data. |


<hr>

### setClientId

Set the Unique Client Identifier
That is related to this Service.



```php
mixed App\Models\Communication\Data::setClientId(string or null $clientId)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $clientId | string or null | the ClientId to be set |


<hr>

### setOrder

Set the data's order.

This method sets the order that data will be sent
at. The order is useful to identify which element
of a data set refers to which parameter of a Service

```php
mixed App\Models\Communication\Data::setOrder(array $parameters)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $parameters | **array** | The array specifying the Service
parameters with a given (arbitrary/user specified) order |


<hr>

### setValues

Sets the data.

This method sets the data array that
has the same number of parameters as
the order array.

```php
mixed App\Models\Communication\Data::setValues(array $dataSet)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $dataSet | **array** | A data set contain an array
                      of data that follows a service parameters pattern
                      an data element need to include values for all
                      the parameters of an service. |


<hr>

### orderData

Order a Set of Data.

Order Data based on Service Parameters and his Order Set

```php
array|null App\Models\Communication\Data::orderData(array $values, \App\Models\Communication\Service or \App\Models\Communication\Model $service)
```

#### Details:
* Visibility: **protected**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $values | **array** | A set of Values to be Ordered |
| $service | App\Models\Communication\Service or \App\Models\Communication\Model | A given Service |


<hr>

### checkSize

Compare the size of two Arrays.



```php
boolean App\Models\Communication\Data::checkSize(array $needle, array $haystack)
```

#### Details:
* Visibility: **protected**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $needle | **array** | Array to compare |
| $haystack | **array** | Array to be compared |


<hr>

### setTags

Set an array of Tags.

Tags are used to contextual data filtering
and may be used to filter set of results

```php
mixed App\Models\Communication\Raise::setTags(array $tags)
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $tags | **array** | The tags to be stored |


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
