App\Models\Response\Service
===============

Class Service.

This is the Response Model of a Service
Contains a List of Service of a Service Register set Response


* Class name: Service
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


### $services

    public array $services = array()

A set of Services that will be returned on the Response.



* Visibility: **public**


Methods
-------


### setServices

    mixed App\Models\Response\Service::setServices(array $services)

Set the Services Array.

Depending if is a Register or or List
may be an ServiceDefinition or a simple array

* Visibility: **public**


#### Arguments
* $services **array** - &lt;p&gt;array of ServiceDefinitions or simple array&lt;/p&gt;



### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



