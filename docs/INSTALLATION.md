Installation in four steps
------------------------------

With [Docker](https://docs.docker.com/) and [Docker Compose](https://docs.docker.com/compose/) installed, just go to the **RAISe** installation folder and follow these three instructions:

**First**: set the database up (optional)

This is an optional step in development environment.
But, for safety reasons, set your own username and password to access the RAISe's database when you'd be in production (or even in a server).
To do that, access the file named `.env` with your favorite text editor and type your configuration.

In this file, you can also configure the ammount of memory the database will be able to use.

*Note:* We recommend to use at least 4 GB as base RAM and 1 GB for index RAM.


**Second**: build the containers

```bash
docker-compose build --no-cache
```

**Third**: run the containers using

```bash
docker-compose up
```


Now you're ready to go!


More about the installation
---------------------------

You can install <b>RAISe</b> by easily going on our [Wiki](wiki) and check the Installation Pages.

Any troubles that you may/have, check our [Contributing/Reporting Guide](CONTRIBUTING.md).

You can also check the [Table of Contents of the RAISe Installer](wiki/installer-reference).
