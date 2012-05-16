<?php

namespace Ptbf\Mink\Element;

/**
 * Description of TraversableElement
 *
 * @author potaka
 */
abstract class TraversableElement extends \Behat\Mink\Element\TraversableElement {

	public function findById($id) {
		try {
			parent::findById($id);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::findById($id);
		}
	}

	/**
	 * Clicks link with specified locator.
	 *
	 * @param   string  $locator    link id, title, text or image alt
	 *
	 * @throws  Behat\Mink\Exception\ElementNotFoundException
	 */
	public function clickLink($locator) {
		try {
			parent::clickLink($locator);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::clickLink($locator);
		}
	}

	/**
	 * Presses button (input[type=submit|image|button], button) with specified locator.
	 *
	 * @param   string  $locator    button id, value or alt
	 *
	 * @throws  Behat\Mink\Exception\ElementNotFoundException
	 */
	public function pressButton($locator) {
		try {
			parent::pressButton($locator);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::pressButton($locator);
		}
	}

	/**
	 * Fills in field (input, textarea, select) with specified locator.
	 *
	 * @param   string  $locator    input id, name or label
	 *
	 * @throws  Behat\Mink\Exception\ElementNotFoundException
	 */
	public function fillField($locator, $value) {
		try {
			parent::fillField($locator,$value);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::fillField($locator,$value);
		}
	}

	/**
	 * Checks checkbox with specified locator.
	 *
	 * @param   string  $locator    input id, name or label
	 *
	 * @throws  Behat\Mink\Exception\ElementNotFoundException
	 */
	public function checkField($locator) {
		try {
			parent::checkField($locator);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::checkField($locator);
		}
	}

	/**
	 * Unchecks checkbox with specified locator.
	 *
	 * @param   string  $locator    input id, name or label
	 *
	 * @throws  Behat\Mink\Exception\ElementNotFoundException
	 */
	public function uncheckField($locator) {
		try {
			parent::uncheckField($locator);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::selectFieldOption($locator);
		}
	}

	public function selectFieldOption($locator, $value, $multiple = false) {
		try {
			parent::selectFieldOption($locator);
		} catch (\Exception $e) {
			$this->getSession()->wait('1000');
			parent::selectFieldOption($locator);
		}
	}

}