cat uiot.txt

function install_sdk()
{
	sudo wget http://packages.couchbase.com/releases/couchbase-release/couchbase-release-1.0-2-amd64.deb
	sudo dpkg -i couchbase-release-1.0-2-amd64.deb
	sudo apt-get update
	sudo apt-get install libcouchbase-dev build-essential php-dev zlib1g-dev
	sudo pecl install pcs-1.3.3
	sudo pecl install couchbase
	sudo apt-get install php-curl
	cd /var/www/html ; sudo rm index.html ; sudo git init ; sudo git remote add origin https://github.com/UIoT/RAISe.git ; sudo git pull origin development
	cd /var/www/html/Install; sudo php move.php
	sudo apt install php libapache2-mod-php
    sudo apt install php7.0-mbstring
    sudo a2dismod mpm_event
    sudo a2enmod mpm_prefork
    sudo service apache2 restart

	sleep 20 &
	PID=$!
	i=1
	sp="/-\|"
	echo -n ' '
	while [ -d /proc/$PID ]
	do
	  printf "\b${sp:i++%${#sp}:1}"
	done
	sudo nano /var/www/html/Install/install.php
	sudo php /var/www/html/Install/install.php
	
}

function create_cluster()
{
	while true; do
	    read -p "We will now configure the couchbase cluster. Please input the desired Memory: " yn
	  if [ $yn -gt 512 ];
    then
				memory=$yn;
				read -p "Please input the desired username for couchbase: " username
				read -p "Please input the desired password for couchbase: " password

				cd /opt/couchbase/bin/;
				./couchbase-cli cluster-init -c 127.0.0.1:8091 -u $username -p $password --cluster-name='raise' --cluster-ramsize=$((memory+0));
				install_sdk;
				break;


		else
				echo "Memory must be higher than 512MB";
		fi

	done

}

function install_couchbase()
{
	sudo apt-get install libssl-dev;
	sudo wget "https://packages.couchbase.com/releases/4.6.0-DP/couchbase-server-enterprise_4.6.0-DP-ubuntu14.04_amd64.deb";
	sudo dpkg -i couchbase-server-enterprise_4.6.0-DP-ubuntu14.04_amd64.deb;
	create_cluster;
}

function install_prerequisites()
{
	sudo apt-get update
	sudo apt-get install git;
	sudo apt-get install apache2;
	sudo apt-get install python-software-properties software-properties-common
	sudo LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
	sudo apt-get update
	sudo apt-get install php7.0 php7.0-fpm -y
	sudo apt-get install php7.0-dev
	wget http://pear.php.net/go-pear.phar
	sudo php go-pear.phar
	sudo apt-get install python-software-properties
	sudo service apache2 restart
	install_couchbase;

}


while true; do
    read -p "We are going to install RAISe and all it's dependencies. Continue?  [Y/N] " yn
    case $yn in
        [Yy]* ) install_prerequisites; break;;
        [Nn]* ) exit;;
        * ) echo "Please answer yes or no.";;
    esac
done