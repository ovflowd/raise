App\Models\Interfaces\Database
===============

Interface Database.

An Interface used to Describe
the default methods of an DatabaseHandler


* Interface name: Database
* Namespace: App\Models\Interfaces
* This is an **interface**






Methods
-------


### connect

Connect to the Database.



```php
mixed App\Models\Interfaces\Database::connect(array or object $connection)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $connection | array or object | the connection string |


<hr>

### destroy

Destroy the Connection.

(only if the connection it's already active)

```php
mixed App\Models\Interfaces\Database::destroy()
```

#### Details:
* Visibility: **public**



<hr>

### insert

Insert Data on Database.



```php
integer|string App\Models\Interfaces\Database::insert(string $table, \App\Models\Communication\Model $data, string $primaryKey)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $table | **string** | desired table to insert |
| $data | [App\Models\Communication\Model](App-Models-Communication-Model.md) | data to be inserted |
| $primaryKey | **string** | defined primary key or generated |


<hr>

### select

Select Data on Database.



```php
array|string|object App\Models\Interfaces\Database::select(string $table, \Koine\QueryBuilder\Statements\Select or \Koine\QueryBuilder $query)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $table | **string** | desired table to select |
| $query | Koine\QueryBuilder\Statements\Select or \Koine\QueryBuilder | a Select query to search |


<hr>

### update

Update an Element of the Database.



```php
array|string|object App\Models\Interfaces\Database::update(string $table, string $primaryKey, \App\Models\Communication\Model or object $data)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $table | **string** | desired table to update |
| $primaryKey | **string** | desired element to update |
| $data | App\Models\Communication\Model or object | data to update |


<hr>

### delete

Delete an Element of the Database.



```php
mixed App\Models\Interfaces\Database::delete(string $table, string $primaryKey)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $table | **string** | desired table to update |
| $primaryKey | **string** | desired element to delete |


<hr>
