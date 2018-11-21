<?php

namespace App\Observers;

use App\Events\OneHourElectricityCreated;
use App\Models\OneHourElectricity;

class OneHourElectricityObserver
{
    /**
     * Invoke Event OneHourElectricityCreated
     *
     * @param \App\Models\OneHourElectricity $oneHourElectricity
     * @return void
     */
    public function created(OneHourElectricity $oneHourElectricity)
    {
        event(new OneHourElectricityCreated($oneHourElectricity));
    }
}
