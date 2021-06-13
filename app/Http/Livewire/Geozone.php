<?php

namespace App\Http\Livewire;

use App\Models\Geozone as ModelsGeozone;
use App\Models\Postalcode;
use Livewire\Component;

class Geozone extends Component
{
    public $zone;
    public $selectedCodes = [];
    public $zoneId;
    public $getCodes = null;
    public $chooseCodes = [];

    public function storeGeozone()
    {
        $this->validate([
            'zone' => 'required'
        ]);

        ModelsGeozone::create([
            'name' => $this->zone
        ]);
        $this->zone = '';

        session()->flash('message', 'Route added successfully.');
    }

    public function chooseZone()
    {
        if ($this->zoneId == '') {
            return;
        }
        $this->chooseCodes = [];
        $getCodes = ModelsGeozone::with('postalcodes')->find($this->zoneId);
        if ($getCodes != null && $getCodes->postalcodes->count()) {
            foreach ($getCodes->postalcodes as $code) {
                array_push($this->chooseCodes, $code->id);
            }
        }
    }

    public function connectPostalCodesWithGeozone()
    {
        $this->validate([
            'chooseCodes' => 'required'
        ], [
            'chooseCodes' => 'Choose the postal codes for the route.'
        ]);

        $getGeozone = ModelsGeozone::find($this->zoneId);
        if ($getGeozone) {
            $getGeozone->postalcodes()->sync($this->chooseCodes);
        }
        session()->flash('message', 'Postal codes linked with route.');
    }

    public function render()
    {
        $geoZones = ModelsGeozone::all();
        $allPostalCodes = Postalcode::all();
        return view('livewire.geozone', compact('geoZones', 'allPostalCodes'));
    }
}
