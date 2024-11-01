<?php
//disable direct access
if(!defined('DB_NAME'))
    die("Direct Access To This File Is Denied");
    
    
    
    $msg = "";
    
    //save data
    if(isset($_POST['link_type'])){
        $wplm_link_type = trim($_POST['link_type']);
       
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
            $save_sql = "INSERT INTO ".$table_prefix."wplm VALUES('','$wplm_blogrole_link','$wplm_blogrole_anchor','$wplm_link_type','$wplm_only_home','$wplm_link_target','$wplm_start_date','$wplm_end_date','$wplm_link_owner_name','$wplm_link_owner_email','0','0')";
            if(mysql_query($save_sql)){
                $msg = "Link Added";
                }
       }
                
}
        
    
    
    
    
    
    
    
    
 ?>
 <div class="icon32" id="icon-options-general"><br/></div>

<h2>Add Link</h2>

<BR />
<?php 
//require_once('wplm_ads.php');
newads();
?>
 <form  method="post" name="linkform">

<table class="form-table">

<caption>
<div class="updated">
<p><strong>
<?php echo $msg;?>
</strong></p>
</div>
</caption>

<tbody>



<tr class="tr">

    <td width="200"><strong><input onclick="javascript:toggle_link_option('blogroll')" type="radio" value="link" name="link_type" checked>Blog Roll:</strong></td>

    <td class="first">&nbsp;
    
  </td>

</tr>
<tr class="tr">

    <td width="200">Link URL*<br />(You have to add the WPLM Links Widget from the Appearance> Widgets Section to show the link in your sidebar)</td>

    <td class="first">
     <input type="text" class="regular-text" value="" id="blogrole_link" name="blogrole_link">
    
     </td>

</tr>
<tr class="tr">

    <td width="200">Anchor Text*</td>

    <td class="first">
     <input type="text" class="regular-text" value="" id="blogrole_anchor" name="blogrole_anchor">    
     </td>

</tr>


<tr class="tr">

    <td width="200"><strong><input onclick="javascript:toggle_link_option('mumble')" type="radio" value="mumble" name="link_type">Mumble*</strong></td>

    <td class="first">&nbsp;
    
  </td>

</tr>

<tr class="tr">

    <td width="200">In this text box you can add a HTML link with a sentence. Eg. Having fun with new &lt;a href="http://www.yourlinkhere.com" target="_blank"&gt;iPhone games&lt;/a&gt;.
(You have to add the WPLM Mumbles Widget from the Appearance> Widgets Section to show the Mumble in your sidebar)</td>

    <td class="first">
     <textarea disabled class="code" id="mumble_text" cols="40" rows="10" name="mumble_text"></textarea>    
     </td>

</tr>

<tr class="tr">

    <td width="200"><strong>Link Attributes</strong></td>

    <td class="first">
    <input type="checkbox" name="is_home_only" id="is_home_only" value="">Display Only Home Page<BR>
    <input type="radio" name="link_target" id="link_target" value="_blank">New Window or Tab<BR>
    <input type="radio" name="link_target" id="link_target" value="_top">Current Window or Tab<BR>
  </td>

</tr>

<tr class="tr">

    <td width="200"><strong>Start Date[YYYY/MM/DD]*</td>
<td class="first">
     <input type="text" size="15"  value="" id="start_date" name="start_date">    
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>End Date[YYYY/MM/DD]*</strong></td>

    <td class="first">
     <input type="text" size="15"  value="" id="end_date" name="end_date">    
     </td>

</tr>
<tr class="tr">

    <td width="200"><strong>Link Owner Name*</strong></td>

    <td class="first">
     <input type="text" class="regular-text" value="" id="link_owner_name" name="link_owner_name">    
     </td>

</tr>
<tr class="tr">

    <td width="200"><strong>Link Owner Email*</strong></td>

    <td class="first">
     <input type="text" class="regular-text" value="" id="link_owner_email" name="link_owner_email">    
     </td>

</tr>
<tr>
<td>* = Required Field</td>
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
    