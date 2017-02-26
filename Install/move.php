
<?php

$path = get_cfg_var('cfg_file_path');
shell_exec('mv php.ini ' . $path);
