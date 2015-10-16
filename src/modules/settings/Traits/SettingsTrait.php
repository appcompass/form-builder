<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Settings;

trait SettingsTrait
{

  private $settings = null;

  private $json = null;

  /**
   * Get/Store Settings
   *
   * @param string key
   * @param string value
   * @return json
   */
  public function settings($key = null, $value = null)
  {

    $this->initSettings();

    if (is_array($key)) {

      foreach($key as $name => $value) {

        $this->addSetting($name, $value);

      }

      return $this->json;

    }

    if (! is_null($key)) {

      if (! is_null($value)) {

        return $this->addSetting($key, $value);

      }

      return $this->byName($key);

    }


    // return $this->json;
    return $this->morphOne(Settings::class, 'settingable');
  }

  /**
   *  Return setting by name
   */
  private function byName($name)
  {

    if (isset($this->json->$name)) {

      return $this->json->$name;

    }

    return false;

  }

  /**
   * Set setting
   */
  private function addSetting($key, $value)
  {

    $this->json->$key = $value;

    $this->settings->data = json_encode($this->json);

    $this->storeSetting();

    return $this->json;

  }

  /**
   * Store relation
   *
   *
   *
   */
  private function storeSetting()
  {

    $rel = $this->morphOne(Settings::class, 'settingable');

    $this->settings->save();

    return $rel->save($this->settings);

  }

  /**
   * Make sure we have a settings instance
   *
   *
   *
   */
  private function initSettings()
  {

    if (is_null($this->settings)) {

      $rel = $this->morphOne(Settings::class, 'settingable');

      try {

        $this->settings = $rel->firstOrFail();

        $this->json = $this->settings->data;

      } catch (ModelNotFoundException $e) {

        $this->settings = new Settings([
          "data" => "{}"
        ]);

        $this->json = json_decode($this->settings->data);

        return $rel->save($this->settings);

      }
    }
  }

}