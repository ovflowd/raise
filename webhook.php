<?php

$output = shell_exec('cd /var/www/RAISe/; git pull 2>&1');
    var_dump($output);
