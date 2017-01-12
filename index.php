<?php

namespace Raise;

include('Treaters/RequestTreater.php');

use Raise\Treaters\RequestTreater;

error_reporting(E_ALL);

$t = new RequestTreater();

echo $t->execute();
