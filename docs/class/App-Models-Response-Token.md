App\Models\Response\Token
===============

Class Token.

This is the Response Model of a Token
Contain a Result of Successfully Client Register
and Token Generation


* Class name: Token
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

### $token

The generated JWT Hash that will be sent on the Response.



```php
public string $token
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
