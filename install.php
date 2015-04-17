<?php

/*
 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2006, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: ../../index.php'));

global $admin; 

$database->query("CREATE TABLE `".TABLE_PREFIX."mod_auto_gallery` (
  `images_path` VARCHAR( 200 ) NOT NULL DEFAULT 'media',
  `cache_path` VARCHAR( 200 ) NOT NULL DEFAULT 'media/cache',															   
  `cache` VARCHAR( 5 ) NOT NULL DEFAULT 'false',
  `dir_sort_by` tinyint(1) NOT NULL DEFAULT '1',
  `dir_sort_order` varchar(15) NOT NULL DEFAULT 'SORT_DESC',
  `section_id` int(5) NOT NULL,
  `page_id` int(5) NOT NULL,
  `img_sort_by` tinyint(1) NOT NULL DEFAULT '1',
  `img_sort_order` varchar(15) NOT NULL DEFAULT 'SORT_DESC',
  `thumbs_per_page` int(3) NOT NULL DEFAULT '9' ,
  `max_thumb_row` int(4) NOT NULL DEFAULT '3',
  `max_thumb_width` int(4) NOT NULL DEFAULT '200',
  `max_thumb_height` int(4) NOT NULL DEFAULT '200',
  `time_format` varchar(200) NOT NULL DEFAULT 'F jS, Y',
  `time_zone` varchar(200) NOT NULL DEFAULT 'Europe/Amsterdam',
  `ignore_port` varchar(5) NOT NULL DEFAULT 'false',
  `dir_thumbs` varchar(5) NOT NULL DEFAULT 'true',
  `random_thumbs` varchar(5) NOT NULL DEFAULT 'true',
  `read_thumb_limit` varchar(5) NOT NULL DEFAULT '0',
    `animation_speed` varchar(10) NOT NULL DEFAULT 'fast',
    `slideshow` varchar(5) NOT NULL DEFAULT '4000',
	`autoplay_slideshow` varchar(5) NOT NULL DEFAULT 'true',
	`opacity` VARCHAR( 4 ) NOT NULL DEFAULT '0.8',
	`show_title` varchar(5) NOT NULL DEFAULT 'true',
	`allow_resize` varchar(5) NOT NULL DEFAULT 'true',
	`default_width` int(5) NOT NULL DEFAULT '500',
	`default_height` int(5) NOT NULL DEFAULT '344',
	`counter_separator_label` varchar(10) NOT NULL DEFAULT '/',
	`theme` varchar(20) NOT NULL DEFAULT 'dark_rounded',
	`overlay_gallery` varchar(5) NOT NULL DEFAULT 'true',
	`modal` varchar(5) NOT NULL DEFAULT 'false',
	`keyboard_shortcuts` varchar(5) NOT NULL DEFAULT 'true',
	`crop_mode` varchar(5) NOT NULL DEFAULT 'true',
	`crop_resize_factor` varchar(5) NOT NULL DEFAULT '2.5',
	`allow_all` VARCHAR( 5 ) NOT NULL DEFAULT 'false',
	`pl_max_file_size` VARCHAR( 20 ) NOT NULL DEFAULT '1000mb',
	`pl_chunk_size` VARCHAR( 20 ) NOT NULL DEFAULT '1mb',
	`pl_unique_names` VARCHAR( 5 ) NOT NULL DEFAULT 'true',
	`pl_height` INT( 10 ) NOT NULL DEFAULT '500',
	`pl_width` INT( 10 ) NOT NULL DEFAULT '341',
	`pl_quality` INT( 3 ) NOT NULL DEFAULT '80',
	`pl_file_filter` VARCHAR( 40 ) NOT NULL DEFAULT 'jpg,gif,png',
	`pl_resize` VARCHAR( 5 ) NOT NULL DEFAULT 'true'
			
)"
		 ); 

?>