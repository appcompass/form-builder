<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Setting;

trait SettingsTrait
// {
//     private $settings = null;

//     private $json = null;

//     public function settingsRel()
//     {
//         return $this->morphOne(Setting::class, 'settingable');
//     }

//     public function getSettingsAttribute()
//     {
//         return !empty($this->settingsRel) ? $this->settingsRel->data : [];
//     }

//     public function setSettingsAttribute($value)
//     {
//         $this->storeSettings($value);
//     }

//     private function storeSettings($value = null)
//     {
//         if ($this->settingsRel()->count()) {
//             $this->settingsRel->data = $value;
//             $this->settingsRel->save();
//         } else {
//             $this->settingsRel()->create([
//                 'data' => $value,
//             ]);
//         }
//     }
}
