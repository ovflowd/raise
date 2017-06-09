App\Models\Settings\Raise
===============

Class Raise.

A Setting Model used to describe the current
environment of RAISe will operate.


* Class name: Raise
* Namespace: App\Models\Settings
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $databaseType

The desired DatabaseHandler that will be used
 as Handler for current RAISe environment.



```php
public string $databaseType = 'couchbase'
```

#### Details:
* Visibility: **public**

<hr>

### $path

The base path of RAISe, like SCHEMA://URL/BASE-PATH,
by default is empty that means that RAISe it's running
on the DocumentRoot.



```php
public string $path = ''
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
