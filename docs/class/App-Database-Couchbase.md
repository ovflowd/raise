App\Database\Couchbase
===============

Class Couchbase.

A Couchbase Handler is a Database Handler that
Handles and does all operations with a Couchbase Database


* Class name: Couchbase
* Namespace: App\Database
* This class implements: [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)




Properties
----------


### $connection

    private \CouchbaseCluster $connection = null

The Couchbase Connection Instance.



* Visibility: **private**


Methods
-------


### connect

    mixed App\Models\Interfaces\Database::connect(array|object $connection)

Connect to the Database.



* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)


#### Arguments
* $connection **array|object** - &lt;p&gt;the connection string&lt;/p&gt;



### destroy

    mixed App\Models\Interfaces\Database::destroy()

Destroy the Connection.

(only if the connection it's already active)

* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)




### insert

    integer|string App\Models\Interfaces\Database::insert(string $table, \App\Models\Communication\Model $data, string $primaryKey)

Insert Data on Database.



* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)


#### Arguments
* $table **string** - &lt;p&gt;desired table to insert&lt;/p&gt;
* $data **[App\Models\Communication\Model](App-Models-Communication-Model.md)** - &lt;p&gt;data to be inserted&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;defined primary key or generated&lt;/p&gt;



### select

    array|string|object App\Models\Interfaces\Database::select(string $table, \Koine\QueryBuilder\Statements\Select $query)

Select Data on Database.



* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)


#### Arguments
* $table **string** - &lt;p&gt;desired table to select&lt;/p&gt;
* $query **Koine\QueryBuilder\Statements\Select** - &lt;p&gt;a Select query to search&lt;/p&gt;



### selectById

    object|boolean App\Database\Couchbase::selectById(string $table, string $primaryKey)

Select an Object by its Identifier.



* Visibility: **public**


#### Arguments
* $table **string** - &lt;p&gt;desired bucket&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;a document identifier&lt;/p&gt;



### count

    integer App\Models\Interfaces\Database::count(string $table, string $primaryKey)

Count number of Elements of a specific Query.



* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)


#### Arguments
* $table **string** - &lt;p&gt;the desired table&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;the primary key to identify&lt;/p&gt;



### update

    array|string|object App\Models\Interfaces\Database::update(string $table, string $primaryKey, \App\Models\Communication\Model $data)

Update an Element of the Database.



* Visibility: **public**
* This method is defined by [App\Models\Interfaces\Database](App-Models-Interfaces-Database.md)


#### Arguments
* $table **string** - &lt;p&gt;desired table to update&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;desired element to update&lt;/p&gt;
* $data **[App\Models\Communication\Model](App-Models-Communication-Model.md)** - &lt;p&gt;data to update&lt;/p&gt;


