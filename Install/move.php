<?php
shell_exec('mv /var/www/html/Install/php.ini ' . "/var/www/html/Install/pphp.ini");
$path = get_cfg_var('cfg_file_path');
shell_exec('mv /var/www/html/Install/php.ini ' . $path);
$path = '/etc/php/7.1/apache2/php.ini';
shell_exec('mv /var/www/html/Install/pphp.ini ' . $path);