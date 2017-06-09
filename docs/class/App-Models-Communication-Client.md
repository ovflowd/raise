App\Models\Communication\Client
===============

Class Client.

A Client Model is a Schema Definition of
A Client and how it will be stored on the Database


* Class name: Client
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $name

    public string $name = 'default client'

Client Name.

A Name given for the Client, can be anything

* Visibility: **public**


### $chipset

    public string $chipset = '0000000000'

Client Chipset Model.

The chipset of the Client or
Unique Device/Hardware Identifier

* Visibility: **public**


### $mac

    public string $mac = 'FF:FF:FF:FF'

Client Mac Address.

A Mac Address of the Network/Communication Chipset
of the Client, or of the Client Gateway

* Visibility: **public**


### $serial

    public string $serial = '1.0.0'

Client Serial.

The Unique Serial Number/Vendor Number of the Client
Given by the Industry of Vendor

* Visibility: **public**


### $processor

    public string $processor = 'i86-generic'

Client Processor.

The Processor Identifier, or common name
or generic name to be identified

* Visibility: **public**


### $channel

    public string $channel = 'ieee-wireless-80211'

Client Communication Channel.

The type of communication used on the Client,

* Visibility: **public**


### $location

    public string $location = '-15.7757876:-48.077829'

Client Location or nearest path.

Based on Latitude : Longitude

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



