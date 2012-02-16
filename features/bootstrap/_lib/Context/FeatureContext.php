<?php
namespace ptbf;

/**
 * Description of FeatureContext
 * Here we will override some mink methods
 * basicly all CSS selectors wich return 1 element, should have founded exaclity 1 element
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */

require __DIR__.'/../_classLoader.php';

class FeatureContext extends \Behat\Mink\Behat\Context\MinkContext {
	
}