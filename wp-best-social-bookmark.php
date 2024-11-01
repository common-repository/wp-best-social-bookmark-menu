<?php
/*
Plugin Name: WP BEST SOCIAL BOOKMARK MENU (IT)
Plugin URI: http://www.giochiandgiochi.com/plugin/wp-best-social/
Description: Add the best social bookmarking links (OKNOtizie, Twitter, Delicius, Facebook). See <a href="options-general.php?page=wp-best-social-bookmark.php">configuration panel</a> for more settings. For more info and plugins visit <a href="http://www.prima-posizione.it/">Dechigno</a>
Version: 1.2
Author: Dechigno
Author URI: http://www.prima-posizione.it/
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 
	Copyright 2010 Prima Posizione Srl (email : info@prima-posizione.it)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	
	CHANGE LOG
	
	* 1.2		Change copy and remove some minor bugs fix
	* 1.1		Fix bugs on load style
	* 1.0		First Release

*/

// ________________________________________________________________________________________ MAIN

/**
 * DEFINE CONSTANT
 *
 * All constant are defined here
 */
define( 'PLUGINNAME',		'WP-BEST-SOCIAL-BOOKMARK' );
define( 'OPTIONSKEY',		'WP-BEST-SOCIAL-BOOKMARK' );
define( 'OPTIONSTITLE',		'Social Best Bookmark Menu' );
define( 'VERSION',			'1.0' );

define( 'WSBM_CONTENT_URL', 	get_option('siteurl') . '/wp-content' );
define( 'WSBM_PLUGINS_PATH',	WSBM_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/' );


/**
 * INIT OPTIONS
 *
 * The default options are stored in this array ( key => default value )
 * The global plugin variables have a $wpp_ prefix (wordpress plugin)
 */
$wpp_options = array(
				  'position' => 'onthebottom',
				  'bookmark' => array( 'scriptstyle', 'blinklist', 'delicious', 'digg', 'furl', 'reddit', 'yahoomyweb', 'stumbleupon', 'technorati', 'mixx', 'myspace', 'designfloat', 'facebook', 'oknotizie', 'twitter' )
				);

/**
 * Add to Wordpress options database
 */
add_option( OPTIONSKEY, $wpp_options, OPTIONSTITLE );

/**
 * re-Load options
 */
$wpp_options = get_option( OPTIONSKEY );


// ________________________________________________________________________________________ OPTIONS

/**
 * ADD OPTION PAGE TO WORDPRESS ENVIRORMENT
 *
 * Add callback for adding options panel
 *
 */
function wpp_options_page() {
	if ( function_exists('add_options_page') ) {
 		add_options_page( OPTIONSTITLE, OPTIONSTITLE, 8, basename(__FILE__), 'wpp_options_subpanel');
	}
}

/**
 * Draw Options Panel
 */
function wpp_options_subpanel() {
	global $wpp_options, $_POST;

	$any_error = "";										// any error flag

	if( isset($_POST['flag_save'] ) ) {						// have to save options
		$any_error = 'Your settings have been saved.';
		
		/**
		 * Check for any missing or wrong POST value
		 */
		if( $_POST['position'] == '' ) {		
			$any_error = 'Some field is empty! Check and try again!';
		} else {
			$wpp_options['position'] 	= $_POST['position'];
			$wpp_options['bookmark'] 	= $_POST['bookmark'];
			
			update_option( OPTIONSKEY, $wpp_options);
		}
	}
	
	/**
	 * Show error or OK
	 */
	if( $any_error != '') echo '<div id="message" class="updated fade"><p>' . $any_error . '</p></div>';
	
	/**
	 * INSERT OPTION
	 *
	 * You can include a separate file: include ('options.php');
	 *
	 */
	?>
	<style type="text/css">
		form#wp-best-social-bookmark span {
			background:url('<?=WSBM_PLUGINS_PATH?>sprite-trans.png') no-repeat;
			display:inline-block;
			height:29px;
			width:50px;
		}
		
		span.facebook { background-position:-450px bottom !important; }
		span.oknotizie { background-position:-650px bottom !important; }
		span.delicious { background-position:left bottom !important; }
		span.twitter { background-position:-100px bottom !important; }
		
	</style>
	<div class="wrap">
    <h2>WP BEST Social Bookmark Menu (IT)</h2>
	
	<form name="wp-best-social-bookmark" id="wp-best-social-bookmark" action="" method="post">
		<input type="hidden" name="flag_save" value="1" />
		  
		  <table width="300" cellpadding="4" cellspacing="0">

		  <tr>
		  <td align="right" valign="top" nowrap><label for="position">Position:</label> </td>
		  <td>
		  	  <input <?php echo ( ($wpp_options['position'] == "onthetop") ? 'checked="checked"' : "" );  ?> name="position" id="position" type="radio" value="onthetop" /> On the top<br/>
		  	  <input <?php echo ( ($wpp_options['position'] == "onthebottom") ? 'checked="checked"' : "" );  ?> name="position" id="position" type="radio" value="onthebottom" /> On the bottom
		  </td>
		  </tr>
		  
		  <tr>
		   <td align="right" valign="top" nowrap><label for="position">Choose Bookmark:</label> </td>
		  <td>
			  <input <?php echo (  @in_array(  "delicious", $wpp_options['bookmark'] ) ? 'checked="checked"' : "" );  ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="delicious" /> del.icio.us <span class="delicious"></span><br/>
			  <input <?php echo (  @in_array(  "oknotizie", $wpp_options['bookmark'] ) ? 'checked="checked"' : "" );  ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="oknotizie" /> oknotizie <span class="oknotizie"></span><br/>
			  <input <?php echo (  @in_array(  "twitter", $wpp_options['bookmark'] ) ? 'checked="checked"' : "" );  ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="twitter" /> twitter <span class="twitter"></span><br/>
			  <input <?php echo (  @in_array(  "facebook", $wpp_options['bookmark'] ) ? 'checked="checked"' : "" );  ?> name="bookmark[]" id="bookmark[]" type="checkbox" value="facebook" /> facebook <span class="facebook"></span><br/>
		  </td>	
		  
		  <tr>  
		  <td colspan="2"><div class="submit"><input type="submit" value="Save Settings" /></div></td>
		  </tr>
		  	  
		  </table>
		</form>

		<p style="text-align:center;font-family:Tahoma;font-size:10px">Developed by <a target="_blank" href="http://www.saidmade.com"><img align="absmiddle" src="http://labs.saidmade.com/images/sm-a-80x15.png" border="0" /></a>
			<br/>
			more Wordpress plugins on <a target="_blank" href="http://labs.saidmade.com">labs.saidmade.com</a> and <a target="_blank" href="http://www.undolog.com">Undolog.com</a>
			<br/>
			<form style="text-align:center;width:300px;margin:0 auto" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="3499468">
				<input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - Il sistema di pagamento online più facile e sicuro!">
				<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
			</form>
		</p>				
	</div>
	<?php
}

/**
 * Action
 */
function wpp_wp_head_action () {
	$o = '<!-- Start Of Script Generated By wp-best-social-bookmark ' . VERSION . ' -->' . "\n" .
	 	 '<!--[if lt IE 7]>' . "\n" .
		 '<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>' . "\n" .
		 '<![endif]-->'."\n" .
		 '<link rel="stylesheet" href="' . WSBM_PLUGINS_PATH . 'styles.css" type="text/css" media="screen" />' .
		 '<!-- End Of Script Generated By wp-best-social-bookmark ' . VERSION . ' -->'."\n";
	echo $o;
} 

/**
 * Filter
 */
function wpp_the_content_filter( $content ) {
	global $wpp_options;
	//
	$title = get_the_title();
	$perma = get_permalink();
	$social = '<div class="wp-best-social-bookmark"><ul class="socials">' .

	( in_array(  "oknotizie", $wpp_options['bookmark'] ) ?
	'<li class="oknotizie"><a href="http://oknotizie.virgilio.it/post.html.php?url=' . $perma . '&title=' . $title . '" title="Share this on oknotizie"> </a></li>' : '' ) .

	( in_array(  "twitter", $wpp_options['bookmark'] ) ?
	'<li class="twitter"><a href="http://twitter.com/home?status=' . $title . ' &raquo; ' . $perma . '" title="Share this on twitter"> </a></li>' : '' ) .
	
	( in_array(  "delicious", $wpp_options['bookmark'] ) ?
	'<li class="delicious"><a href="http://del.icio.us/post?url=' . $perma . '&title=' . $title . '" title="Share this on del.icio.us"> </a></li>' : '' ) .
	
	( in_array(  "facebook", $wpp_options['bookmark'] ) ?
	'<li class="facebook"><a href="http://www.facebook.com/share.php?u=' . $perma . '&amp;t=' . $title . '" title="Share this on Facebook"> </a></li>' : '' ) .
	
	'</ul></div>';
	if( $wpp_options['position'] == "onthetop") return $social.$content;
	else return $content.$social;
} 

/**
 * Link my custom option to admin menu
 *
 */ 
add_action('admin_menu', 	'wpp_options_page');
add_action('wp_head', 		'wpp_wp_head_action');
add_filter('the_content',	'wpp_the_content_filter');

?>