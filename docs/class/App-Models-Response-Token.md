App\Models\Response\Token
===============

Class Token.

This is the Response Model of a Token
Contain a Result of Successfully Client Register
and Token Generation


* Class name: Token
* Namespace: App\Models\Response
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $codHttp

    public integer $codHttp

The Applied HTTP Response Code.



* Visibility: **public**


### $message

    public string $message

The HTTP Response Message from the RFC.



* Visibility: **public**


### $token

    public string $token

The generated JWT Hash that will be sent on the Response.



* Visibility: **public**


Methods
-------


### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



