App\Facades\Log
===============

Class Log.

(Actually a Facade, but Manages the Logs)

A Manager is a Mediator, it does specific processes and operations
to make everything available and functional for the rest of the components.

A Log Manager manages the I/O of the Logs and their availability and data.


* Class name: Log
* Namespace: App\Facades
* Parent class: [App\Facades\Facade](App-Facades-Facade.md)







Methods
-------


### log

Add a Log Entry on the Database.



```php
boolean|string App\Facades\Log::log(string $element, string $table, string $details, string or object or null $givenToken)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $element | **string** | Unique Identifier of the Inserted Element (if exists) |
| $table | **string** | Related Table of the Operations related to this Log entry |
| $details | **string** | Details upon the Operation behind the Log |
| $givenToken | string or object or null | A Token (JWT) can also be given |


<hr>

### get

Get the Facade Instance.



```php
\App\Facades\Facade|string App\Facades\Facade::get()
```

#### Details:
* Visibility: **public**
* This method is **static**.
* This method is defined by [App\Facades\Facade](App-Facades-Facade.md)



<hr>
