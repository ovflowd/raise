<p align="center">
  <img src="http://imgur.com/iQU8c9L.png"/>
  <h4 align="center">RAISe</h4>
  <p align="center">
    <img src="https://img.shields.io/badge/platform-macOS%20%7C%20Linux%20%7C%20Windows-lightgrey.svg"/>
  </p>
</p>

UIoT RAISe
----------

**RAISe** is an *Internet of Things* open middleware. Made to handle and store knowledge and be a restful service layer for IoT applications, clients and devices.

**RAISe** is open source, and maintained by the [Universal Internet of Things](https://uiot.org) open source project and the [University of Brasília](http://www.unb.br).


### What the word means?

> **RAISe** is an acronym for *RESTful API for Internet of Things Services*. In terms, RAISe it's abstract and generic and can handle data, knowledge and information for any type of architecture that you may use, require, create or contribute.

### Go deep!

> In fact, **RAISe** it's a knowledge layer, in other words, a middleware for the *Internet of Things*, we can actually call it as an surface too.
> The *API's* of **RAISe** are really simple, you can search more about what each *actor*, *component*, *api* and *entities* of **RAISe** on our [wiki](wiki). You also can read the papers related to the **RAISe** architecture and approaches, our went to our [academics repository](https://github.com/uiot/academics) and learn/read more about the **UIoT** architecture, papers, power-points and other related academic stuff.


Installation in four steps
------------------------------

With [Docker](https://docs.docker.com/) and [Docker Compose](https://docs.docker.com/compose/) installed, just go to the **RAISe** installation folder and follow these four instructions:

**First**: build the containers

```bash
docker-compose build
```

**Second**: run the containers using

```bash
docker-compose up -d
```

**Third**: set the database up

Access the Couchbase container using `docker-compose exec couchbase bash`
and configure it:

```bash
/opt/couchbase/bin/couchbase-cli cluster-init -c COUCHBASE-ADDRESS:8091 --cluster-username=DESIRED USER --cluster-password=DESIRED PASS --cluster-name='raise' --services=data,index,query --cluster-ramsize=CLUSTER SIZE IN MB (RAM MEMORY) --cluster-index-ramsize=256
```
*Observation:* replace `DESIRED USER`, `DESIRED PASS` and `CLUSTER SIZE IN MB (RAM MEMORY)` with your own values.

**Fourth**: set RAISe up

Access the RAISe container using `docker-compose exec raise bash`
and configure it with your previously defined values:

```bash
php /app/install/install.php
```

Now you're ready to go!


More about the installation
---------------------------

You can install <b>RAISe</b> by easily going on our [Wiki](wiki) and check the Installation Pages.

Any troubles that you may/have, check our [Contributing/Reporting Guide](CONTRIBUTING.md).

You can also check the [Table of Contents of the RAISe Installer](wiki/installer-reference).


Contributing
------------

You can <b>Contribute</b> on RAISe! <b>RAISe</b> is open source, and everyone can contribute on it.

Check the [Contributing Guide](CONTRIBUTING.md).

If you're a collaborator check out our **Waffle**. [![](https://img.shields.io/badge/waffle-uiot%2Fraise-blue.svg)](https://waffle.io/uiot/raise)

Documentation
-------------

You can learn more about the <b>RAISe</b> architecture by checking our [Wiki](wiki)

<b>You also may read those scientific papers</b> that explain about the <b>UIoT</b> architecture and the key features, and lot more about <b>RAISe</b>
* [Design and Evaluation of a Services Interface for the Internet of Things](http://dl.acm.org/citation.cfm?id=3023305)
* Other papers being added on the list.

You can also **fetch** the [API Documentation](docs/) and check it **online** by using [Swagger UI](http://docs.uiot.org/raise/).

<br>
<br>
<img align="right" src="http://imgur.com/l5hOjj4.gif">
