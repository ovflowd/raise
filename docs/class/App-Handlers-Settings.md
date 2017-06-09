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

    boolean|mixed App\Handlers\Settings::get(string $configuration)

Get a Configuration Element from a Settings Model.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $configuration **string** - &lt;p&gt;the configuration string or model to search&lt;/p&gt;



### store

    mixed App\Handlers\Settings::store(array $settings)

Store all Settings Blocks.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $settings **array** - &lt;p&gt;the entire set of settings block&lt;/p&gt;



### add

    boolean App\Handlers\Settings::add(string $modelName, array $configurationSet)

Tries to Add a SettingsModel with given Attributes.

Return true if created with success and if class exists, false if it not exists

* Visibility: **public**
* This method is **static**.


#### Arguments
* $modelName **string** - &lt;p&gt;the model name&lt;/p&gt;
* $configurationSet **array** - &lt;p&gt;the configuration set&lt;/p&gt;


