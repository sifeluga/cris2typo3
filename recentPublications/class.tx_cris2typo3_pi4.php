<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2016 LME Webteam <admin-web@i5.cs.fau.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

if (!class_exists('tslib_pibase')) require_once(PATH_tslib . 'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('cris2typo3').'lib/class.publications.php');

/**
 * Plugin 'Cris2Typo3' for the 'cris2typo3' extension.
 *
 * @author	Felix Lugauer, Peter Fischer, Christoph Forman (LME Webteam <admin-web@i5.cs.fau.de>)
 * @package	TYPO3
 * @subpackage	tx_cris2typo3
 */
class tx_cris2typo3_pi4 extends tslib_pibase {
	var $prefixId      = 'tx_cris2typo3_pi4';		// Same as class name
	var $scriptRelPath = 'recentPublications/class.tx_cris2typo3_pi4.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'cris2typo3';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{

		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_initPIflexForm();
		$this->pi_loadLL();
		
		$pubLib = new pubLibCris;
		$pubLib->setParent($this);

		$numberOfRecentPubs = 10;

		$items    = $pubLib->getPublicationsLatest( $numberOfRecentPubs );		
		$template = $this->cObj->fileResource($this->conf['templateFile']);	
		
		for($i = 0; $i < $numberOfRecentPubs; $i++)
	 		$divs[] = "'publications-{$i}'";
		
		$content .= '<div class="crossfade-container" id="publications-box">'.$pubLib->renderPublicationList($items, $template).'</div>';
		$content .= '<script language="javascript">
			divs_to_fade[\'publications\'] = new Array('. join(', ', $divs) . ');
		</script>';
		
		return $this->pi_wrapInBaseClass($content);
	}

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cris2typo3/recentPublications/class.tx_cris2typo3_pi4.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cris2typo3/recentPublications/class.tx_cris2typo3_pi4.php']);
}

?>
