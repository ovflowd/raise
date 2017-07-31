App\Models\Communication\Chart
===============

Class Chart.

A Chart Model it's a Data Set for
 ChartJS Library


* Class name: Chart
* Namespace: App\Models\Communication
* Parent class: [App\Models\Communication\Model](App-Models-Communication-Model.md)





Properties
----------


### $label

The Label of the DataSet.



```php
public string $label = ''
```

#### Details:
* Visibility: **public**

<hr>

### $data

The content of the Data Set.



```php
public array $data = array()
```

#### Details:
* Visibility: **public**

<hr>

### $fill

If the content of the Lines will be filled
 by the same color of the line.



```php
public boolean $fill = true
```

#### Details:
* Visibility: **public**

<hr>

Methods
-------


### setData

Iterate between an Data Set of Data Documents
 and rearrange it to the Chart.JS Data Document pattern.



```php
mixed App\Models\Communication\Chart::setData(array $data)
```

#### Details:
* Visibility: **public**


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $data | **array** | the Data Set to be Hooked |


<hr>

### encode

Get all public properties of the Model
It's used for the Response Mapping on Lists.



```php
array App\Models\Communication\Model::encode()
```

#### Details:
* Visibility: **public**
* This method is defined by [App\Models\Communication\Model](App-Models-Communication-Model.md)



<hr>
