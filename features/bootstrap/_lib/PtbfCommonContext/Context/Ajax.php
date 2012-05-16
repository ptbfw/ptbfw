<?php

namespace PtbfCommonContext\Context;

class Ajax extends \Ptbf\Context\FeatureSubContext {

	/**
	 * @Given /^I fill for suggestion in "([^"]*)" with "([^"]*)"$/                                                                                                                
	 */
	public function iFillForSuggestionInWith($element, $text) {
		$textForEvent = substr($text, -1);

		$element = $this->getPage()->findField($element);
		$element->setValue($text);
		$element->focus();
		$element->keyDown($textForEvent);
		$element->keyPress($textForEvent);
		$element->keyUp($textForEvent);
		
		//@TODO i need something smarter :)
		$this->getPage()->getSession()->wait(3000);
	}

}