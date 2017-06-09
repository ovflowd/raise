App\Models\Settings\Security
===============

Class Security.

A Setting Model that describes Security Interfaces,
that are used for Security artifacts.


* Class name: Security
* Namespace: App\Models\Settings
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $expireTime

    public string $expireTime = '2hours'

The Authorization Token expire time,
this property uses the php's strtotime()
method to describe how many time will be added
until the token expires summed with the current time.



* Visibility: **public**


### $secretKey

    public string $secretKey = 'default-raise-secret-key'

The Secret Key that will be used on the JWT hash,
the JWT hash is used as Authentication Hash on RAISe.



* Visibility: **public**


### 

    public \App\Models\Settings\Security 





* Visibility: **public**


Methods
-------


### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



