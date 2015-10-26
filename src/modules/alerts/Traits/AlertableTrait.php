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
  public function setAlert($title, $message, array $props = [])
	{

		$alert = new Alert([
			'title' => $title,
			'message' => $message,
			'props' => json_encode($props),
			'hash' => bcrypt(time())
		]);

		return $this->alerts()->save($alert);

	}

	/**
	 *
	 *
	 */
	public function alerts()
	{

		return $this->morphMany(Alert::class, 'alertable');

	}

	/**
	*	Get alerts for this model
	*
	*	@param int $limit Limits the number of returned results
	*	@param int $id Returns result collection item id using Collection::find()
	*
	*	@return Collection || Model Single Item
	*/
	// public function alerts($limit = null, $id = null)
	// {

	// 	$res = Alert::byModel(get_class($this))
	// 		->withProps(getPgWhereProps($this->alert_props, $this));

	// 	if (!is_null($limit)) {
	// 		$res->take($limit);
	// 	}

	// 	if (!is_null($id)) {
	// 		return $res->findOrFail($id);
	// 	}

	// 	return $res->get();

	// }

}