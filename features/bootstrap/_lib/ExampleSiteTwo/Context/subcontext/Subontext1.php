<?php

namespace siteTwo\subcontext;

use Behat\Behat\Context\Step\Then,
	Behat\Behat\Exception\UndefinedException;

class Subontext1 extends \Behat\Behat\Context\BehatContext {

	/**
	 * @Given /^some non-existing step test$/ 
	 */
	public function testSiteTwo() {
		
	}

}