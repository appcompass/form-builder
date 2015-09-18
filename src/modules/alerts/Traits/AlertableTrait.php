<?php

namespace P3in\Traits;

use P3in\Models\Alert;

trait AlertableTrait
{

	/**
	*	Set an alert
	*
	*
	*
	*/
  public function setAlert($title, $message)
	{

		return Alert::create([
			'title' => $title,
			'model' => get_class($this),
			'message' => $message,
			'props' => json_encode(getProps($this->alert_props, $this))
		]);

	}

	/**
	*	Get alerts for this model
	*
	*	@param int $limit Limits the number of returned results
	*	@param int $id Returns result collection item id using Collection::find()
	*
	*	@return Collection || Model Single Item
	*/
	public function alerts($limit = null, $id = null)
	{

		$res = Alert::byModel(get_class($this))
			->withProps(getPgWhereProps($this->alert_props, $this));

		if (!is_null($limit)) {
			$res->take($limit);
		}

		if (!is_null($id)) {
			return $res->findOrFail($id);
		}

		return $res->get();

	}

}