<?php

namespace Raise;

include('Treaters/RequestTreater.php');

use Raise\Treaters\RequestTreater;

$t = new RequestTreater();

echo json_encode($t->execute(),JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
