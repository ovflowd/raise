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

    public string $databaseType = 'couchbase'

The desired DatabaseHandler that will be used
 as Handler for current RAISe environment.



* Visibility: **public**


### $path

    public string $path = ''

The base path of RAISe, like SCHEMA://URL/BASE-PATH,
by default is empty that means that RAISe it's running
on the DocumentRoot.



* Visibility: **public**


### 

    public \App\Database\Couchbase 





* Visibility: **public**


Methods
-------


### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



