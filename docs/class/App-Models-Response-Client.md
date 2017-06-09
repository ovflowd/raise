App\Models\Response\Client
===============

Class Client.

This is the Response Model of a Client
Contains a List of Clients


* Class name: Client
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


### $clients

    public array<mixed,\App\Models\Communication\Client> $clients = array()

A set of Clients that will be returned on the Response.



* Visibility: **public**


### 

    public \App\Models\Communication\Client 





* Visibility: **public**


Methods
-------


### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



