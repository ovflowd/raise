App\Models\Settings\Database
===============

Class Database.

A Setting Model to describe Database settings
Supported Databases: {Couchbase}


* Class name: Database
* Namespace: App\Models\Settings
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $address

Database IPv4 Address or Hostname.



```php
public string $address = 'localhost'
```

#### Details:
* Visibility: **public**

<hr>

### $user

Database Admin Username.



```php
public string $user = 'couch'
```

#### Details:
* Visibility: **public**

<hr>

### $password

Database Admin Password.



```php
public string $password = 'couchbase'
```

#### Details:
* Visibility: **public**

<hr>

### $database

Desired Database for RAISe.



```php
public string $database = 'my-database'
```

#### Details:
* Visibility: **public**

<hr>

### 





```php
public \App\Database\Couchbase 
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
