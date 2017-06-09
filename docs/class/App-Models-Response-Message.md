App\Models\Response\Message
===============

Class Message.

A base Model used to output HTTP Messages,
the content of it are gathered from the Database
and defined by the RFC


* Class name: Message
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


### $details

    public string $details

Additional Details that can be defined
and will be sent also on the Response.



* Visibility: **public**


### 

    public \App\Models\Interfaces\Database 





* Visibility: **public**


Methods
-------


### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



