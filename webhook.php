<?php

$output = shell_exec("cd /srv/www/git-repo/; git pull origin {$BRANCH};");
    echo "<pre>$output</pre>";