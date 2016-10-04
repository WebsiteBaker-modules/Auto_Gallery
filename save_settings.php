<?php
 /* Page module:Auto Gallery
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



require('../../config.php');

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

// Get entered values
$allow_all = $admin->get_post_escaped('allow_all');
//for imgbroser
$images_path = $admin->get_post_escaped('images_path');
$cache_path = $admin->get_post_escaped('cache_path');
$cache = $admin->get_post_escaped('cache');
$page_id = $admin->get_post_escaped('page_id');
$section_id = $admin->get_post_escaped('section_id');
$dir_sort_by = $admin->get_post_escaped('dir_sort_by');
$dir_sort_order = $admin->get_post_escaped('dir_sort_order');
$img_sort_by = $admin->get_post_escaped('img_sort_by');
$img_sort_order = $admin->get_post_escaped('img_sort_order');
$thumbs_per_page = $admin->get_post_escaped('thumbs_per_page');
$max_thumb_row = $admin->get_post_escaped('max_thumb_row');
$max_thumb_width = $admin->get_post_escaped('max_thumb_width');
$max_thumb_height = $admin->get_post_escaped('max_thumb_height');
$time_format = $admin->get_post_escaped('time_format');
$ignore_port = $admin->get_post_escaped('ignore_port');
$dir_thumbs = $admin->get_post_escaped('dir_thumbs');
$random_thumbs = $admin->get_post_escaped('random_thumbs');
$read_thumb_limit = $admin->get_post_escaped('read_thumb_limit');

//for prettyPhoto
$animation_speed = $admin->get_post_escaped('animation_speed');
$slideshow = $admin->get_post_escaped('slideshow');
$autoplay_slideshow = $admin->get_post_escaped('autoplay_slideshow');
$opacity = $admin->get_post_escaped('opacity');
$show_title = $admin->get_post_escaped('show_title');
$allow_resize = $admin->get_post_escaped('allow_resize');
$default_width = $admin->get_post_escaped('default_width');
$default_height = $admin->get_post_escaped('default_height');
$counter_separator_label = $admin->get_post_escaped('counter_separator_label');
$theme = $admin->get_post_escaped('theme');
$modal = $admin->get_post_escaped('modal');
$overlay_gallery = $admin->get_post_escaped('overlay_gallery');
$keyboard_shortcuts = $admin->get_post_escaped('keyboard_shortcuts');
$crop_mode = $admin->get_post_escaped('crop_mode');
$crop_resize_factor = $admin->get_post_escaped('crop_resize_factor');

//for plupload
$pl_max_file_size = $admin->get_post_escaped('pl_max_file_size');
$pl_chunk_size = $admin->get_post_escaped('pl_chunk_size');
$pl_unique_names = $admin->get_post_escaped('pl_unique_names');
$pl_resize = $admin->get_post_escaped('pl_resize');
$pl_height = $admin->get_post_escaped('pl_height');
$pl_width = $admin->get_post_escaped('pl_width');
$pl_quality = $admin->get_post_escaped('pl_quality');
$pl_file_filter = $admin->get_post_escaped('pl_file_filter');





// Create a javascript back link
$js_back = "javascript: history.go(-1);";

// Update the database
$database = new database();
$query = "UPDATE ".TABLE_PREFIX."mod_auto_gallery SET
	allow_all='$allow_all',
	images_path='$images_path',
	cache_path='$cache_path',
	cache='$cache',
	dir_sort_by = '$dir_sort_by',
	dir_sort_by = '$dir_sort_by',
	dir_sort_order = '$dir_sort_order',
	img_sort_by = '$img_sort_by',
	img_sort_order = '$img_sort_order',
	thumbs_per_page = '$thumbs_per_page',
	max_thumb_row = '$max_thumb_row',
	max_thumb_width = '$max_thumb_width',
	max_thumb_height = '$max_thumb_height',
	time_format = '$time_format',
	ignore_port = '$ignore_port',
	dir_thumbs = '$dir_thumbs',
	random_thumbs = '$random_thumbs',
	read_thumb_limit = '$read_thumb_limit',
	animation_speed = '$animation_speed',
	slideshow = '$slideshow',
	autoplay_slideshow = '$autoplay_slideshow',
	opacity = '$opacity',
	show_title = '$show_title',
	allow_resize = '$allow_resize',
	default_width = '$default_width',
	default_height = '$default_height',
	counter_separator_label = '$counter_separator_label',
	theme = '$theme', modal = '$modal',
	overlay_gallery = '$overlay_gallery',
	keyboard_shortcuts = '$keyboard_shortcuts',
	crop_mode = '$crop_mode',
	pl_max_file_size = '$pl_max_file_size',
	pl_chunk_size = '$pl_chunk_size',
	pl_unique_names = '$pl_unique_names',
	pl_resize = '$pl_resize',
	pl_height = '$pl_height',
	pl_width = '$pl_width',
	pl_quality = '$pl_quality',
	pl_file_filter = '$pl_file_filter'
	WHERE section_id = '$section_id'";
$database->query($query);
// Check if there is a db error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();
?>