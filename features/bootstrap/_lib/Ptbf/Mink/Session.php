<?php

namespace Ptbf\Mink;

class Session extends \Behat\Mink\Session{
	public function getPage() {
		$page = new Element\DocumentElement($this);
		return $page;
	}
}