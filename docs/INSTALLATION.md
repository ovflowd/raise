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
