App\Models\Response\Message
===============

Class Message.

A base Model used to output HTTP Messages,
the content of it are gathered from the Database
and defined by the RFC


* Class name: Message
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

### $details

Additional Details that can be defined
and will be sent also on the Response.



```php
public string $details
```

#### Details:
* Visibility: **public**

<hr>

### 





```php
public \App\Models\Interfaces\Database 
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
