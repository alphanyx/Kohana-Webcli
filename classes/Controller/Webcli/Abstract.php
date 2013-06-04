<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Webcli Abstract Controller
 * @author Mikel Fröse
 */
abstract class Controller_Webcli_Abstract extends Controller{

	/**
	 * Method on start, sets the current user and project and checks the user rights and projects
	 */
	public function before() {
		parent::before();

		$this->view = SmartyView::factory();

		$this->template = strtolower(trim(implode('/', array($this->request->directory(), $this->request->domainTemplatepath(), $this->request->controller(), $this->request->action())), '/'));

		$this->layout = strtolower(trim(implode('/', array($this->request->directory(), $this->request->domainTemplatepath(), 'layout', 'application')), '/'));

		if (isset($this->current_project)) {
			$this->view->project = $this->current_project;
		}

		$this->view->projectSettings = $this->projectSettings;
		$this->view->title = $this->projectSettings->title;
		$this->view->meta = Helper_Config::getMetaConfiguration();

		$controller = strtolower($this->request->controller());
		$pagetitle = false;

		if (isset($this->projectSettings->titles[$controller])) {
			$pagetitle = $this->projectSettings->titles[$controller];
		}

		$this->view->pagetitle = $pagetitle;
		$this->view->xing_share = urlencode(URL::base() . Route::get('default')->uri(array('controller'=>'vision')));

		if ($referrer = $this->request->query('referrer')) {
			Session::instance()->set('referrer', $referrer);
		}
	}

	/**
	 * Method on end, renders the remplate if auto_render is true
	 */
	public function after() {
		parent::after();

		if($this->auto_render) {
			$this->response->body($this->render());
		}
	}

	/**
	 * Render method, renders the the template and renders the layout or content only if render_layout is false
	 * @return string rendered layout/content
	 */
	public function render() {
		$this->view->bodyid = strtolower(trim(implode('-', array($this->request->directory(), $this->request->controller(), $this->request->action())), '-'));
		$this->view->values = $this->getValues();
		$this->view->errors = $this->_errors;
		$this->view->this = $this;
		$content = $this->view->render($this->template);

		if(!$this->render_layout) return $content;

		$this->view->_content = $content;
		return $this->view->render($this->layout);
	}
}