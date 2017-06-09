App\Handlers\Settings
===============

Class Settings.

A Settings Handler manages the set of Settings that are stored on the Factory,
retrieves it, does find algorithms, and many other things


* Class name: Settings
* Namespace: App\Handlers







Methods
-------


### get

Get a Configuration Element from a Settings Model.



```php
boolean|mixed App\Handlers\Settings::get(string $configuration)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $configuration | **string** | the configuration string or model to search |


<hr>

### store

Store all Settings Blocks.



```php
mixed App\Handlers\Settings::store(array $settings)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settings | **array** | the entire set of settings block |


<hr>

### add

Tries to Add a SettingsModel with given Attributes.

Return true if created with success and if class exists, false if it not exists

```php
boolean App\Handlers\Settings::add(string $modelName, array $configurationSet)
```

#### Details:
* Visibility: **public**
* This method is **static**.


#### Parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| $modelName | **string** | the model name |
| $configurationSet | **array** | the configuration set |


<hr>
