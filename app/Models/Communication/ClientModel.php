<?php

namespace App\Models\Communication;

/**
 * Class ClientModel.
 */
class ClientModel extends RaiseModel
{
    public $name;

    public $chipset;

    public $mac;

    public $serial;

    public $processor;

    public $channel;
}
