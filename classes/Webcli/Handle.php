<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Webcli Handler
 * @author Mikel Fröse
 */
class Webcli_Handle {
	private $settings = array();
	private static $methods;

	public function __construct($settings) {
		$this->settings = $settings;
	}

	protected function getMethods() {
		if (!self::$methods) {

			self::$methods = array();
			$classes = Kohana::list_files('classes/webclitask');


			foreach ($classes as $file => $absolutePath) {
				$file = substr($file, 0, -strlen(EXT));
				$className = trim(str_replace('classes','',$file), DIRECTORY_SEPARATOR);

				$className = str_replace(' ', '_', ucwords(str_replace(DIRECTORY_SEPARATOR,' ', $className)));

				if (class_exists($className)) {

					$methods = get_class_methods($className);

					foreach ($methods as $method) {
						if (substr($method, 0, 5) == 'task_') {
							$method = substr($method, 5);
							self::$methods[$method] = $className;
						}
					}
				}
			}
		}

		return self::$methods;
	}

	public function getTaskMethods() {
		$methods = $this->getMethods();

		return array_keys($methods);
	}

	public function getTaskDocumentation($task) {
		$methods = $this->getMethods();

		if (isset($methods[$task])) {
			$className = $methods[$task];

			if (method_exists($className, 'getDocumentation')) {
				return $this->callClassMethod($className, 'getDocumentation');
			} else {
				$classVars = get_class_vars($className);

				if (isset($classVars[$task . '_documentation'])) {
					return $classVars[$task . '_documentation'];
				}
			}
		}

		return false;
	}


	public function __call($task, $args) {
		$methods = $this->getMethods();

		if (isset($methods[$task])) {
			$className = $methods[$task];

			return $this->callClassMethod($className, 'task_' . $task, array($this->settings), $args);
		} else {
			throw new Exception('There is no ' . $task . ' method');
		}
	}

	protected function callClassMethod($className, $method, $instanceArgs = array(), $args = array()) {
		$reflection = new ReflectionClass($className);

		$method = $reflection->getMethod($method);
		$class = $reflection->newInstanceArgs($instanceArgs);

		return $method->invokeArgs($class, $args);
	}
}
