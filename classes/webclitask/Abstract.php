<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Webclitask Abstract
 * @author Mikel Fröse
 */
abstract class Webclitask_Abstract {

	protected $settings = array();

	public function __construct($settings) {
		$this->settings = $settings;
	}
}