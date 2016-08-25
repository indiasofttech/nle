<?php  

# load all required files

require_once dirname(__FILE__).'/../config/config.php';
 if ($database_host && $database_user)
    $db = @mysql_connect($database_host, $database_user, $database_password);
  $errno = mysql_errno();
  if (!$errno) {
    $res = mysql_select_db($database_name,$db);
    $errno = mysql_errno();
  }
  
  
  if($_GET[page]=='findbyatt') {
$phplist_user_attribute=mysql_query("select * from phplist_user_attribute where id='$_GET[attsid]'");
$user_attribute=mysql_fetch_array($phplist_user_attribute);
 $tablename=$user_attribute[tablename];
if($user_attribute[type]=='select') {
$phplist_attribute=mysql_query("select * from phplist_listattr_".$tablename);

 ?>  <select  name="find" > <? while($attribute=mysql_fetch_array($phplist_attribute)) { ?>  <option value="<?=$attribute['name']?>"> <?=$attribute['name']?></option> <?php }?> </select><?php 
 
  }elseif($user_attribute[type]=='radio') {
 while($attribute=mysql_fetch_array($phplist_attribute)) { ?>  <input name="find" type="radio"  value="<?=$attribute['name']?>"> <?=$attribute['name']?> <?php }
  
  
   }elseif($user_attribute[type]=='textline') {
   ?>  <input type="text" name="find"  value="" size="30"> 
   <?  }else {
	?> 
	
	 <input type="text" name="find"  value="" size="30">  <?
	
	  }
	  
	  }
	  
	  elseif($_GET[page]=='smtplist') {
	  $query1 = "update  phplist_smtp_list set status='0'";
	      mysql_query($query1);
	     $query = "update  phplist_smtp_list set status='1' where id='$_GET[id]'";
	      mysql_query($query);
	  }
  ?>