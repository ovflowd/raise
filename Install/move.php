<?php
shell_exec('cp -f /var/www/html/Install/php.ini ' .  get_cfg_var('cfg_file_path'));
shell_exec('cp -f /var/www/html/Install/php.ini ' . '/etc/php/7.1/apache2/php.ini');