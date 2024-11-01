<?php
//protect direct access to this plugin
if(!defined('DB_HOST')){
    die("Direct Access Restricted");
}
?>
<div class="icon32" id="icon-options-general"><br/></div>
<h2>WP Link Management Setup</h2>
<BR />
<?php 
//require_once('wplm_ads.php');
newads();
?>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options') ?>
<table class="form-table">
<caption>
 
</caption>

<tbody>



<tr class="tr">

    <td width="200"><strong>Admin Email:</strong></td>
    <td class="first">
    <?php
    $wplm_admin_email = get_option('wplm_admin_email') == '' ? get_option('admin_email') : get_option('wplm_admin_email');
    ?>
   <input type="text" class="regular-text" value="<?php echo $wplm_admin_email;?>" id="wplm_admin_email" name="wplm_admin_email">
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>Days before the link expires:</strong><br />Add the number of days before you want to send email notification to the link owner about their link expired, eg. 10</td>
    <td class="first">
   <input type="text" class="regular-text" value="<?php $daysbefore = get_option('wplm_days_before'); if ($daysbefore =='') {$daysbefore=10;} echo $daysbefore; ?>" id="wplm_days_before" name="wplm_days_before">
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>Link Email Options:</strong></td>
    <td class="first">
   <input type="checkbox" <?php if(get_option('wplm_is_email_admin_owner') == 1){
       echo " checked ";       
   }
 ?> name="wplm_is_email_admin_owner" id="wplm_is_email_admin_owner" value="1">Email Admin and Link Owner<BR>
   <input type="checkbox" <?php if(get_option('wplm_is_email_admin_after_expire') == 1){
       echo ' checked ';       
   }?> name="wplm_is_email_admin_after_expire" id="wplm_is_email_admin_after_expire" value="1">Email Admin after link expire<BR>
 <input type="checkbox" <?php if(get_option('wplm_is_email_owner_after_expire') == 1){
       echo " checked ";       
   }
 ?> name="wplm_is_email_owner_after_expire" id="wplm_is_email_owner_after_expire" value="1">Email Link Owner after link expire<BR>
 <input type="checkbox" <?php if(get_option('wplm_is_delete_after_expire') == 1){
       echo " checked ";       
   }
 ?> name="wplm_is_delete_after_expire" id="wplm_is_delete_after_expire" value="1">Automatically Delete links after expire date<BR>
 
     </td>
</tr>

<tr class="tr">

    <td width="200"><strong>Link Expiring Email Notice for Link Owner:</strong></td>
    <td class="first">
    <b>Available Merge Fields</b><Br>
    Admin Email:{admin_email}<BR>
    Link Owner Email:{linkowner_email}<BR>
    Link Owner Name:{linkowner_name}<BR>
    Expire Date:{expire_date}<BR>
    Link URL:{link_url}<BR>
    Site URL:{site_url}<BR>
   <textarea  id="wplm_expiring_email_format_owner" cols="60" rows="10" name="wplm_expiring_email_format_owner"><?php $wplm_expiring_email_format_owner = get_option('wplm_expiring_email_format_owner'); if ($wplm_expiring_email_format_owner == ""){echo "Hi {linkowner_name},

You have an ad placed on our site and its about to expire!

Your Ad for {site_url} will be removed on {expire_date}. We would like you to keep advertising with us so drop us an email at: {admin_email} and we can process another advertising slot for you.

Kind Regards,
{admin_email}";} else {echo $wplm_expiring_email_format_owner;} ?></textarea>
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>Link Expiring Email Notice for Admin:</strong></td>
    <td class="first"> 
   <textarea  id="wplm_expiring_email_format_admin" cols="60" rows="10" name="wplm_expiring_email_format_admin"><?php $wplm_exp_admin = get_option('wplm_expiring_email_format_admin'); if ($wplm_exp_admin == ""){ echo "Hi Admin,

An ad placed on our site is about to expire!

The Ad for {site_url} will be removed on {expire_date}. You can contact the client by email: {linkowner_email} their name is: {linkowner_name} , and their site is: {site_url}

Kind Regards,
WPLM Plugin";} else echo $wplm_exp_admin; ?></textarea>
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>Link Expired Email Notice for Owner:</strong></td>
    <td class="first"> 
   <textarea  id="wplm_expired_email_format_owner" cols="60" rows="10" name="wplm_expired_email_format_owner"><?php $wplm_expired_email_format_owner = get_option('wplm_expired_email_format_owner'); if ($wplm_expired_email_format_owner == ""){echo "Hi {linkowner_name},

You have an ad placed on our site and unfortunately it HAS EXPIRED!

Your Ad for {site_url} was removed on {expire_date}. We would like you to keep advertising with us so drop us an email at: {admin_email} and we can process another advertising slot for you.

Kind Regards,
{admin_email}";} else {echo $wplm_expired_email_format_owner;} ?></textarea>
     </td>
</tr>
<tr class="tr">

    <td width="200"><strong>Link Expired Email Notice for Admin:</strong></td>
    <td class="first"> 
   <textarea  id="wplm_expired_email_format_admin" cols="60" rows="10" name="wplm_expired_email_format_admin"><?php $wplm_expired_email_format_admin = get_option('wplm_expired_email_format_admin'); if ($wplm_expired_email_format_admin == ""){echo "Hi Admin,

An ad placed on our site HAS EXPIRED!

The Ad for {site_url} will be removed on {expire_date}. You can contact the client by email: {linkowner_email} their name is: {linkowner_name} , and their site is: {site_url}

Kind Regards,
WPLM Plugin";} else {echo $wplm_expired_email_format_admin;} ?></textarea>
     </td>
</tr>
<tr class="tr">

    <td width="200">&nbsp;</td>
    <td class="first"> 
  <p><input type="submit" name="Submit" value="Update Options" /></p>
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="page_options" value="wplm_admin_email,wplm_days_before,wplm_is_email_admin_owner,wplm_is_email_admin_after_expire,wplm_is_email_owner_after_expire,wplm_is_delete_after_expire,wplm_is_delete_after_expire,wplm_expiring_email_format_owner,wplm_expiring_email_format_admin,wplm_expired_email_format_owner,wplm_expired_email_format_admin" />
     </td>
</tr>

</tbody>
</table>