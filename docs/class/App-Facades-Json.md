App\Facades\Json
===============

Class Json.

A Facade that handles and manages the mapping
of objects, data and arrays, and also the encoding of data
like as JWT encoding


* Class name: Json
* Namespace: App\Facades
* Parent class: [App\Facades\Facade](App-Facades-Facade.md)







Methods
-------


<hr>

### jsonEncode

Encode Data into a jSON string.



```php
string App\Facades\Json::jsonEncode(object or array $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $data | object or array |  - the data to be encoded |



<hr>

### jsonDecode

Decode a jSON String into Object.



```php
object|array App\Facades\Json::jsonDecode(string $json)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $json | string |  - the given jSON string |



<hr>

### encode

Encode data unto JWT Algorithm.



```php
string App\Facades\Json::encode(string $secret, array or object or \App\Models\Communication\Model $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $secret | string |  - The defined secret key |
| $data | array or object or \App\Models\Communication\Model |  - the Data to be encoded |



<hr>

### decode

Decode an JWT hash into an Object.



```php
object|array|\App\Models\Communication\Model|boolean App\Facades\Json::decode(string $secret, string $hash)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $secret | string |  - the given secret key |
| $hash | string |  - the given JWT hash |



<hr>

### map

Map an object into a Model.



```php
object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::map(string or object $model, array or object or \App\Models\Communication\Model $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $model | string or object |  - the Model or Namespace of the Model to be Mapped |
| $data | array or object or \App\Models\Communication\Model |  - the Data to be mapped |



<hr>

### doMap

Internal Mapping Class
Executes an Object Mapping.



```php
boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::doMap(string or object $model, array or object or \App\Models\Communication\Model $data, boolean $mapArray, boolean $evaluateInput)
```

#### Details:
* Visibility: **private**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $model | string or object |  - the Model to be mapped or the namespace of it |
| $data | array or object or \App\Models\Communication\Model |  - the data to be mapped |
| $mapArray | boolean |  - If need to map as a set (array) |
| $evaluateInput | boolean |  - If need validate the input data |



<hr>

### mapSet

Map a set of Data into a specific Model type.



```php
boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::mapSet(string or object $model, array or object or \App\Models\Communication\Model $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $model | string or object |  - the Model to be mapped or the namespace of it |
| $data | array or object or \App\Models\Communication\Model |  - the data to be mapped |



<hr>

### compare

Compare an Object with a Model
If the validation passes it return the Mapped Object
In other case, return a false boolean.



```php
boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::compare(string or object $model, array or object or \App\Models\Communication\Model $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $model | string or object |  - the Model to be mapped or the namespace of it |
| $data | array or object or \App\Models\Communication\Model |  - the data to be mapped |



<hr>

### compareSet

Compare a set of Data and Map it.



```php
boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::compareSet(string or object $model, array or object or \App\Models\Communication\Model $data)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $model | string or object |  - the Model to be mapped or the namespace of it |
| $data | array or object or \App\Models\Communication\Model |  - the data to be mapped |



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



