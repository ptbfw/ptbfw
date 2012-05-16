<?php

namespace Ptbf\Mink\Element;

/**
 * Description of DocumentElement
 *
 * @author potaka
 */
class DocumentElement extends TraversableElement {

	/**
	 * @see     Behat\Mink\Element\ElementInterface::getXpath()
	 */
	public function getXpath() {
		return '//html';
	}

	/**
	 * Returns document content.
	 *
	 * @return  string
	 */
	public function getContent() {
		return trim($this->getSession()->getDriver()->getContent());
	}

	/**
	 * Check whether document has specified content.
	 *
	 * @param   string  $content
	 *
	 * @return  Boolean
	 */
	public function hasContent($content) {
		return $this->has('named', array(
					'content', $this->getSession()->getSelectorsHandler()->xpathLiteral($content)
				));
	}

}
