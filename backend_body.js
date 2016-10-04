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

$(document).ready(function()
{
$.insert('../../include/jquery/jquery-ui-min.js');
});

$(function() {
			$('#accordion').accordion({ autoHeight: false,
									   collapsible: true
									   });
	});
//slider  opacity
$(function() {
		   var $value;
		   $value = $("#opacity").val();
		$( "#slider" ).slider({
			value: $value,
			min: 0,
			max: 1,
			step: 0.1,
			slide: function( event, ui ) {
				$( "#opacity" ).val(  ui.value );
			}
		});
		$( "#opacity" ).val(  $( "#slider" ).slider( "value" ) );
	});
//slider  crop_resize
$(function() {
		   var $value;
		   $value = $("#crop_resize_factor").val();
		$( "#slider2" ).slider({
			value: $value,
			min: 1,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#crop_resize_factor" ).val(  ui.value );
			}
		});
		$( "#crop_resize_factor" ).val(  $( "#slider2" ).slider( "value" ) );
	});
//slider  Image Quality
$(function() {
		   var $value;
		   $value = $("#pl_quality").val();
		$( "#slider3" ).slider({
			value: $value,
			min: 0,
			max: 100,
			step: 1,
			slide: function( event, ui ) {
				$( "#pl_quality" ).val(  ui.value );
			}
		});
		$( "#pl_quality" ).val(  $( "#slider3" ).slider( "value" ) );
	});