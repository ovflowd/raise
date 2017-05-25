<?php

namespace App\Models\Communication;

/**
 * Class ClientModel.
 */
class ClientModel extends RaiseModel
{
    /**
     * Client Name.
     *
     * @var string
     */
    public $name = 'default client';

    /**
     * Client Chipset Model.
     *
     * @var string
     */
    public $chipset = '0000000000';

    /**
     * Client Mac Address.
     *
     * @var string
     */
    public $mac = 'FF:FF:FF:FF';

    /**
     * Client Serial Model.
     *
     * @var string
     */
    public $serial = '1.0.0';

    /**
     * Client Processor Model.
     *
     * @var string
     */
    public $processor = 'i86-generic';

    /**
     * Client Communication Channel.
     *
     * @var string
     */
    public $channel = 'ieee-wireless-80211';
}
