App\Factories\Factory
===============

Class Factory.

A Design Pattern used to manage
and manipulate data set.


* Class name: Factory
* Namespace: App\Factories
* This is an **abstract** class





Properties
----------


### $elements

    protected array $elements = array()

Elements of the Factory.



* Visibility: **protected**


Methods
-------


### get

    object|array|boolean App\Factories\Factory::get(string $element)

Get an Element.

If the element exists return in,
If not return a false boolean.

* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Arguments
* $element **string** - &lt;p&gt;name of the element&lt;/p&gt;



### add

    boolean App\Factories\Factory::add(string $element, array|object $content)

Add an Element.



* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Arguments
* $element **string** - &lt;p&gt;the name of the element to be added&lt;/p&gt;
* $content **array|object** - &lt;p&gt;the content of the element&lt;/p&gt;



### remove

    boolean App\Factories\Factory::remove(string $element)

Remove an Element.

Return true if removed with success, false if element doesn't exists

* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Arguments
* $element **string** - &lt;p&gt;the element to be removed&lt;/p&gt;



### instance

    \App\Factories\Factory App\Factories\Factory::instance()

Create an Instance if not exists
If exists, return the instance.



* Visibility: **protected**
* This method is **static**.



