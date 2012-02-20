<?php

namespace Ptbf\Mink;

/**
 * Description of Mink
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Mink extends \Behat\Mink\Mink{

	public function __destruct() {
		// do not stop browsers
//		parent::__destruct();
	}
}