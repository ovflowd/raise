App\Models\Response\Service
===============

Class Service.

This is the Response Model of a Service
Contains a List of Service of a Service Register set Response


* Class name: Service
* Namespace: App\Models\Response
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $codHttp

The Applied HTTP Response Code.



```php
public integer $codHttp
```

#### Details:
* Visibility: **public**

<hr>

### $message

The HTTP Response Message from the RFC.



```php
public string $message
```

#### Details:
* Visibility: **public**

<hr>

### $services

A set of Services that will be returned on the Response.



```php
public array $services = array()
```

#### Details:
* Visibility: **public**

<hr>

Methods
-------


### setServices

Set the Services Array.

Depending if is a Register or or List
may be an ServiceDefinition or a simple array

```php
mixed App\Models\Response\Service::setServices(array $services)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $services | array |  - array of ServiceDefinitions or simple array |


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
