<?php
require_once(dirname(__FILE__)."/"."../../customExtension.php");
$dirParts = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
$className = $dirParts[sizeof($dirParts)-2];
$operators = array_keys(customExtension::getExtensionDetails($className));
$functions = 
$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 
	'class' => $className,
	'script' => "extension/$className/classes/$className.php",
 	'operator_names' => $operators,
);
// For example defintion, see :
// http://pubsvn.ez.no/doxygen/4.0/html/lib_2eztemplate_2classes_2eztemplateautoload_8php-source.html 
// TODO: add this capability to the customExtension.php, reading it from XML
//$eZTemplateFunctionArray = array();
?>