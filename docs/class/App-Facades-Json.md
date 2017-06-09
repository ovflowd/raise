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


### jsonEncode

    string App\Facades\Json::jsonEncode(object|array $data)

Encode Data into a jSON string.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $data **object|array** - &lt;p&gt;the data to be encoded&lt;/p&gt;



### jsonDecode

    object|array App\Facades\Json::jsonDecode(string $json)

Decode a jSON String into Object.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $json **string** - &lt;p&gt;the given jSON string&lt;/p&gt;



### encode

    string App\Facades\Json::encode(string $secret, array|object|\App\Models\Communication\Model $data)

Encode data unto JWT Algorithm.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $secret **string** - &lt;p&gt;The defined secret key&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the Data to be encoded&lt;/p&gt;



### decode

    object|array|\App\Models\Communication\Model|boolean App\Facades\Json::decode(string $secret, string $hash)

Decode an JWT hash into an Object.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $secret **string** - &lt;p&gt;the given secret key&lt;/p&gt;
* $hash **string** - &lt;p&gt;the given JWT hash&lt;/p&gt;



### map

    object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::map(string|object $model, array|object|\App\Models\Communication\Model $data)

Map an object into a Model.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $model **string|object** - &lt;p&gt;the Model or Namespace of the Model to be Mapped&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the Data to be mapped&lt;/p&gt;



### doMap

    boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::doMap(string|object $model, array|object|\App\Models\Communication\Model $data, boolean $mapArray, boolean $evaluateInput)

Internal Mapping Class
Executes an Object Mapping.



* Visibility: **private**
* This method is **static**.


#### Arguments
* $model **string|object** - &lt;p&gt;the Model to be mapped or the namespace of it&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the data to be mapped&lt;/p&gt;
* $mapArray **boolean** - &lt;p&gt;If need to map as a set (array)&lt;/p&gt;
* $evaluateInput **boolean** - &lt;p&gt;If need validate the input data&lt;/p&gt;



### mapSet

    boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::mapSet(string|object $model, array|object|\App\Models\Communication\Model $data)

Map a set of Data into a specific Model type.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $model **string|object** - &lt;p&gt;the Model to be mapped or the namespace of it&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the data to be mapped&lt;/p&gt;



### compare

    boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::compare(string|object $model, array|object|\App\Models\Communication\Model $data)

Compare an Object with a Model
If the validation passes it return the Mapped Object
In other case, return a false boolean.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $model **string|object** - &lt;p&gt;the Model to be mapped or the namespace of it&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the data to be mapped&lt;/p&gt;



### compareSet

    boolean|mixed|object|\App\Models\Communication\Model|\App\Models\Communication\Raise App\Facades\Json::compareSet(string|object $model, array|object|\App\Models\Communication\Model $data)

Compare a set of Data and Map it.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $model **string|object** - &lt;p&gt;the Model to be mapped or the namespace of it&lt;/p&gt;
* $data **array|object|[array](App-Models-Communication-Model.md)** - &lt;p&gt;the data to be mapped&lt;/p&gt;



### get

    \App\Facades\Facade|string App\Facades\Facade::get()

Get the Facade Instance.



* Visibility: **public**
* This method is **static**.
* This method is defined by [App\Facades\Facade](App-Facades-Facade.md)



