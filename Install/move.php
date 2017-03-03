<?php
shell_exec('mv php.ini ' . "pphp.ini");
$path = get_cfg_var('cfg_file_path');
shell_exec('mv php.ini ' . $path);
$path = '/etc/php/7.1/apache2/php.ini';
shell_exec('mv pphp.ini ' . $path);