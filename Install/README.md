Installing RAISe
=================

Installing Couchbase
---------------------

### Pre-Requisites
* Python
* CentOS 7+ ou Ubuntu 16.04+

### Installing Pre-Requisites
1. Execute the following commands: 
<br>
<b>Ubuntu</b>
<pre>
sudo apt-get install python-software-properties software-properties-common
</pre>
<b>CentOS</b>
<pre>
sudo yum install libss-devel openssl098e
</pre>

### Downloading & Installing Couchbase
1. Execute the following commands:
<br>
<b>Ubuntu</b>
<pre>
sudo apt-get install libssl-dev
sudo wget "https://packages.couchbase.com/releases/4.6.1/couchbase-server-enterprise_4.6.1-ubuntu14.04_amd64.deb"
sudo dpkg -i couchbase-server-enterprise_4.6.1-ubuntu14.04_amd64.deb
</pre>
<b>CentOS 7 (Only 7 or higher)</b>
<pre>
wget https://packages.couchbase.com/releases/4.6.1/couchbase-server-enterprise-4.6.1-centos7.x86_64.rpm
rpm -i couchbase-server-enterprise-4.6.1-centos7.x86_64.rpm
</pre>

### Configuring Couchbase
1. Execute the following commands:
<pre>
cd /opt/couchbase/bin/
./couchbase-cli cluster-init -c COUCHBASE-ADDRESS:8091 -u DESIRED USER -p DESIRED PASS --cluster-name='raise' --services=data,index,query --cluster-ramsize=CLUSTER SIZE IN MB (RAM MEMORY)
</pre>
2. Check it running by `http://SERVER-ADDRESS:8091`


Installing RAISe
----------------

### Pre-Requisites
* php 7.0+
* Apache HTTP Server 2.2+
* Apache Modules: `mod_rewrite`
* Permissions of Directory with `.htaccess`: `AllowOverride All`
* php Libraries: `curl`, `mbstring`, `libcouchbase`, `json`
* php Modules: `pecl`, `pear`, `devel` (php devel)

### Observations
* Port 8091 must be open in Firewall. This is the port used by the Couchbase library to communicate with the Couchbase. Port 8091 is also the administration port and port for querying data in Couchbase.
* Port 8091 is used by default on Couchbase

### Installing php 7.0
<b>CentOS</b><br>
  https://webtatic.com/packages/php70/<br>
<b>Ubuntu 16.04</b><br>
  Natively builtin<br>
<b>Ubuntu 14.04</b><br>
  https://www.digitalocean.com/community/tutorials/how-to-upgrade-to-php-7-on-ubuntu-14-04</br>

### Installing `libcouchbase`
1. Run those commands on your terminal.:
<br>
<b>CentOS</b>
<pre>
# Only needed during first-time setup:
wget http://packages.couchbase.com/releases/couchbase-release/couchbase-release-1.0-2-x86_64.rpm
sudo rpm -iv couchbase-release-1.0-2-x86_64.rpm
# Will install or upgrade existing packages
sudo yum install libcouchbase-devel gcc gcc-c++ zlib-devel
sudo pecl install pcs-1.3.3
sudo pecl install couchbase
</pre>
<b>Ubuntu</b>
<pre>
# Only needed during first-time setup:
wget http://packages.couchbase.com/releases/couchbase-release/couchbase-release-1.0-2-amd64.deb
sudo dpkg -i couchbase-release-1.0-2-amd64.deb
# Will install or upgrade packages
sudo apt-get update
sudo apt-get install libcouchbase-dev build-essential zlib1g-dev
sudo pecl install pcs-1.3.3
sudo pecl install couchbase
</pre>
2. Add the following on your php Configuration `php.ini` generally found on `/etc/php/7.0/cli/php.ini` or `/etc/php/7.0/apache/php.ini` or `/etc/php.ini`
<pre>
extension=json.so
extension=pcs.so
extension=couchbase.so
</pre>

### Installing RAISe
1. Download RAISe by cloning the repository or by Downloading a ZIP
2. Go to folder Install
3. Give chmod 77 to Install.php (`chmod 777 Install.php`)
4. Execute by `php Install.php`
5. Follow the setup
6. You're all set.
