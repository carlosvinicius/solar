<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OneDayElectricity extends Model
{
    protected $fillable = ['panel_id', 'day', 'sum', 'min', 'max', 'average'];

    protected $dates    = ['day'];
}
