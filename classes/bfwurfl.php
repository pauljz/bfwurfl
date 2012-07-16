<?php
require_once(dirname(__FILE__)."/"."../../customExtension.php");

class bfwurfl extends customExtension {

	private $wurflManager = null;
	private $requestingDevice = null;
	private $isBroken = false;

	private function getWurflManager() {

		eZDebug::addTimingPoint( "Querying WURFL" );
		eZDebug::accumulatorStart( 'Querying WURFL', 'BFWURFL' );

		$wurflini = eZINI::instance("bfwurfl.ini");

		try {
			$wurflDir = dirname(__FILE__) . '/wurfl/WURFL';
			$wurflDatabase = dirname(__FILE__) . '/../data/wurfl.xml';
			$resourcesDir = dirname(__FILE__) . '/../../../var';
			$persistenceDir = $resourcesDir.'/wurfl/persistence';
			$cacheDir = $resourcesDir.'/wurfl/cache';

			require_once( $wurflDir.'/Application.php' );

			$wurflConfig = new WURFL_Configuration_InMemoryConfig();
			$wurflConfig->wurflFile($wurflDatabase);
			$wurflConfig->matchMode( $wurflini->variable("WURFL", "MatchMode") );
			$wurflConfig->persistence('file', array('dir' => $persistenceDir));

			if ( $wurflini->variable("WURFL", "CacheMode") == 'apc' ) {
				$wurflConfig->cache('apc', array('expiration' => 36000));
			} else {
				$wurflConfig->cache('file', array('dir' => $cacheDir, 'expiration' => 36000));
			}

			$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
			$this->wurflManager = $wurflManagerFactory->create();
		
			$this->requestingDevice = $this->wurflManager->getDeviceForHttpRequest($_SERVER);
		} catch ( Exception $e ) {
			$this->isBroken = true;
		}

		eZDebug::accumulatorStop( 'Querying WURFL', 'BFWURFL' );
		eZDebug::addTimingPoint( "Done Querying WURFL" );
	}

	function getCapabilities() {
		if ( $this->isBroken ) {
			return array();
		}
		if ( !$this->wurflManager ) {
			$this->getWurflManager();
		}

		$deviceData = array();

		try {

			$requestingDevice = $this->requestingDevice;

			$isWireless = $requestingDevice->getCapability('is_wireless_device') == 'true';
			$isTablet = $requestingDevice->getCapability('is_tablet') == 'true';
			$deviceData['is_mobile_device'] = $isWireless || $isTablet;

			$wurflini = eZINI::instance("bfwurfl.ini");
			$capabilities = $wurflini->variable("WURFL", "Capabilities");

			foreach( $capabilities as $capability ) {
				if ( $capability ) {
					$value = $requestingDevice->getCapability( $capability );
					if ( $value == 'true' ) {
						$value = true;
					} else if ( $value == 'false' ) {
						$value = false;
					}
					$deviceData[$capability] = $value;
				}
			}

		} catch ( Exception $e ) {
			$this->isBroken = true;
		}

		return $deviceData;
	}

	function bfwurfl_get() {
		$capabilities = $this->getCapabilities();
		return $capabilities;
	}

}

?>