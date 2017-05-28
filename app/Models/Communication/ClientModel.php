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
     * @required
     *
     * @var string
     */
    public $name = 'default client';

    /**
     * Client Chipset Model.
     *
     * @required
     *
     * @var string
     */
    public $chipset = '0000000000';

    /**
     * Client Mac Address.
     *
     * @required
     *
     * @var string
     */
    public $mac = 'FF:FF:FF:FF';

    /**
     * Client Serial Model.
     *
     * @required
     *
     * @var string
     */
    public $serial = '1.0.0';

    /**
     * Client Processor Model.
     *
     * @required
     *
     * @var string
     */
    public $processor = 'i86-generic';

    /**
     * Client Communication Channel.
     *
     * @required
     *
     * @var string
     */
    public $channel = 'ieee-wireless-80211';
}
