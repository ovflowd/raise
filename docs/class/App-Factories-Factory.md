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

Elements of the Factory.



```php
protected array $elements = array()
```

#### Details:
* Visibility: **protected**

<hr>

Methods
-------


### get

Get an Element.

If the element exists return in,
If not return a false boolean.

```php
object|array|boolean App\Factories\Factory::get(string $element)
```

#### Details:
* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $element | **string** | name of the element |


<hr>

### add

Add an Element.



```php
boolean App\Factories\Factory::add(string $element, array or object $content)
```

#### Details:
* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $element | **string** | the name of the element to be added |
| $content | array or object | the content of the element |


<hr>

### remove

Remove an Element.

Return true if removed with success, false if element doesn't exists

```php
boolean App\Factories\Factory::remove(string $element)
```

#### Details:
* Visibility: **public**
* This method is **abstract**.
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $element | **string** | the element to be removed |


<hr>

### instance

Create an Instance if not exists
If exists, return the instance.



```php
\App\Factories\Factory App\Factories\Factory::instance()
```

#### Details:
* Visibility: **protected**
* This method is **static**.



<hr>
