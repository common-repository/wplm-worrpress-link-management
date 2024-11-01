<?php
//disable direct access
if(!defined('DB_NAME'))
    die("Direct Access To This File Is Denied");
 
function unix_t($date){
    $parts = explode("-",$date);
     return mktime(0,0,0,$parts[1],$parts[2],$parts[0]);
}
$wpcp_action = isset($_REQUEST['what']) ?  $_REQUEST['what'] : 'show';
$wpcp_current_page = $_SERVER['PHP_SELF'];
$wpcp_current_page .= '?page=wplm_all_links';  
global $table_prefix;


if($wpcp_action == 'delete'){
    $link_id = (int) $_GET['id'];
    mysql_query("DELETE FROM ".$table_prefix."wplm WHERE id=".$link_id);
    $msg = "Link Deleted";
    $wpcp_action = "show";
} 
?>
<div class="icon32" id="icon-options-general"><br/></div>

<h2>Links and Mumbles</h2>

<BR />    
<?php
//require_once('wplm_ads.php');

switch($wpcp_action){
    case "show":{
$sql_show_all = "SELECT id,href,anchor,type,start_date,end_date FROM ".$table_prefix."wplm ORDER BY end_date ";
$result_show_all = mysql_query($sql_show_all);
?>    
<style>
.expired{
background-color:#f0cecd;
}
</style>
    <table cellspacing="0" class="widefat post fixed">

    <caption id="wp_auto_status" style="font-family:tahoma;font-weight:bold;color:green"></caption>

    <thead>

    <tr>

    <th  class="manage-column column-date">Serial</th>

    <th  class="manage-column column-date">Link/Mumble</th>

    <th  class="manage-column column-date">Type</th>
    <th  class="manage-column column-date">Start Date</th>
    <th  class="manage-column column-date">End Date</th>
    
    <th  class="manage-column column-date">Edit</th>

    <th  class="manage-column column-date">Delete</th>

    

    </tr>

    </thead>



    <tfoot>
  

    <tr>

  <th  class="manage-column column-date">Serial</th>

    <th  class="manage-column column-date">Link/Mumble</th>

    <th  class="manage-column column-date">Type</th>
    <th  class="manage-column column-date">Start Date</th>
    <th  class="manage-column column-date">End Date</th>
    
    <th  class="manage-column column-date">Edit</th>

    <th  class="manage-column column-date">Delete</th>
    </tr>

    </tfoot>

<tbody>
<?php
 
$srl = 0;
while($row_all = mysql_fetch_assoc($result_show_all)){
    $srl++;
    $class_css = "";
$today = date("Y-m-d");
if(unix_t($today) > unix_t($row_all['end_date'])){
     $class_css = "expired"; 
}
?>
<tr class="<?php echo $class_css;?>">
<td><?php echo $srl; ?></td>
<td><?php 
if($row_all['type'] == 'link'){
    echo '<a target="'.$row_all['target'].'" href="'.$row_all['href'].'">'.$row_all['anchor'].'</a>';
}
else{
    echo $row_all['anchor'];
}
?></td>
<td>
<?php
echo $row_all['type'];
?>
</td>

<td>
<?php
echo $row_all['start_date'];
?>
</td>
<td>
<?php
echo $row_all['end_date'];
?>
</td>

<td><a href="<?php echo $wpcp_current_page;?>&id=<?php echo $row_all['id'];?>&what=edit">Edit</a></td>
 <td><a href="<?php echo $wpcp_current_page;?>&what=delete&id=<?php echo $row_all['id'];?>">Delete</a></td>

</tr>
<?php
}
?>
</tbody>
</table>
<?php
break;
}
case "edit":{
    ?>
    <?php    
    
    $msg = "";
    
    //save data
    if(isset($_POST['link_id'])){
        $wplm_link_type = trim($_POST['link_type']);
        $wplm_link_id = (int) $_POST['link_id'];
        $wplm_link_target = trim($_POST['link_target']);
        $wplm_start_date = trim($_POST['start_date']);
        $wplm_end_date = trim($_POST['end_date']);
        $wplm_link_owner_name = trim($_POST['link_owner_name']);
        $wplm_link_owner_email = trim($_POST['link_owner_email']);
        $wplm_only_home = isset($_POST['is_home_only']) ? 1 : 0;
        $wplm_proceed = true;
        if($wplm_link_type == 'link'){
             $wplm_blogrole_link = trim($_POST['blogrole_link']);
             $wplm_blogrole_anchor = trim($_POST['blogrole_anchor']);
             $wplm_mumble_text = '';
            if($wplm_blogrole_link =='' || $wplm_blogrole_anchor == '' || $wplm_start_date == '' || $wplm_end_date == '' || $wplm_link_owner_name == '' || $wplm_link_owner_email == '') {
                $wplm_proceed = false;
                $msg = "Please fill all the fields";
                
            }
            
        }
        else{
            $wplm_mumble_text = trim($_POST['mumble_text']);
            $wplm_blogrole_link = '';
            $wplm_blogrole_anchor = $wplm_mumble_text;
           if($wplm_mumble_text == '' || $wplm_start_date == '' || $wplm_end_date == '' || $wplm_link_owner_name == '' || $wplm_link_owner_email == '') {
                $wplm_proceed = false;
                $msg = "Please fill all the fields";
                
            }
        }


        if($wplm_proceed){
            $from_dates = explode("/",$wplm_start_date);
            $to_dates = explode("/",$wplm_end_date);
            if(!wplm_is_valid_date($from_dates[0],$from_dates[1],$from_dates[2]) || !wplm_is_valid_date($to_dates[0],$to_dates[1],$to_dates[2])){
                $wplm_proceed = false;
                $msg = "Invalid Date Format";
            }
        }
        global $table_prefix;
        if($wplm_proceed){
            $save_sql = "UPDATE ".$table_prefix."wplm SET
                        href = '$wplm_blogrole_link',
                        anchor = '$wplm_blogrole_anchor',
                        type = '$wplm_link_type',
                        only_home = '$wplm_only_home',
                        target = '$wplm_link_target',
                        start_date = '$wplm_start_date',
                        end_date = '$wplm_end_date',
                        link_owner_name = '$wplm_link_owner_name',
                        link_owner_email = '$wplm_link_owner_email' WHERE id = $wplm_link_id";
            if(mysql_query($save_sql)){
                $msg = "<div class='updated'><p><strong>Link Updated</strong></p></div>";
                }
       }
                
}
        
    
    
    
    
    
    
//load current mumble
$id = (int) $_GET['id'];
$sql_edit = "SELECT * FROM ".$table_prefix."wplm WHERE id = ".$id;
$result_edit = mysql_query($sql_edit);
if(mysql_num_rows($result_edit) == 0)
    die("Invalid Request");    
 $row_edit = mysql_fetch_assoc($result_edit);   
 newads();
 ?>
 
 <form  method="post" name="linkform">
<input type="hidden" name="link_id" value="<?php echo $id;?>">
<table class="form-table">

<caption>

<?php echo $msg;?>

</caption>

<tbody>



<tr class="tr">

    <td width="200"><strong><input onclick="javascript:toggle_link_option('blogroll')" type="radio" value="link" name="link_type" 
    <?php
    if($row_edit['type'] == 'link'){
        echo "checked";
    }
    ?>
    >Blog Roll:</strong></td>

    <td class="first">&nbsp;
    
  </td>

</tr>
<tr class="tr">

    <td width="200">Link URL*<br />(You have to add the WPLM Links Widget from the Appearance> Widgets Section to show the link in your sidebar)</td>

    <td class="first">
     <input type="text" <?php
     if($row_edit['type'] != 'link'){
         echo "disabled";
     }
     ?> class="regular-text" value="<?php echo $row_edit['href']?>" id="blogrole_link" name="blogrole_link"> 
    
     </td>

</tr>
<tr class="tr">

    <td width="200">Anchor Text*</td>

    <td class="first">
     <input <?php
     if($row_edit['type'] != 'link'){
         echo "disabled";
     }
     ?> type="text" class="regular-text" value="<?php
     if($row_edit['type'] == 'link')
        echo $row_edit['anchor'];      
      ?>" id="blogrole_anchor" name="blogrole_anchor">    
     </td>

</tr>


<tr class="tr">

    <td width="200"><strong><input onclick="javascript:toggle_link_option('mumble')" type="radio" value="mumble" name="link_type"  <?php
    if($row_edit['type'] == 'mumble'){
        echo "checked";
    }
    ?>>Mumble*</strong></td>

    <td class="first">&nbsp;
    
  </td>

</tr>

<tr class="tr">

        <td width="200">In this text box you can add a HTML link with a sentence. Eg. Having fun with new &lt;a href="http://www.yourlinkhere.com" target="_blank"&gt;iPhone games&lt;/a&gt;.
(You have to add the WPLM Mumbles Widget from the Appearance> Widgets Section to show the Mumble in your sidebar)</td>

    <td class="first">
     <textarea <?php
     if($row_edit['type'] == 'link'){
         echo "disabled";
     }
     ?> class="code"  id="mumble_text" cols="40" rows="10" name="mumble_text"><?php
     if($row_edit['type'] == 'mumble')
      echo $row_edit['anchor']?></textarea>    
     </td>

</tr>

<tr class="tr">

    <td width="200"><strong>Link Attributes</strong></td>

    <td class="first">
    <input type="checkbox" name="is_home_only" id="is_home_only" value="" <?php
    if($row_edit['only_home'] == 1){
        echo "checked";
    }
    ?>>Display Only Home Page<BR>
    <input type="radio" name="link_target" id="link_target" value="_blank" <?php   
    if($row_edit['target'] == '_blank'){
        echo "checked";
    }
    ?>>New Window or Tab<BR>
    <input type="radio" name="link_target" id="link_target" value="_top" <?php
    if($row_edit['target'] == '_top'){
        echo "checked";
    }
    ?>>Current Window or Tab<BR>
  </td>

</tr>

<tr class="tr">

    <td width="200"><strong>Start Date[YYYY/MM/DD]</strong></td>

    <td class="first">
  
     <input type="text" size="15" id="start_date" name="start_date" value="<?php echo str_replace("-","/",$row_edit['start_date']);?>" >    
     *</td>

</tr>
<tr class="tr">

    <td width="200"><strong>End Date[YYYY/MM/DD]</strong></td>

    <td class="first">
     <input type="text" size="15"  value="<?php echo str_replace("-","/",$row_edit['end_date']);?>" id="end_date" name="end_date">    
     *</td>

</tr>
<tr class="tr">

    <td width="200"><strong>Link Owner Name</strong></td>

    <td class="first">
     <input type="text" class="regular-text" value="<?php echo $row_edit['link_owner_name']?>" id="link_owner_name" name="link_owner_name">    
     *</td>

</tr>
<tr class="tr">

    <td width="200"><strong>Link Owner Email</strong></td>

    <td class="first">
     <input type="text" class="regular-text" value="<?php echo $row_edit['link_owner_email']?>" id="link_owner_email" name="link_owner_email">    
     *</td>

</tr>
<tr>
<td>&nbsp;</td>
    <td class="first">


    <input type="submit" value="Save" class="button">

    

    </td>

    

</tr>

</tbody>
</table>
</form>

<script language="javaScript">
function toggle_link_option(what){
    if(what == 'blogroll'){
        //enable element
        document.linkform.blogrole_link.disabled = false;
        document.linkform.blogrole_anchor.disabled = false;
        document.linkform.mumble_text.disabled = true;
    }
    else{
        document.linkform.blogrole_link.disabled = true;
        document.linkform.blogrole_anchor.disabled = true;
        document.linkform.mumble_text.disabled = false;
    }
}
</script>
    
    <?php
    break;
}
}
?>