<?php

namespace App\Events;

use App\Models\OneHourElectricity;
use Illuminate\Queue\SerializesModels;

class OneHourElectricityCreated
{
    use SerializesModels;

    /**
     * @var \App\Models\OneHourElectricity
     */
    public $oneHourElectricity;

    /**
     * Create the event.
     *
     * @param App\Models\OneHourElectricity $oneHourElectricity
     * @return void
     */
    public function __construct(OneHourElectricity $oneHourElectricity)
    {
        $this->oneHourElectricity = $oneHourElectricity;
    }
}
