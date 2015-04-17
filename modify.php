<?php

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2006, Ryan Dju<?php
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



// prevent this file from being accessed directly
if (!defined('WB_PATH')) die(header('Location: ../../index.php'));
//include jquery UI

echo "<link rel=\"stylesheet\" href=\"".WB_URL."/include/jquery/jquery-ui.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />";
// load module language file
$lang = (dirname(__FILE__)) . '/languages/' . LANGUAGE . '.php';
require_once(!file_exists($lang) ? (dirname(__FILE__)) . '/languages/EN.php' : $lang );

// include Website Baker module functions and show edit button for optional module CSS files
require_once(WB_PATH . '/framework/module.functions.php');
require_once(WB_PATH.'/framework/functions.php');
edit_module_css(basename(dirname(__FILE__)));

// create new template instance and set path to template folder
require_once(WB_PATH . '/include/phplib/template.inc');

//connect to database  
  $conn = $database->connect();
	if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}
	
	
 $page_id = $_GET['page_id'];
 

	
// obtain data from module DB-table of the current displayed page (unique page defined via section_id)
	$sql_results =	$database->query("SELECT * FROM `".TABLE_PREFIX."mod_auto_gallery` WHERE `section_id` = '$section_id'");

// store all results (fields) in the array $sql_row
	$sql_row = $sql_results->fetchRow(); 
	

echo" <h3>".$AGTEXT['SETTINGS']."</h3>";?>
 <div id="accordion">


<h3><a href="#" ><?php echo $AGTEXT['ISETTINGS']; ?></a></h3>
<div> 
<form action="<?php echo WB_URL.'/modules/Auto_Gallery/save_settings.php'; ?>" method="post"> 
  <table>
  <tr>
    <td colspan="2"></td>
    
  </tr>
  <tr>
    <td class="required"><input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
      <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
      Image Path(required):</td>
    <td><select name="images_path" />
      
      <option value="<?php echo $sql_row['images_path'];?>" selected><?php echo $sql_row['images_path']; ?></option>
      <?php
			$folder_list = directory_list(WB_PATH.MEDIA_DIRECTORY);
			array_push($folder_list,WB_PATH.MEDIA_DIRECTORY);
			sort($folder_list);
			foreach($folder_list AS $foldername) {
				$thumb_count=substr_count($foldername, '/thumbs');
				if($thumb_count==0 and trim($foldername)!=""){
					echo "<option value='".str_replace(WB_PATH."/",'',$foldername)."'>".str_replace(WB_PATH."/",'',$foldername)."</option>\n";
				}
				$thumb_count="";	
			}	
			?>
      </select></td>
  </tr>
  <tr>
    <td class="required">Cache Path(required):</td>
    <td><select name="cache_path" />
      
      <option value="<?php echo $sql_row['cache_path'];?>" selected><?php echo $sql_row['cache_path']; ?></option>
      <?php
			$folder_list = directory_list(WB_PATH.MEDIA_DIRECTORY);
			array_push($folder_list,WB_PATH.MEDIA_DIRECTORY);
			sort($folder_list);
			foreach($folder_list AS $foldername) {
				$thumb_count=substr_count($foldername, '/thumbs');
				if($thumb_count==0 and trim($foldername)!=""){
					echo "<option value='".str_replace(WB_PATH."/",'',$foldername)."'>".str_replace(WB_PATH."/",'',$foldername)."</option>\n";
				}
				$thumb_count="";	
			}	
			?>
      </select></td>
  <tr>
    <td>Use a cache:</td>
    <td>  <p>
      <label>
        <input type="radio" name="cache" value="true" id="cache_0" <?php if($sql_row['cache']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="cache" value="false" id="cache_1"<?php if($sql_row['cache']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
      </tr>
  <tr>
    <td>
      Directory sort by:</td>
    <td><select name="dir_sort_by" >
        <option value="1" <?php if($sql_row['dir_sort_by']==1){echo "\"selected\"";}?> >filename</option>
        <option value="2" <?php if($sql_row['dir_sort_by']==2){echo "\"selected\"";}?> >extension</option>
        <option value="3" <?php if($sql_row['dir_sort_by']==3){echo "\"selected\"";}?> >inode change time of file</option>
      </select></td>
  </tr>
  <tr>
    <td>Directory sort order:</td>
    <td><select name="dir_sort_order" >
        <option value="SORT_ASC" <?php if($sql_row['dir_sort_order']=='SORT_ASC'){echo "\"selected\"";}?> >ascending</option>
        <option value="SORT_DESC" <?php if($sql_row['dir_sort_order']=='SORT_DESC'){echo "\"selected\"";}?> >descending</option>
        <option value="SORT_REGULAR" <?php if($sql_row['dir_sort_order']=='SORT_REGULAR'){echo "\"selected\"";}?> >regular</option>
        <option value="SORT_NUMERIC" <?php if($sql_row['dir_sort_order']=='SORT_NUMERIC'){echo "\"selected\"";}?> >numeric</option>
        <option value="SORT_STRING" <?php if($sql_row['dir_sort_order']=='SORT_STRING'){echo "\"selected\"";}?> >string</option>
      </select></td>
  </tr>
  <tr>
    <td>Image sort by:</td>
    <td><select name="img_sort_by" >
        <option value="1" <?php if($sql_row['img_sort_by']==1){echo "\"selected\"";}?> >filename</option>
        <option value="2" <?php if($sql_row['img_sort_by']==2){echo "\"selected\"";}?> >extension</option>
        <option value="3" <?php if($sql_row['img_sort_by']==3){echo "\"selected\"";}?> >inode change time of file</option>
      </select></td>
  </tr>
  <tr>
    <td>Image sort order:</td>
    <td><select name="img_sort_order" >
        <option value="SORT_ASC" <?php if($sql_row['img_sort_order']=='SORT_ASC'){echo "\"selected\"";}?> >ascending</option>
        <option value="SORT_DESC" <?php if($sql_row['img_sort_order']=='SORT_DESC'){echo "\"selected\"";}?> >descending</option>
        <option value="SORT_REGULAR" <?php if($sql_row['img_sort_order']=='SORT_REGULAR'){echo "\"selected\"";}?> >regular</option>
        <option value="SORT_NUMERIC" <?php if($sql_row['img_sort_order']=='SORT_NUMERIC'){echo "\"selected\"";}?> >numeric</option>
        <option value="SORT_STRING" <?php if($sql_row['img_sort_order']=='SORT_STRING'){echo "\"selected\"";}?> >string</option>
      </select></td>
  </tr>
  <tr>
    <td>Thumbs per page:</td>
    <td><input type="text" name="thumbs_per_page" value="<?php echo $sql_row['thumbs_per_page'];?>" >
      </input></td>
  </tr>
  <tr>
    <td>Maximum thumbs per row:</td>
    <td><input type="text" name="max_thumb_row" value="<?php echo $sql_row['max_thumb_row'];?>" >
      </input></td>
  </tr>
  <tr>
    <td>Maximum thumb width:</td>
    <td><input type="text" name="max_thumb_width" value="<?php echo $sql_row['max_thumb_width'];?>" >
      </input></td>
  </tr>
  <tr>
    <td>Maximum thumb height:</td>
    <td><input type="text" name="max_thumb_height" value="<?php echo $sql_row['max_thumb_height'];?>" >
      </input></td>
  </tr>
  <tr>
    <td>Time format:</td>
    <td><input type="text" name="time_format" value="<?php echo $sql_row['time_format'];?>" >
      </input>leave blank for none</td>
  </tr>
  <tr>
    <td>Time zone:</td>
    <td><input type="text" name="time_zone" value="<?php echo $sql_row['time_zone'];?>" >
      </input></td>
  </tr>
  <tr>
    <td>Ignore port in url:</td>
    <td><p>
      <label>
        <input type="radio" name="ignore_port" value="true" id="ignore_port_0" <?php if($sql_row['ignore_port']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="ignore_port" value="false" id="ignore_port_1"<?php if($sql_row['ignore_port']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
  </td>
  </tr>
  <tr>
    <td>Show directory thumbs:</td>
    <td><p>
      <label>
        <input type="radio" name="dir_thumbs" value="true" id="dir_thumbs_0" <?php if($sql_row['dir_thumbs']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="dir_thumbs" value="false" id="dir_thumbs_1"<?php if($sql_row['dir_thumbs']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
  </tr>
  <tr>
    <td>Random thumbs:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="random_thumbs" value="true" id="random_thumbs_0" <?php if($sql_row['random_thumbs']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="random_thumbs" value="false" id="random_thumbs_1"<?php if($sql_row['random_thumbs']=='false'){echo "checked";}?> />
        False</label>
     NOTE: random_thumbs will not work when the cache is enabled.</p></td>
  </tr>
  <tr>
    <td>Read thumb limit:</td>
    <td><input type="text" name="read_thumb_limit" value="<?php echo $sql_row['read_thumb_limit'];?>">
      </input>Number of thumbnails to read when selecting a random thumb(0=read all)</td>
  </tr>
  <tr>
    <td>Crop mode:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="crop_mode" value="true" id="crop_mode_0" <?php if($sql_row['crop_mode']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="crop_mode" value="false" id="crop_mode_1"<?php if($sql_row['crop_mode']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
   </td>
  </tr>
  <tr>
    <td>Crop resize factor:</td>
    <td><div class="demo">

<p>

	<label for="crop_resize_factor">Resize the Image before croping by a factor of:</label>
	<input type="text" name="crop_resize_factor" id="crop_resize_factor" style="border:0; color:#f6931f; font-weight:bold;" value=<?php echo $sql_row['crop_resize_factor'];?> />
</p>

<div id="slider2"></div>

</div><!-- End demo --></td>
  </tr>
  </table>
  </div>
  <?php echo" <h3><a href=\"#\" >".$AGTEXT['PPSETTINGS']."</a></h3>"; ?>
    <div>
  <table>
  <tr>
  <td>Animation speed:</td>
    <td><select name="animation_speed" >
        <option value="fast" <?php if($sql_row['animation_speed']=='fast'){echo "\"selected\"";}?> >fast</option>
        <option value="normal" <?php if($sql_row['animation_speed']=='normal'){echo "\"selected\"";}?> >normal</option>
        <option value="slow" <?php if($sql_row['animation_speed']=='slow'){echo "\"selected\"";}?> >slow</option>
      </select></td>
  <tr>
    <td>Slideshow:</td>
    <td><input type="text" name="slideshow" value="<?php echo $sql_row['slideshow'];?>" >
      </input>
       interval time in ms</td>
  </tr>
  <tr>
    <td>Autoplay slideshow:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="autoplay_slideshow" value="true" id="autoplay_slideshow_0" <?php if($sql_row['autoplay_slideshow']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="autoplay_slideshow" value="false" id="autoplay_slideshow_1"<?php if($sql_row['autoplay_slideshow']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
  </tr>
  <tr>
    <td>Opacity:</td>
    <td><div class="demo">

<p>

	<label for="opacity">Opacity of Background:</label>
	<input type="text" name="opacity" id="opacity" style="border:0; color:#f6931f; font-weight:bold;" value=<?php echo $sql_row['opacity'];?> />
</p>

<div id="slider"></div>

</div><!-- End demo -->    
    </td>
  </tr>
  <tr>
    <td>Show title:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="show_title" value="true" id="show_title_0" <?php if($sql_row['show_title']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="show_title" value="false" id="show_title_1"<?php if($sql_row['show_title']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
  </tr>
  <tr>
    <td>Allow resize:</td>
    <td><p>
      <label>
        <input type="radio" name="allow_resize" value="true" id="allow_resize_0" <?php if($sql_row['allow_resize']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="allow_resize" value="false" id="allow_resize_1"<?php if($sql_row['allow_resize']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
  </tr>
  <tr>
    <td>Default width:</td>
    <td><input type="text" name="default_width" value="<?php echo $sql_row['default_width'];?>" >
      </input></td>
  </tr>
  <tr>
  <tr>
    <td>Default height:</td>
    <td><input type="text" name="default_height" value="<?php echo $sql_row['default_height'];?>" >
      </input></td>
  </tr>
  <tr>
  <tr>
    <td>Counter separator label:</td>
    <td><input type="text" name="counter_separator_label"  value="<?php echo $sql_row['counter_separator_label'];?>">
      </input></td>
  </tr>
  <tr>
    <td>Theme:</td>
    <td><select name="theme" >
        <option value="dark_rounded" <?php if($sql_row['theme']=='dark_rounded'){echo "\"selected\"";}?> >dark_rounded</option>
        <option value="light_rounded" <?php if($sql_row['theme']=='light_rounded'){echo "\"selected\"";}?> >light_rounded</option>
        <option value="light_square" <?php if($sql_row['theme']=='light_square'){echo "\"selected\"";}?> >light_square</option>
        <option value="dark_square" <?php if($sql_row['theme']=='dark_square'){echo "\"selected\"";}?> >dark_square</option>
        <option value="facebook" <?php if($sql_row['theme']=='facebook'){echo "\"selected\"";}?> >facebook</option>
      </select></td>
  </tr>
  <tr>
    <td>Only the close button <br /> will close the window:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="modal" value="true" id="modal_0" <?php if($sql_row['modal']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="modal" value="false" id="modal_1"<?php if($sql_row['modal']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
    </td>
  </tr>
  <tr>
    <td>Overlay Gallery:</td>
    <td>
    <p>
      <label>
        <input type="radio" name="overlay_gallery" value="true" id="overlay_gallery_0" <?php if($sql_row['overlay_gallery']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="overlay_gallery" value="false" id="overlay_gallery_1"<?php if($sql_row['overlay_gallery']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
   </td>
  </tr>
  <tr>
    <td>Keyboard shortcuts:</td>
    <td>
      <p>
      <label>
        <input type="radio" name="keyboard_shortcuts" value="true" id="keyboard_shortcuts_0" <?php if($sql_row['keyboard_shortcuts']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="keyboard_shortcuts" value="false" id="keyboard_shortcuts_1"<?php if($sql_row['keyboard_shortcuts']=='false'){echo "checked";}?> />
        False</label>
     
    </p>
   </td>
  </tr>
  </table>
  </div> 
   <?php echo" <h3><a href=\"#\" >plupload Settings</a></h3>"; ?>
    <div>
    <table>
     <tr>
    <td>Allowed Users:</td>
    <td> <p>
      <label>
        <input type="radio" name="allow_all" value="true" id="allow_all_0" <?php if($sql_row['allow_all']=='true'){echo "checked";}?>/>
        Allow everyone</label><br/>
      
      <label>
        <input type="radio" name="allow_all" value="false" id="allow_all_1"<?php if($sql_row['allow_all']=='false'){echo "checked";}?> />
        Allow only logged in page administrators</label>
     
    </p></td>
    </tr>
    <tr>
    <td>Max File Size:</td>
    <td><input type="text" name="pl_max_file_size" value="<?php echo $sql_row['pl_max_file_size'];?>" >
      </input></td>
    </tr>
    
    <tr>
    <td>Chunk Size:</td>
    <td><input type="text" name="pl_chunk_size" value="<?php echo $sql_row['pl_chunk_size'];?>" >
      </input></td>
    </tr>
    
    <tr>
    <td>Unique File Names:</td>
    <td> <p>
      <label>
        <input type="radio" name="pl_unique_names" value="true" id="pl_unique_names_0" <?php if($sql_row['pl_unique_names']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="pl_unique_names" value="false" id="pl_unique_names_1"<?php if($sql_row['pl_unique_names']=='false'){echo "checked";}?> />
        False</label>
     
    </p></td>
    </tr>
    
     <tr>
    <td>Resize Images:</td>
    <td> <p>
      <label>
        <input type="radio" name="pl_resize" value="true" id="pl_resize_0" <?php if($sql_row['pl_resize']=='true'){echo "checked";}?>/>
        True</label>
      
      <label>
        <input type="radio" name="pl_resize" value="false" id="pl_resize_1"<?php if($sql_row['pl_resize']=='false'){echo "checked";}?> />
        False</label>
     
    </p></td>
    </tr>
    
    <tr>
    <td>Resize Height:</td>
    <td><input type="text" name="pl_height" value="<?php echo $sql_row['pl_height'];?>" >
      </input></td>
    </tr>
    
    <tr>
    <td>Resize Width:</td>
    <td><input type="text" name="pl_width" value="<?php echo $sql_row['pl_width'];?>" >
      </input></td>
    </tr>
    
    <tr>
    <td>Resize Quality:</td>
    <td><div class="demo">

<p>

	<label for="pl_quality">Image Quality:</label>
	<input type="text" name="pl_quality" id="pl_quality" style="border:0; color:#f6931f; font-weight:bold;" value=<?php echo $sql_row['pl_quality'];?> />
</p>

<div id="slider3"></div>

</div><!-- End demo -->    
    </td>
  </tr>
      
    <tr>
    <td>Allowed file types:</td>
    <td><input type="text" name="pl_file_filter" value="<?php echo $sql_row['pl_file_filter'];?>" >
      </input></td>
    </tr>
    
    </table>
    
    </div>
     </div>
 <input type="submit" name="submit" id="submit" value="<?php echo $TEXT['SAVE']; ?>" />
 <input type="reset" name="reset" id="reset" value="<?php echo $TEXT['RESET']; ?>" />
 <br/>
  
</form>
<form id="empty_cache"  action="<?php echo WB_URL.'/modules/Auto_Gallery/empty_cache.php'; ?>" method="post" >
      <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
      <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
      <input type="hidden" name="cache_dir" value="<?php echo WB_PATH."/".$sql_row['cache_path'];?>" />
      directory <?php echo WB_PATH."/".$sql_row['cache_path'];?>
      <input name="empty_cache" type="submit"  value="empty server cache">
      
      </input>
    </form>
