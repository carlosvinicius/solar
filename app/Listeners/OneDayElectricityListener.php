<?php

namespace App\Listeners;

use App\Events\OneHourElectricityCreated;
use App\Models\OneDayElectricity;
use App\Models\OneHourElectricity;

class OneDayElectricityListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OneHourElectricityCreated  $event
     * @return void
     */
    public function handle(OneHourElectricityCreated $event)
    {
        $day     = $event->oneHourElectricity->hour->format('Y-m-d');
        $panelId = $event->oneHourElectricity->panel_id;

        $oneHourElectricities = OneHourElectricity
            ::where('panel_id', $panelId)
            ->where('hour', '>=', "{$day} 00:00:00")
            ->where('hour', '<=', "{$day} 23:59:59");

        $oneDayElectricity = [
            'panel_id' => $panelId,
            'day'      => $day,
            'sum'      => $oneHourElectricities->sum('kilowatts'),
            'max'      => $oneHourElectricities->max('kilowatts'),
            'min'      => $oneHourElectricities->min('kilowatts'),
            'average'  => $oneHourElectricities->average('kilowatts')
        ];

        OneDayElectricity::updateOrCreate(['panel_id' => $panelId, 'day' => $day], $oneDayElectricity);
    }
}
