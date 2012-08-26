<?php

namespace Ptbf\Context;

use Behat\Behat\Event\SuiteEvent,
	Behat\Behat\Event\FeatureEvent

;

/**
 * Description of FeatureContext
 * Here we will override some mink methods
 * basicly all CSS selectors wich return 1 element, should have founded exaclity 1 element
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements \Ptbfw\Initializer\InitializerAwareInterface {

	protected static $mink;
	protected static $options = array();

	function __construct($options) {
		self::$options = $options;

		// load all context files
		if (isset($options['context_dir'])) {
			foreach ($options['context_dir'] as $nameSpace => $directory) {
				if (!preg_match('/^\\\\/', $nameSpace)) {
					$nameSpace = '\\' . $nameSpace;
				}

				if (!preg_match('/\\\\$/', $nameSpace)) {
					$nameSpace = $nameSpace . '\\';
				}

				$finder = new \Symfony\Component\Finder\Finder();
				$contextDir = __DIR__ . '/../../../' . $directory;
				$contextDir = realpath($contextDir);
				foreach ($finder->files()->name('*.php')->sortByName()->in($contextDir) as $file) {
					/* @var $file \Symfony\Component\Finder\SplFileInfo */
					$contextName = preg_replace('/\.php$/', '', $file->getFilename());
					$relativePath = preg_replace('/^' . preg_quote($contextDir, '/') . '/', '', $file->getRealPath());
					$relativePath = preg_replace('#/#', '\\', $relativePath);
					$relativePath = ltrim($relativePath, '\\');
					$contextName = preg_replace('/\.php$/', '', $relativePath);
					$contextFullClassName = $nameSpace . $contextName;
					$this->useContext($contextFullClassName, new $contextFullClassName($this));
				}
			}
		}
	}

	public function getMink() {
		return self::getMinkStatic();
	}

	public static function getMinkStatic() {
		$mink = self::$mink;
		if ($mink === NULL) {
			$mink = new \Ptbf\Mink\Mink();
			self::$mink = $mink;
		}
		return $mink;
	}

	/**
	 * @BeforeSuite
	 */
	public static function prepareSuite(SuiteEvent $event) {
		self::$options = $event->getContextParameters();
		$options = self::$options;
	}

	/**
	 * override default mink hook
	 * we moved this to before scenario step
	 * because you can stop/change some sessions during scenario
	 */
	public function prepareMinkSessions($event) {
		
	}

	/**
	 * 
	 * Restore mink sessions from config
	 * 
	 * @BeforeScenario 
	 * @param \Behat\Behat\Event\ScenarioEvent $event
	 */
	public function before($event) {
		$this->sessionRestart();
	}

	/**
	 * restart sessoins
	 */
	private function sessionRestart() {

		$options = self::$options;
		$mink = $this->getMink();
		$mink->resetSessions();

		/**
		 * Mink session if session name contains
		 * 
		 * mink
		 * IE, internet, explorer
		 * safari
		 * chrom(e|ium)
		 * opera
		 * firefox
		 */
		if (preg_match('/(?:(mink|ie|firefox|chrom||safari|internet|explorer|opera))/i', $options['default_session'])) {
			$client = null;

			if (false == $mink->hasSession($options['default_session'])) {
				if (isset($sessionsOptions[$options['default_session']])) {
					$currentSessionOptions = $sessionsOptions[$options['default_session']];
					if (isset($currentSessionOptions['port'])) {
						$port = $currentSessionOptions['port'];
					} else {
						$port = 4444;
					}

					$client = new \Selenium\Client($currentSessionOptions['host'], $port);
					$driver = new \Behat\Mink\Driver\Selenium2Driver($options['default_session']);
				} else {
					$client = null;
				}

				$driver = new \Ptbfw\Selenium2Driver\Selenium2Driver();
				//$session = new \Behat\Mink\Session($driver);
				$session = new \Ptbf\Mink\Session($driver);
				$session->start();
				$session->visit($options['base_url']);
				$mink->registerSession($options['default_session'], $session);
			}
		} else {
			throw new Exception('goutte session not implemented');
			// @TODO
			$driver = new \Behat\Mink\Driver\GoutteDriver();
		}
		$mink->setDefaultSessionName($options['default_session']);
	}



	/**
	 * used by Mink
	 * 
	 * @param type $name
	 * @return type 
	 */
	public function getParameter($name) {
		return self::$options[$name];
	}

	/**
	 *
	 * @return Behat\Mink\Element\DocumentElement
	 */
	public function getPage() {
		return $this->getSession()->getPage();
	}

	/**
	 * used by Mink
	 */
	public function getParameters() {
		return self::$options;
	}

	/*
	 * overriden for ajax-save
	 */

	public function assertPageContainsText($text) {
		try {
			parent::assertPageContainsText($text);
		} catch (\Exception $e) {
			$this->getSession()->wait(3000);
			parent::assertPageContainsText($text);
		}
	}

}