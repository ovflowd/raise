<?php

namespace Raise;

include('Treaters/RequestTreater.php');

use Raise\Treaters\RequestTreater;

$t = new RequestTreater();

echo $t->execute();
