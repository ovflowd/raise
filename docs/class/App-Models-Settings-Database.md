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

    public string $address = 'localhost'

Database IPv4 Address or Hostname.



* Visibility: **public**


### $user

    public string $user = 'couch'

Database Admin Username.



* Visibility: **public**


### $password

    public string $password = 'couchbase'

Database Admin Password.



* Visibility: **public**


### $database

    public string $database = 'my-database'

Desired Database for RAISe.



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



