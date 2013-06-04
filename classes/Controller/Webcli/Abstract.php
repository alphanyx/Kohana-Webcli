<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Webcli Abstract Controller
 * @author Mikel Fröse
 */
abstract class Controller_Webcli_Abstract extends Controller{

	protected $view;
	protected $isAjax;
	protected $settings;

	/**
	 * Method on start, sets the template and loads the settings
	 */
	public function before() {
		parent::before();

		$this->settings = Kohana::$config->load('webcli')->as_array();

		// set the current url
		$this->settings['terminalUrl'] = $this->request->url();
		$this->isAjax = $this->request->is_ajax();

		if (!$this->isAjax) {
			$template = 'webcli/index';
			if (isset($this->settings['template']) && !empty($this->settings['template'])) {
				$template = $this->settings['template'];
			}

			$userIp = Request::$client_ip;
			$loginRequired = true;

			if (isset($this->settings['allowedIPs']) && is_array($this->settings['allowedIPs']) && in_array($userIp, $this->settings['allowedIPs'])) {
				$loginRequired = false;
			}

			$data = array(
				'settings' => $this->settings,
				'loginRequired' => $loginRequired,
			);

			$this->view = View::factory($template, $data);
		}
	}

	/**
	 * Method on end, renders the template
	 */
	public function after() {
		parent::after();

		if (!$this->isAjax) {
			$this->response->body($this->view->render());
		}
	}
}