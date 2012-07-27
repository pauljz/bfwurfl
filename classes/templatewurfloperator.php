<?php
/*
 * bfwurfl is released under the GNU AFFERO GENERAL PUBLIC LICENSE version 3.
 * http://www.gnu.org/licenses/agpl-3.0.html
 *
 * WURFL is a registered trademark of ScientiaMobile, Inc.
 * eZ Publish is a registered trademark of eZ Systems AS
 *
 * Copyright 2012 Beaconfire <http://www.beaconfire.com/>
 */

class TemplateWURFLOperator
{
		function __construct() { }

		function operatorList() {
				return array(
					'bfwurfl_get',
					'wurfl'
				);
		}

		function namedParameterPerOperator() {
				return true;
		}

		function namedParameterList() {
			return array(
				'bfwurfl_get' => array(),
				'wurfl' => array()
			);
		}

		function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement ) {
				switch ( $operatorName ) {
						case 'bfwurfl_get':
						case 'wurfl':
							$bfwurfl = bfwurfl::factory();
							$operatorValue = $bfwurfl->getCapabilities();
							return $operatorValue;
						break;
				}
		}
}

?>
