<?php

namespace Ptbfw\Context;

/**
 * All sub-contexts should extend this class
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 * @method  Behat\Mink\Element\DocumentElement getPage() return session page
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