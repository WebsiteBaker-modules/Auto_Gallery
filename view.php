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

// prevent this file from being accessed directly
if (!defined('WB_PATH')) die(header('Location: ../../index.php'));

// load module language file
$lang = (dirname(__FILE__)) . '/languages/' . LANGUAGE . '.php';
require_once(!file_exists($lang) ? (dirname(__FILE__)) . '/languages/EN.php' : $lang );
require_once(WB_PATH."/framework/class.wb.php");

//connect to database  
  $conn = $database->connect();
	if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}

// Get settings
$query_settings = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_auto_gallery WHERE section_id = '$section_id'");
if($query_settings->numRows() > 0) {
	$settings = $query_settings->fetchRow();
	
} else {
	echo 'MySQL Error: ' . mysql_error();
	exit;
}//end if

//error_reporting(E_ALL);

 //get editable permission(borrowed from frontendedit2.7 )
 $editable= FALSE;
 	if (is_numeric($wb->get_session('USER_ID'))) {
			//Get permissons
			
			if ($page_id) 
				$this_page = $page_id;
			else
				$this_page = $wb->default_page_id;
			
			$results = $database->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '$this_page'");
			$results_array = $results->fetchRow();
			$old_admin_groups = explode(',', $results_array['admin_groups']);
			$old_admin_users = explode(',', $results_array['admin_users']);
			$this_user = $wb->get_session('GROUP_ID');
	
			$query = "SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '".$page_id."'";
			$get_pages = $database->query($query);
			
			$page = $get_pages->fetchRow();
			$admin_groups = explode(',', str_replace('_', '', $page['admin_groups']));
			$admin_users = explode(',', str_replace('_', '', $page['admin_users']));
			$in_group = FALSE;
			
			foreach($admin->get_groups_id() as $cur_gid)
				if (in_array($cur_gid, $admin_groups)) $in_group = TRUE;
			
			if (($in_group) OR is_numeric(array_search($this_user, $old_admin_groups)) ) {
				$editable= TRUE;
			}      
		}
  
 //plupload the upload tool set session var for security
	
	$ident = mt_rand();
$_SESSION['Auto_Gallery_ident'] = $ident;
 ?>
<link media="screen" type="text/css" rel="stylesheet" href="<?php echo WB_URL;?>/modules/Auto_Gallery/include/prettyPhoto/css/prettyPhoto.css"  />
<script type="text/javascript" src="<?php echo WB_URL;?>/include/jquery/jquery-min.js" ></script>
<script type="text/javascript" src="<?php echo WB_URL;?>/modules/Auto_Gallery/include/prettyPhoto/js/jquery.prettyPhoto.js"></script>
<?php
//allow only the right users
if($settings['allow_all'] == 'true' or $editable== TRUE){ ?>
<!-- Load Queue widget CSS and jQuery only needed for right users -->
<link media="screen" type="text/css" rel="stylesheet" href="<?php echo WB_URL;?>/modules/Auto_Gallery/include/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" />
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="<?php echo WB_URL;?>/modules/Auto_Gallery/include/plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo WB_URL;?>/modules/Auto_Gallery/include/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<button type="button"  id="tools_button" class="fg-button ui-corner-tl ui-corner-tr ui-corner-br ui-corner-bl ui-state-default"><span class="ui-button-icon-primary ui-icon ui-icon-circle-arrow-s"></span><?php echo $DNDTEXT['ADD_FILES'];?></button>
<div id='add_files' class="ui-helper-clearfix" >
  <div>
    <form  method="post" action="<?php echo WB_URL;?>/modules/Auto_Gallery/upload.php">
      <div id="uploader">
        <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
      </div>
    </form>
  </div>
</div>
<?php } //end if editable

// Pretty Photo ?>
<script type="text/javascript">
	
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto({
			animation_speed: '<?php echo $settings['animation_speed'];?>', /* fast/slow/normal */
			slideshow: <?php echo $settings['slideshow'];?>, /* false OR interval time in ms */
			autoplay_slideshow: <?php echo $settings['autoplay_slideshow'];?>, /* true/false */
			opacity: '<?php echo $settings['opacity'];?>', /* Value between 0 and 1 */
			show_title: <?php echo $settings['show_title'];?>, /* true/false */
			allow_resize: <?php echo $settings['allow_resize'];?>, /* Resize the photos bigger than viewport. true/false */
			default_width: '<?php echo $settings['default_width'];?>',
			default_height: '<?php echo $settings['default_height'];?>',
			counter_separator_label: '<?php echo $settings['counter_separator_label'];?>', /* The separator for the gallery counter 1 "of" 2 */
			theme: '<?php echo $settings['theme'];?>', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			
			modal: <?php echo $settings['modal'];?>, /* If set to true, only the close button will close the window */
			overlay_gallery: <?php echo $settings['overlay_gallery'];?>, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
			keyboard_shortcuts: <?php echo $settings['keyboard_shortcuts'];?>, /* Set to false if you open forms inside prettyPhoto */
			changepicturecallback: function(){}, /* Called everytime an item is shown/changed */
			callback: function(){} /* Called when prettyPhoto is closed */
		
			});
		});
		
	</script>
<?php

// Some stuff for generating stats
function file_size($size)
{
	$units = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb');

	for ($i = 0; $size > 1024; $i++)
		$size /= 1024;

	return round($size, 2).' '.$units[$i];
}

function get_microtime($microtime=false)
{
	if ($microtime === false)
		$microtime = microtime();

	list($usec, $sec) = explode(' ', $microtime);
	return ((float)$usec + (float)$sec);
}

$start_timer = microtime();

//get current page link
$query_menu = $database->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '".PAGE_ID."'");

if($query_menu->numRows() > 0) {
	$page = $query_menu->fetchRow();
	
} else {
	echo 'MySQL Error: ' . mysql_error();
	exit;
}//end if

$current_url= $page['link'].PAGE_EXTENSION;
// Include class
require WB_PATH.'/modules/Auto_Gallery/include/imgbrowz0r-0.3.7/imgbrowz0r.php';

// These are all settings (set to default). The settings are not validated since you have to configure everything.
// There is a chance that ImgBrowz0r stops working if you enter the wrong values.
$config = array(
	// Directory settings. These are required. Without trailing slash. (required)
	'images_dir'               => WB_PATH."/".$settings['images_path'],
	'cache_dir'                => WB_PATH."/".$settings['cache_path'],

	// Url settings. These are required. Without trailing slash. (required)
	// %PATH% is replaced with the directory location and page number
	'main_url'                 => WB_URL."/pages".$current_url.'?q=%PATH%', 
	'images_url'               => WB_URL."/".$settings['images_path'],
	'cache_url'                => WB_URL."/".$settings['cache_path'],

	// Sorting settings (optional)
	'dir_sort_by'              => (int)$settings['dir_sort_by'], // 1 = filename, 2 = extension (dir), 3 = inode change time of file
	'img_sort_by'              => (int)$settings['img_sort_by'], // 1 = filename, 2 = extension (png, gif, etc.), 3 = inode change time of file or EXIF image data (Date Taken)

	

	// Thumbnail settings (optional)
	'thumbs_per_page'          => (int)$settings['thumbs_per_page'], // Amount of thumbnails per page
	'max_thumb_row'            => (int)$settings['max_thumb_row'], // Amount of thumbnails on a row
	'max_thumb_width'          => (int)$settings['max_thumb_width'], // Maximum width of thumbnail
	'max_thumb_height'         => (int)$settings['max_thumb_height'], // Maximum height of thumbnail

	

	// Resize the image before cropping by 2.5. If the image mustn't be resized
	// the value can be set to 1.
	'crop_resize_factor'       => (int)$settings['crop_resize_factor'],

	// Date formatting. Look at the PHP date() for help: http://php.net/manual/en/function.date.php
	'time_format'              => $settings['time_format'],

	// Pick a valid timezone from http://en.wikipedia.org/wiki/List_of_tz_database_time_zones
	// Use `false` to disable the timezone option
	'time_zone'                => $settings['time_zone'],


	// Misc settings (optional)
	'ignore_port'              => $settings['ignore_port'], // Ignore port in url. Set this to true to ignore the port.
	
	                                     // NOTE: random_thumbs will not work when the cache is enabled.
	'read_thumb_limit'         => $settings['read_thumb_limit'], // See README for information about this setting.
	);

// Crop mode cuts out a random part of an image and uses it for the thumbnail
	if ($settings['crop_mode'] == 'true'){
		$config['crop_mode'] = true;
	}
	else{
		$config['crop_mode'] = false;
		}
// The sort order settings can have the following values:
	// SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING
	// SORT_ASC = ascending, SORT_DESC = descending
	if ($settings['dir_sort_order'] == 'SORT_ASC'){
		$config['dir_sort_order'] = SORT_ASC;
	}
	elseif($settings['dir_sort_order'] == 'SORT_REGULAR'){
		$config['dir_sort_order'] = SORT_REGULAR;
		}
		elseif($settings['dir_sort_order'] == 'SORT_NUMERIC'){
		$config['dir_sort_order'] = SORT_NUMERIC;
		}
		elseif($settings['dir_sort_order'] == 'SORT_STRING'){
		$config['dir_sort_order'] = SORT_STRING;
		}
		elseif($settings['dir_sort_order'] == 'SORT_DESC'){
		$config['dir_sort_order'] = SORT_DESC;
		}
//img_sort_order	
	if ($settings['img_sort_order'] == 'SORT_ASC'){
		$config['img_sort_order'] = SORT_ASC;
	}
	elseif($settings['img_sort_order'] == 'SORT_REGULAR'){
		$config['img_sort_order'] = SORT_REGULAR;
		}
		elseif($settings['img_sort_order'] == 'SORT_NUMERIC'){
		$config['img_sort_order'] = SORT_NUMERIC;
		}
		elseif($settings['img_sort_order'] == 'SORT_STRING'){
		$config['img_sort_order'] = SORT_STRING;
		}
		elseif($settings['img_sort_order'] == 'SORT_DESC'){
		$config['img_sort_order'] = SORT_DESC;
		}
		
		
if ($settings['dir_thumbs'] == 'true'){
		$config['dir_thumbs'] = true;
	}
	else{
		$config['dir_thumbs'] = false;
		}
		
		
if ($settings['random_thumbs'] == 'true'){
		$config['random_thumbs'] = true;
	}
	else{
		$config['random_thumbs'] = false;
		}

// Setup cache
if($settings['cache']=='true'){

$gallery_cache = new ImgBrowz0rCache(
	$config['cache_dir'], // The location of the cache directory. In this case the smae as imgBrowz0r's one.
	3600 // The amount of seconds the cache is valid.
);
$gallery = new ImgBrowz0r($config, $gallery_cache);
}
else{
    $gallery = new ImgBrowz0r($config);
}

// Prepare everything. This function must be called before
// you call other functions. (required)
$gallery->init();

// Generate navigation and statistics. (optional, but remommended)
// The output of the functions are now assigned to variabled, but
// you can also call the functions directly.
$gallery_breadcrumbs = $gallery->breadcrumbs();
$gallery_pagination = $gallery->pagination();
//$gallery_statistics = $gallery->statistics();

// Display description of the current directory. (optional)
echo $gallery->description();

// Display navigation
echo '<div class="imgbrowz0r-navigation">', "\n\t",
     $gallery_breadcrumbs, "\n\t",
	 $gallery_pagination, "\n\t",
	  '</div>', "\n\n";

// Display images and directories. (required)
echo $gallery->browse();

// Display navigation
echo '<div class="imgbrowz0r-navigation">', "\n\t",
     $gallery_pagination, "\n\t",
	 $gallery_breadcrumbs, "\n", '</div>', "\n\n";

// Showing some stats (optional)
/*echo '<p>Processing time: ', round(get_microtime(microtime()) - get_microtime($start_timer), 5),
	' &amp;&amp; Memory usage: ', file_size(memory_get_usage()),
	' &amp;&amp; Memory peak: ', file_size(memory_get_peak_usage()), '</p>';*/

if($settings['allow_all'] == 'true' or $editable== TRUE){
	?>
<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,gears,browserplus,flash,silverlight',
		url : '<?php echo WB_URL;?>/modules/Auto_Gallery/upload.php',
		max_file_size : '<?php echo $settings['pl_max_file_size'];?>',
		chunk_size : '<?php echo $settings['pl_chunk_size'];?>',
		unique_names : <?php echo $settings['pl_unique_names'];?>,
		multiple_queues : true,

		// Resize images on clientside if we can
		<?php
		if ($settings['pl_resize']=='true'){
		echo"resize : {width :".$settings['pl_width'].", height: ".$settings['pl_height'].", quality : ".$settings['pl_quality']."},";
		
		}?>

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}//,
			//{title : "Zip files", extensions : "zip"}
		],

		// Flash settings
		flash_swf_url : '<?php echo WB_URL;?>/modules/Auto_Gallery/include/plupload/js/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : '<?php echo WB_URL;?>/modules/Auto_Gallery/include/plupload/js/plupload.silverlight.xap'
	});

//added for Auto_gallery
	var $uploader = $("#uploader").pluploadQueue();
		$uploader.settings.multipart_params = {final_dir: '<?php echo str_replace("\\" ,"\\\\" ,$gallery->current_dir());?>',
												ident : '<?php echo $ident; ?>'};
												
	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            alert('You must queue at least one file.');
        }

        return false;
    });



    // Events
    $('.ui-button.ui-state-default').hover(
        function(){
            $(this).addClass('ui-state-hover');
        },
        function(){
            $(this).removeClass('ui-state-hover');
        }
    );
});

	//.po file like language pack
plupload.addI18n({
    'Select files' : '<?php echo $DNDTEXT['SELECT_FILE']?>',
    'Add files to the upload queue and click the start button.' : '<?php echo $DNDTEXT['ADD_FILE_2_Q']?>',
    'Filename' : '<?php echo $DNDTEXT['FILENAME']?>',
    'Status' : '<?php echo $DNDTEXT['STATUS']?>',
    'Size' : '<?php echo $DNDTEXT['SIZE']?>',
    'Add files' : '<?php echo $DNDTEXT['ADD_FILES']?>',
    'Stop current upload' : '<?php echo $DNDTEXT['STOP_UPLOAD']?>',
    'Start upload': '<?php echo $DNDTEXT['START_UPLOAD']?>',
    'Start uploading queue' : '<?php echo $DNDTEXT['START_UP_Q']?>', 
    'Drag files here.' : '<?php echo $DNDTEXT['DRAG_HERE']?>'
});


//Show Hide all the tools
$("#tools_button").click(function () {
      $("#add_files").slideToggle('slow');
	  $(this).toggleClass('ui-state-active');
	  $("#tools_button span").toggleClass('ui-icon-circle-arrow-n');
	  	      	});
            </script>
<?php  }	//end if editable ?>
<script language="javascript" type="text/javascript">
$("#add_files").hide();
</script>
