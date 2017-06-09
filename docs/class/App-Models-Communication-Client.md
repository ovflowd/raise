App\Models\Communication\Client
===============

Class Client.

A Client Model is a Schema Definition of
A Client and how it will be stored on the Database


* Class name: Client
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $name

Client Name.

A Name given for the Client, can be anything

```php
public string $name = 'default client'
```

#### Details:
* Visibility: **public**

<hr>

### $chipset

Client Chipset Model.

The chipset of the Client or
Unique Device/Hardware Identifier

```php
public string $chipset = '0000000000'
```

#### Details:
* Visibility: **public**

<hr>

### $mac

Client Mac Address.

A Mac Address of the Network/Communication Chipset
of the Client, or of the Client Gateway

```php
public string $mac = 'FF:FF:FF:FF'
```

#### Details:
* Visibility: **public**

<hr>

### $serial

Client Serial.

The Unique Serial Number/Vendor Number of the Client
Given by the Industry of Vendor

```php
public string $serial = '1.0.0'
```

#### Details:
* Visibility: **public**

<hr>

### $processor

Client Processor.

The Processor Identifier, or common name
or generic name to be identified

```php
public string $processor = 'i86-generic'
```

#### Details:
* Visibility: **public**

<hr>

### $channel

Client Communication Channel.

The type of communication used on the Client,

```php
public string $channel = 'ieee-wireless-80211'
```

#### Details:
* Visibility: **public**

<hr>

### $location

Client Location or nearest path.

Based on Latitude : Longitude

```php
public string $location = '-15.7757876:-48.077829'
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
