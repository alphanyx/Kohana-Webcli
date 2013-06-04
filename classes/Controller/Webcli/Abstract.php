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

		$userIp = Request::$client_ip;
		$loginRequired = true;

		$loginType = isset($this->settings['loginType']) ? $this->settings['loginType'] : 'shell';

		if (isset($this->settings['allowedIPs']) && is_array($this->settings['allowedIPs']) && in_array($userIp, $this->settings['allowedIPs'])) {
			$loginRequired = false;
		}

		if ($loginRequired && $loginType == 'auth') {
			$this->authenticate();
		}

		if ($loginRequired && $loginType != 'shell') {
			$loginRequired = false;
		}



		// set the current url
		$this->settings['terminalUrl'] = $this->request->url();
		$this->isAjax = $this->request->is_ajax();

		if (!$this->isAjax) {
			$template = 'webcli/index';
			if (isset($this->settings['template']) && !empty($this->settings['template'])) {
				$template = $this->settings['template'];
			}

			$data = array(
				'settings' => $this->settings,
				'loginRequired' => $loginRequired,
			);

			$this->view = View::factory($template, $data);
		}
	}

	public function authenticate() {
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			$this->doAuthentication();
		} else {
			$passwd = $_SERVER['PHP_AUTH_PW'];
			$user = $_SERVER['PHP_AUTH_USER'];

			$handler = new Webcli_Handle($this->settings);

			$response = false;

			try {
				$response = $handler->login($user, $passwd);
			} catch (Exception $e) {
				$this->doAuthentication();
			}
		}
	}

	public function doAuthentication() {
		header('WWW-Authenticate: Basic realm="Webcli"');
		header('HTTP/1.0 401 Unauthorized');
		echo "No Webcli access without login!";
		exit;
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