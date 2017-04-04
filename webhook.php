<?php

$output = shell_exec("cd /var/www/opt/RAISe/; git pull 2>&1");
    var_dump($output);