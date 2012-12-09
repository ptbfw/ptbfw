<?php

class Context extends \Ptbfw\Context\FeatureSubContext {

	/**
	 * @Given /^test siteOne witch use main namespace$/ 
	 */
	public function testSiteOne() {
		
	}
	
	/**
	 * @Then /^I go to google$/ 
	 */
	public function goToGoogle(){
		$this->getSession();
	}

}