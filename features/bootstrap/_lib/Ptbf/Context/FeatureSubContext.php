<?php

namespace Ptbf\Context;

/**
 * All sub-contexts should extend this class
 *
 * @author Angel Koilov <ange.koilov@gmail.com>
 */
class FeatureSubContext extends \Behat\Behat\Context\BehatContext {

	private $featureContext;

	/**
	 * @return FeatureSubContext
	 */
	public function __construct(FeatureContext $featureContext) {
		$this->featureContext = $featureContext;
	}

	public function __call($name, $arguments) {
		return call_user_func_array(array($this->featureContext, $name), $arguments);
	}

	public static function __callStatic($name, $arguments) {
		return call_user_func('FeatureSubContext::' . $name, $arguments);
	}

}