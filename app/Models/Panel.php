<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $fillable = ['serial', 'longitude', 'latitude'];

    public static $fieldValidations = [
        'serial'    => 'required|unique:panels|size:16',
        'latitude'  => 'required|regex:/^\d*.\d{6}$/|between:-90,90',
        'longitude' => 'required|regex:/^\d*.\d{6}$/|between:-180,180'
    ];

    public function oneHourElectricities()
    {
        return $this->hasMany('App\Models\OneHourElectricity');
    }
}
