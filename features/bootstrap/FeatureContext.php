<?php

require __DIR__ . '/_classLoader.php';

/**
 * Features context.
 */
class FeatureContext extends \Ptbfw\Context\FeatureContext {

	/**
	 * Initializes context.
	 * Every scenario gets it's own context object.
	 *
	 * @param   array   $parameters     context parameters (set them up through behat.yml)
	 */
	public function __construct($options) {
		parent::__construct($options);
	}

}
