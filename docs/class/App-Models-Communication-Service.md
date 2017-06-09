App\Models\Communication\Service
===============

Class Service.

A Service Model is a Schema Definition of
A Service and how it will be stored on the Database


* Class name: Service
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $id

    public string $id = ''

The Unique Identifier of the Service
used on the Response.



* Visibility: **public**


### $name

    public string $name

The Service Name.

The Service name uses approaches for contextual Data
so we recommend using names that can related
of what exactly that service does

* Visibility: **public**


### $parameters

    public array $parameters = array()

Parameters of the Service.

The parameters are like the header definitions
defines what a Data must have when it's registered
unto a Service

* Visibility: **public**


### $returnType

    public string $returnType = 'string'

Return Type of a Service.

This is like what the Service return exactly
and the returned data of the headers() definition
it's used as an response for a client

* Visibility: **public**


### $clientId

    protected string $clientId = ''

The Unique Client Identifier.

Each Service is related to an Service,
this identified which Client the Service is associated

* Visibility: **protected**


### $clientTime

    public float $clientTime

The time when the Client requested the operation.



* Visibility: **public**


### $tags

    public array $tags = array()

Tags Identifiers.

Tags are used to contextual data filtering
and may be used to filter set of results

* Visibility: **public**


### $serverTime

    protected float $serverTime

The time when the server handled the operation and inserted it.



* Visibility: **protected**


Methods
-------


### __construct

    mixed App\Models\Communication\Raise::__construct()

RaiseModel constructor.

Set the Timestamps of when RAISe handled
this model.

* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)




### getClientId

    string App\Models\Communication\Service::getClientId()

Get the Related Client Unique Identifier.



* Visibility: **public**




### setClientId

    mixed App\Models\Communication\Service::setClientId(string|null $clientId)

Set the Unique Client Identifier
That is related to this Service.



* Visibility: **public**


#### Arguments
* $clientId **string|null** - &lt;p&gt;the ClientId to be set&lt;/p&gt;



### setClientTime

    mixed App\Models\Communication\Raise::setClientTime(float|null $clientTime)

Set manually clientTime
with the ability of setting the with the current microtime.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)


#### Arguments
* $clientTime **float|null** - &lt;p&gt;Client Sent Time on UNIX_TIMESTAMP with milliseconds&lt;/p&gt;



### getServerTime

    float App\Models\Communication\Raise::getServerTime()

Time when the server registered the Data.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)




### setServerTime

    mixed App\Models\Communication\Raise::setServerTime(float|null $serverTime)

Set manually serverTime
with the ability of setting the with the current microtime.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Raise](App-Models-Communication-Raise.md)


#### Arguments
* $serverTime **float|null** - &lt;p&gt;Server Time on UNIX_TIMESTAMP with milliseconds&lt;/p&gt;



### encode

    array App\Models\Communication\Model::encode()

Get all public properties of the Model
It's used for the Response Mapping on Lists.



* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



