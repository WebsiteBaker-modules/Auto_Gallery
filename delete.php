<?php
/**
 * Page module:Auto Gallery
 * 
 * MODULE LICENSE: GNU General Public License 3.0
 * 
 * @author		Karl Pierce
 * @copyright	(c) 2010
 * @license		http://www.gnu.org/licenses/gpl.html
 * * @version		0.5
 * @platform	Website Baker 2.8
 *
 * ------------------------------------------------------------------------------------------------
 *	MODULE VERSION HISTORY
 * ------------------------------------------------------------------------------------------------
 *	v0.5 beta (Karl Pierce :June 1, 2012)

 * ------------------------------------------------------------------------------------------------
*/



// Delete record from the database
$database->query("DROP TABLE IF EXISTS mod_auto_gallery".$section_id);
$database->query("DELETE FROM ".TABLE_PREFIX."mod_auto_gallery WHERE page_id = '$page_id' AND section_id='$section_id'");

?>