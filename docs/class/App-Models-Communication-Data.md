App\Models\Communication\Data
===============

Class Data.

A Data Model is a Schema Definition of
A Data and how it will be stored on the Database


* Class name: Data
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $serviceId

    public string $serviceId = ''

Each Data it's associated to a specific Service.

the serviceId it's the Unique Service Identifier
that need be stored on the data to link it.

* Visibility: **public**


### $data

    public array $data = array()

An array of Data
the Data set need follow the key:value pattern
You can send anything as data.



* Visibility: **public**


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



