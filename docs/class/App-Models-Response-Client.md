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


### $codHttp

The Applied HTTP Response Code.



```php
public integer $codHttp
```

#### Details:
* Visibility: **public**


### $message

The HTTP Response Message from the RFC.



```php
public string $message
```

#### Details:
* Visibility: **public**


### $clients

A set of Clients that will be returned on the Response.



```php
public array<mixed,\App\Models\Communication\Client> $clients = array()
```

#### Details:
* Visibility: **public**


### 





```php
public \App\Models\Communication\Client 
```

#### Details:
* Visibility: **public**


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



