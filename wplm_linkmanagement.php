<?php
/*
WPLM 1.3
Plugin Name: WP Link Management
Plugin URI: http://wplinkmanagement.com/wp-link-management
Description: WP link management is your complete link management solution. <strong>You can use this plugin for adding Sponsor link and Mumble (A sentence in the sidebar)</strong>. You can set only home page linking option or all pages. This plugin will help you to notify the link owner when his link is expiring and incase if the link owner does not renew the link, this plugin will delete that link automatically. You can set the email notification, Link adding and delete date, notification date etc.
Author: Kayes
Version: 1.4
Author URI: http://www.kayes.me

Copyright (C) 2012  Kayes

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


//protect direct access to this plugin
if(!defined('DB_HOST')){
    die("Direct Access Restricted");
}
function wplm_setup_defaults(){
	update_option('wplm_is_email_admin_owner','1');
	update_option('wplm_is_email_owner_after_expire','1');
	update_option('wplm_is_email_admin_after_expire','1');
	update_option('wplm_is_delete_after_expire','1');
}
register_activation_hook( __FILE__, 'wplm_setup_defaults' );
function newads(){
	?>
	
<div style="top:155px;left:880px;width:320px;height:320px;position:fixed;">
<h2>Plugin Sponsors</h2>
<div style="width:125px;padding:10px;float:left;">
<script language='JavaScript' type='text/javascript' src='http://ariyes.net/adnetwork/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://ariyes.net/adnetwork/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:20");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://ariyes.net/adnetwork/adclick.php?n=a9627862' target='_blank'><img src='http://ariyes.net/adnetwork/adview.php?what=zone:20&amp;n=a9627862' border='0' alt=''></a></noscript>
</div>
<div style="width:125px;padding:10px;float:left;">
<script language='JavaScript' type='text/javascript' src='http://ariyes.net/adnetwork/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://ariyes.net/adnetwork/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:21");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://ariyes.net/adnetwork/adclick.php?n=aa456dd9' target='_blank'><img src='http://ariyes.net/adnetwork/adview.php?what=zone:21&amp;n=aa456dd9' border='0' alt=''></a></noscript>
</div>
<div style="width:125px;padding:10px;;float:left;">
<script language='JavaScript' type='text/javascript' src='http://ariyes.net/adnetwork/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://ariyes.net/adnetwork/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:22");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://ariyes.net/adnetwork/adclick.php?n=a3851772' target='_blank'><img src='http://ariyes.net/adnetwork/adview.php?what=zone:22&amp;n=a3851772' border='0' alt=''></a></noscript>
</div>
<div style="width:125px;padding:10px;float:left;">
<script language='JavaScript' type='text/javascript' src='http://ariyes.net/adnetwork/adx.js'></script>
<script language='JavaScript' type='text/javascript'>
<!--
   if (!document.phpAds_used) document.phpAds_used = ',';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);
   
   document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
   document.write ("http://ariyes.net/adnetwork/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:23");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("'><" + "/script>");
//-->
</script><noscript><a href='http://ariyes.net/adnetwork/adclick.php?n=ae0ad87d' target='_blank'><img src='http://ariyes.net/adnetwork/adview.php?what=zone:23&amp;n=ae0ad87d' border='0' alt=''></a></noscript>
</div>
</div>

	<?php
}

    function wplm_token_replacer($text,$replacers = array()){
        $text = str_replace("{admin_email}",$replacers['admin_email'],$text);
        $text = str_replace("{linkowner_email}",$replacers['linkowner_email'],$text);
        $text = str_replace("{linkowner_name}",$replacers['linkowner_name'],$text);
        $text = str_replace("{expire_date}",$replacers['expire_date'],$text);
        $text = str_replace("{link_url}",$replacers['link_url'],$text);
        $text = str_replace("{site_url}",get_option('site_url'),$text);
        return $text;
    }
     function wplm_expired_email($content){
        global $table_prefix;
        //get the expire limit days
         $email_admin_now = (int) get_option('wplm_is_email_admin_after_expire');
         $email_owner_now = (int) get_option('wplm_is_email_owner_after_expire');
         $del_after_expire = (int) get_option('wplm_is_delete_after_expire');
        if($email_admin_now == 1 || $email_owner_now){
            //get email format
            $admin_format = get_option('wplm_expired_email_format_admin');
            $owner_format = get_option('wplm_expired_email_format_owner');
            $admin_email  = get_option('wplm_admin_email');
            $today = date("Y-m-d");
        
            $sql = "SELECT * FROM ".$table_prefix."wplm WHERE end_date < '$today' AND notify_expired=0";
            $del_ids = "";
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)){
               $replacers = array("admin_email" => $admin_email, "linkowner_email" => $row['link_owner_email'], "linkowner_name" =>$row['link_owner_name'],"expire_date" => $row['end_date']);
                if($row['type'] == 'link'){
                    $replacers['link_url'] = '<a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a>';
                }
        else{
            $replacers['link_url'] = $row['anchor'];
        }
                $owner_message = wplm_token_replacer($owner_format,$replacers);
                $admin_message = wplm_token_replacer($admin_format,$replacers);
                //send owner email
                mail($row['link_owner_email'],"Link Expired",$owner_message); //change this later to wp_email 
                //send admin email
                mail($admin_email,"Link Expired",$admin_message); //change this later to wp_email
                //update the status
                mysql_query("UPDATE ".$table_prefix."wplm SET notify_expired = 1 WHERE id = ".$row['id']);
                $del_ids .= $row['id'] . ",";
            }
            $del_ids = trim($del_ids,",");
            if($del_after_expire == 1 && $del_ids != ""){
                mysql_query("DELETE FROM ".$table_prefix."wplm WHERE id IN($del_ids)");
            }
            
            
        }
        return $content;
    }
    
   function custom_add_date($date,$day){
#$newdate = strtotime ( '-3 day' , strtotime ( $date ) ) ;
$newdate = strtotime ( $day , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;

}

    function wplm_expiring_email($content){
        global $table_prefix;
        //get the expire limit days
        $days_before = (int) get_option('wplm_days_before');
        $email_now = (int) get_option('wplm_is_email_admin_owner');
        if($email_now == 1){
            //get email format
            $admin_format = get_option('wplm_expiring_email_format_admin');
            $owner_format = get_option('wplm_expiring_email_format_owner');
            $admin_email  = get_option('wplm_admin_email');

            $today = date("Y-m-d");
            if(function_exists('date_add')){
            $date = date_create($today);
            date_add($date, date_interval_create_from_date_string($days_before .' days'));
            $expiring_day = date_format($date, 'Y-m-d');
            }
else{
$expiring_day = custom_add_date($today,'+'.$days_before.' day');
}
            
            
            $sql = "SELECT * FROM ".$table_prefix."wplm WHERE end_date BETWEEN  '$today' AND '$expiring_day' AND notify_expire=0";
        
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)){
                $replacers = array("admin_email" => $admin_email, "linkowner_email" => $row['link_owner_email'], "linkowner_name" =>$row['link_owner_name'],"expire_date" => $row['end_date']);
                
                 if($row['type'] == 'link'){
                    $replacers['link_url'] = '<a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a>';
                }
        else{
            $replacers['link_url'] = $row['anchor'];
        }
                $owner_message = wplm_token_replacer($owner_format,$replacers);
                $admin_message = wplm_token_replacer($admin_format,$replacers);
                //send owner email
                mail($row['link_owner_email'],"Link Is Expiring",$owner_message); //change this later to wp_email 
                //send admin email
                mail($admin_email,"Link Is Expiring",$admin_message); //change this later to wp_email
                //update the status
                mysql_query("UPDATE ".$table_prefix."wplm SET notify_expire = 1 WHERE id = ".$row['id']);
            }
        }
        return $content;
    }

    //widget part
	//LINKS PRINT AS STRINGS
	function sampleHelloLinks(){

	global $table_prefix;
    $today = date("Y-m-d");
    $sql_load_links = "SELECT * FROM ".$table_prefix."wplm WHERE type='link' AND '$today' BETWEEN start_date AND end_date ORDER BY end_date";           
	$result_load = mysql_query($sql_load_links);
	
	
	echo '<ul>';
	while($row = mysql_fetch_assoc($result_load)){
		if(is_home()){
			echo '<li><a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a></li>';                      		
		}else{
           if($row['only_home'] != 1){
            echo '<li><a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a></li>';
            }
        }
	}
	echo '</ul>';
	
	}
	
	//WIDGETS MANAGEMENT TOOL WHERE FETCH TITLE AND SHOW DATA
	function widget_myHelloWorld($args) {
	extract($args);
 
	$options = get_option("widget_myHelloWorld");
	if (!is_array( $options )){
		$options = array(
		'title' => 'WPLM Links'
      );
	}
 
	echo $before_widget;
    echo $before_title;
		echo $options['title'];
    echo $after_title;
 
    sampleHelloLinks();
	echo $after_widget;
	
	}
	
	
	
	//WIDGET CONTROL TOOLS
	function myHelloWorld_control(){
	$options = get_option("widget_myHelloWorld");
	if (!is_array( $options )){
		$options = array('title' => 'WPLM Link Title');
	}
 
	if ($_POST['myHelloWorld-Submit']){
    $options['title'] = htmlspecialchars($_POST['myHelloWorld-WidgetTitle']);
    update_option("widget_myHelloWorld", $options);
	}
 
	?>
	<p>
		<label for="myHelloWorld-WidgetTitle">Widget Title: </label>
		<input type="text" id="myHelloWorld-WidgetTitle" name="myHelloWorld-WidgetTitle" value="<?php echo $options['title'];?>" />
		<input type="hidden" id="myHelloWorld-Submit" name="myHelloWorld-Submit" value="1" />
	</p>
	<?php
	}


	//WIDGETS REGISTRATION FUNCTION 	
	function myHelloWorld_init(){
	register_sidebar_widget(__('WPLM Links'), 'widget_myHelloWorld');
	register_widget_control(   'WPLM Links', 'myHelloWorld_control', 300, 200 );
	}

	//REGISTERED YOUR WIDGET HERE
	add_action("plugins_loaded", "myHelloWorld_init");
	
    function widget_link_management_init() {		
    } 
    
	//===============================================================
	//---------------------------------------------------------------
	//===============================================================
	
	
	//LINKS PRINT AS STRINGS
	function samplemumbleLinks(){

	global $table_prefix;
    $today = date("Y-m-d");
    $sql_load_links = "SELECT * FROM ".$table_prefix."wplm WHERE type='mumble' AND '$today' BETWEEN start_date AND end_date ORDER BY end_date";
	$result_load = mysql_query($sql_load_links);
	
	echo '<ul>';
	$pattern = "/<(a)([^>]+)>/i";
	$replacement = "<\\1 target=\"_blank\"\\2>";
	while($row = mysql_fetch_assoc($result_load)){
		if(is_home()){
			//echo '<li><a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a></li>';
			echo '<li>'.preg_replace($pattern,$replacement,str_replace('target="_blank"','',$row['anchor'])).'</li>';
		}else{
           if($row['only_home'] != 1){
            //echo '<li><a href="'.$row['href'].'" target="'.$row['target'].'">'.$row['anchor'].'</a></li>';
			echo '<li>'.preg_replace($pattern,$replacement,str_replace('target="_blank"','',$row['anchor'])).'</li>';
            }
        }
	}
	echo '</ul>';
	}
	
	
	
	
	//WIDGETS MANAGEMENT TOOLS WHERE FETCH TITLE AND SHOW DATA
	function widget_mymumbleWorld($args) {
	extract($args);
 
	$options = get_option("widget_mymumbleWorld");
	if (!is_array( $options )){
		$options = array(
		'title' => 'WPLM Mubmles Title'
		);
	}
 
	echo $before_widget;
    echo $before_title;
      echo $options['title'];
    echo $after_title;
		samplemumbleLinks();
	echo $after_widget;
	}
	
	
	
	function mymumbleWorld_control(){
	$options = get_option("widget_mymumbleWorld");
	if (!is_array( $options )){
		$options = array('title' => 'WPLM Mumbles');
	}
 
	if ($_POST['mymumbleWorld-Submit']){
    $options['title'] = htmlspecialchars($_POST['mymumbleWorld-WidgetTitle']);
    update_option("widget_mymumbleWorld", $options);
	}
 
	?>
	<p>
		<label for="mymumbleWorld-WidgetTitle">Widget Title: </label>
		<input type="text" id="mymumbleWorld-WidgetTitle" name="mymumbleWorld-WidgetTitle" value="<?php echo $options['title'];?>" />
		<input type="hidden" id="mymumbleWorld-Submit" name="mymumbleWorld-Submit" value="1" />
	</p>
	<?php
	}
	
	
	//MUMBLES CONTROLS HERE
	function mymumbleWorld_init(){
	register_sidebar_widget(__('WPLM Mumbles'), 'widget_mymumbleWorld');
	register_widget_control(   'WPLM Mumbles', 'mymumbleWorld_control', 300, 200 );
	}

	
	add_action("plugins_loaded", "mymumbleWorld_init");
	
    //widget part
    function widget_mumble_management_init() {            
    }  
    
    
    
//start of admin functionalities
if(preg_match('/wp-admin/',$_SERVER['PHP_SELF'])){

    
    
    
    
    
    
    
    /**
     * Function to add WPLM menu items to the wordpress menu
     */
    function wplm_admin_menus(){
        add_menu_page('WP Link Management', 'WPLM', 8, __FILE__, 'wplm_basic_config');
        add_submenu_page(__FILE__, 'Links', 'Links', 8, 'wplm_all_links', 'wplm_all_links');   
        add_submenu_page(__FILE__, 'Add Link', 'Add Link', 8, 'wplm_add_link', 'wplm_add_link');
        
    }
    
	function wplm_is_valid_date($y,$m,$d){   
    if(!checkdate($m,$d,$y))
        return false;
    return true;
        
}
    /**
     * Function to include the basic configuration
     */
    function wplm_basic_config(){
        require_once('wplmconfig.php');
    }
    /**
     * Function to include all the links page
     */
    function wplm_all_links(){
        require_once('show_allthe_links.php');
    }

    function wplm_add_css_js(){
       $plugin_folder = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'dp/'; 
        ?>
   <link rel="stylesheet" href="<?php echo $plugin_folder;?>themes/base/jquery.ui.all.css">
	<script src="<?php echo $plugin_folder;?>jquery-1.4.2.js"></script>
	<script src="<?php echo $plugin_folder;?>jquery.ui.core.js"></script>
	<script src="<?php echo $plugin_folder;?>jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="<?php echo $plugin_folder;?>demos.css">
<script>
$(document).ready(function() {
	$(function() {
		$( "#start_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $plugin_folder;?>/calendar.gif",
			buttonImageOnly: true
		});
		//$( "#start_date" ).datepicker( "option", "dateFormat", 'yy/mm/dd');
		$( "#end_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $plugin_folder;?>/calendar.gif",
			buttonImageOnly: true
		});
	//	$( "#end_date" ).datepicker( "option", "dateFormat", 'yy/mm/dd');
	});
	
});

	</script>
        <?php
    }
    /**
     * Function to include add link page
     */
    function wplm_add_link(){
        
        require_once('add_links.php');
    }
   
    function wplm_create_db(){
    global $table_prefix;
    	$sql = "CREATE TABLE IF NOT EXISTS `".$table_prefix."wplm` (
  `id` int(11) NOT NULL auto_increment,
  `href` varchar(300) collate latin1_general_ci NOT NULL,
  `anchor` text collate latin1_general_ci NOT NULL,
  `type` varchar(20) collate latin1_general_ci NOT NULL,
  `only_home` int(11) NOT NULL,
  `target` varchar(15) collate latin1_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `link_owner_name` varchar(255) collate latin1_general_ci NOT NULL,
  `link_owner_email` varchar(255) collate latin1_general_ci NOT NULL,
  `notify_expired` int(11) NOT NULL,
  `notify_expire` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
)";
    	mysql_query($sql);
    }
	
   
} // end of admin functionalities
add_action('admin_menu', 'wplm_admin_menus');
add_action('widgets_init', 'widget_link_management_init');
add_action('widgets_init', 'widget_mumble_management_init');
add_action('the_content','wplm_expiring_email');
add_action('the_content','wplm_expired_email');

register_activation_hook(__FILE__, 'wplm_create_db');
if(isset($_GET['page']) && ($_GET['page'] == 'wplm_all_links' || $_GET['page'] == 'wplm_add_link'))
	add_action('admin_head','wplm_add_css_js');
