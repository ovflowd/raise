<?php

$path = get_cfg_var('cfg_file_path');
shell_exec('cp php.ini ' . $path);
$path = '/etc/php/7.1/apache2/php.ini';
shell_exec('cp php.ini ' . $path);