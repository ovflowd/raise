App\Models\Response\Client
===============

Class Client.

This is the Response Model of a Client
Contains a List of Clients


* Class name: Client
* Namespace: App\Models\Response
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $code

The Applied HTTP Response Code.



```php
public integer $code
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

### $clients

A set of Clients that will be returned on the Response.



```php
public array<mixed,\App\Models\Communication\Client> $clients = array()
```

#### Details:
* Visibility: **public**

<hr>

### 





```php
public \App\Models\Communication\Client 
```

#### Details:
* Visibility: **public**

<hr>

Methods
-------


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
