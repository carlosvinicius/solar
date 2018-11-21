<?php

namespace Tests\Feature;

use \DateTime;
use \DateInterval;
use Tests\TestCase;
use App\Models\OneHourElectricity;
use App\Models\OneDayElectricity;
use App\Models\Panel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OneDayElectricityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if yesterday electricity summary for a valid panel (business rule) is returned
     * considering that there was at least one input of electricity hour.
     * This call should return a success status code
     *
     * @return void
     */
    public function testIndexForPanelWithElectricity()
    {
        $panel = factory(Panel::class)->make();
        $panel->save();

        $yesterday = new \DateTime('yesterday');
        factory(OneDayElectricity::class)->make([ 'panel_id' => $panel->id, 'day' => $yesterday])->save();

        $response = $this->json('GET', '/api/one_day_electricities?panel_serial='.$panel->serial);

        $response->assertStatus(200);

        $this->assertCount(1, json_decode($response->getContent()));
    }

    /**
     * Test if yesterday electricity summary for a valid painel (business rule) is not returned.
     * This call should return a success status code
     *
     * @return void
     */
    public function testIndexForPanelWithoutElectricity()
    {
        $panel = factory(Panel::class)->make();
        $panel->save();

        $response = $this->json('GET', '/api/one_day_electricities?panel_serial='.$panel->serial);

        $response->assertStatus(200);

        $this->assertCount(0, json_decode($response->getContent()));
    }

    /**
     * Test if yesterday electricity summary for a invalid painel (business rule) is not returned.
     * This call should return a error status code
     *
     * @return void
     */
    public function testIndexWithoutExistingPanel()
    {
        $response = $this->json('GET', '/api/one_day_electricities?panel_serial=testserial');

        $response->assertStatus(404);
    }

    /**
     * Test if yesterday electricity summary is not returned considering no panel data is informed.
     * This call should return a error status code
     *
     * @return void
     */
    public function testIndexWithoutPanelSerial()
    {
        $response = $this->json('GET', '/api/one_day_electricities');

        $response->assertStatus(404);
    }

    /**
     *  Test if the occurrence of OneDayElectricity data are generated correctly
     *
     * @return void
     */
    public function testOneDayElectricityCreatedSuccessfully()
    {
        $panel = factory(Panel::class)->make();
        $panel->save();

        $oneHourElectricities = collect([]);

        $oneHourElectricity = factory(OneHourElectricity::class)->make(['panel_id' => $panel->id]);
        $oneHourElectricity->save();
        $oneHourElectricities->push($oneHourElectricity);

        $hour = $oneHourElectricity->hour;

        if ($hour->format('H') == 23) {
            $hour->sub(new DateInterval('PT1H'));
        } else {
            $hour->add(new DateInterval('PT1H'));
        }

        $oneHourElectricity  = factory(OneHourElectricity::class)->make(['panel_id' => $panel->id, 'hour' => $hour]);
        $oneHourElectricity->save();
        $oneHourElectricities->push($oneHourElectricity);

        $result = OneDayElectricity
            ::where('panel_id', $panel->id)
            ->where('day', $hour->format('Y-m-d'))
            ->select(['sum','min','max','average'])
            ->get();

        $this->assertEquals($result->first()->toArray(), [
            'sum'     => $oneHourElectricities->sum('kilowatts'),
            'min'     => $oneHourElectricities->min('kilowatts'),
            'max'     => $oneHourElectricities->max('kilowatts'),
            'average' => $oneHourElectricities->average('kilowatts'),
        ]);
    }
}
