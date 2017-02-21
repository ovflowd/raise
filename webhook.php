<?php

$output = shell_exec("cd /var/www/RAISe/; git pull");
    echo "<pre>$output</pre>";