<?php

//$path = get_cfg_var('cfg_file_path');
$path = '/etc/php/7.1/apache2/php.ini';
shell_exec('mv php.ini ' . $path);