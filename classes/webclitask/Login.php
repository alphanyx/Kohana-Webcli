<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Webcli Handler
 * @author Mikel Fröse
 */
class Webclitask_Login extends Webclitask_Abstract {
	public function task_login($user, $passwd) {
		$logins = array();

		if (isset($this->settings['logins']) && is_array($this->settings['logins'])) {
			$logins = $this->settings['logins'];
		}

		$foundedLogin = false;
		foreach ($logins as $login => $password) {
			if (strcmp($user, $login) == 0 && strcmp($passwd, $password) == 0) {
				$foundedLogin = md5($user . ":" . $passwd);
			}
		}

		if ($foundedLogin !== false) {
			return $foundedLogin;
		} else {
			throw new Exception("Login failed");
		}
	}
}