App\Models\Communication\Token
===============

Class Token.

A Token Model is a Schema Definition of
A Token and how it will be stored on the Database


* Class name: Token
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Raise](App-Models-Communication-Raise.md)





Properties
----------


### $clientId

    public string $clientId

The Client Unique Identifier.

Each Token expires, but the Client Definition does not,
each Token it's related to an Unique Client,

Token changes, Clients doesn't not.

* Visibility: **public**


### $expireTime

    public float $expireTime

Token Expire Time.

When the Token goes expire,
in seconds.milliseconds on UNIX Timestamp

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




### setExpireTime

    \App\Models\Communication\Token App\Models\Communication\Token::setExpireTime()

Set the Token Expire Time.



* Visibility: **public**




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



