<?php defined('SYSPATH') or die('No direct script access.');


include_once(MODPATH . 'webcli/vendor/json_rpc.php');


/**
 * Webcli Controller
 * @author Mikel Fröse
 */
class Controller_Webcli_Index extends Controller_Webcli_Abstract {

	public function action_run() {
		$handler = new Webcli_Handle($this->settings);

		if ($this->isAjax) {
			handle_json_rpc($handler);
		}
	}
}