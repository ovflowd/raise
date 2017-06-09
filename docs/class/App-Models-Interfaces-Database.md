App\Models\Interfaces\Database
===============

Interface Database.

An Interface used to Describe
the default methods of an DatabaseHandler


* Interface name: Database
* Namespace: App\Models\Interfaces
* This is an **interface**






Methods
-------


### connect

    mixed App\Models\Interfaces\Database::connect(array|object $connection)

Connect to the Database.



* Visibility: **public**


#### Arguments
* $connection **array|object** - &lt;p&gt;the connection string&lt;/p&gt;



### destroy

    mixed App\Models\Interfaces\Database::destroy()

Destroy the Connection.

(only if the connection it's already active)

* Visibility: **public**




### insert

    integer|string App\Models\Interfaces\Database::insert(string $table, \App\Models\Communication\Model $data, string $primaryKey)

Insert Data on Database.



* Visibility: **public**


#### Arguments
* $table **string** - &lt;p&gt;desired table to insert&lt;/p&gt;
* $data **[App\Models\Communication\Model](App-Models-Communication-Model.md)** - &lt;p&gt;data to be inserted&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;defined primary key or generated&lt;/p&gt;



### select

    array|string|object App\Models\Interfaces\Database::select(string $table, \Koine\QueryBuilder\Statements\Select $query)

Select Data on Database.



* Visibility: **public**


#### Arguments
* $table **string** - &lt;p&gt;desired table to select&lt;/p&gt;
* $query **Koine\QueryBuilder\Statements\Select** - &lt;p&gt;a Select query to search&lt;/p&gt;



### count

    integer App\Models\Interfaces\Database::count(string $table, string $primaryKey)

Count number of Elements of a specific Query.



* Visibility: **public**


#### Arguments
* $table **string** - &lt;p&gt;the desired table&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;the primary key to identify&lt;/p&gt;



### update

    array|string|object App\Models\Interfaces\Database::update(string $table, string $primaryKey, \App\Models\Communication\Model $data)

Update an Element of the Database.



* Visibility: **public**


#### Arguments
* $table **string** - &lt;p&gt;desired table to update&lt;/p&gt;
* $primaryKey **string** - &lt;p&gt;desired element to update&lt;/p&gt;
* $data **[App\Models\Communication\Model](App-Models-Communication-Model.md)** - &lt;p&gt;data to update&lt;/p&gt;


