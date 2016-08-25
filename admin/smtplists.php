<?php $adminid=$_SESSION[logindetails][id];
require_once dirname(__FILE__).'/accesscheck.php';
if (!defined('PHPLISTINIT')) {
    exit;
}

if ($_SERVER['REQUEST_METHOD']=="POST" and $_POST[smtp])  {
    if ($_POST[id]!=NULL) {
         $query = "update  phplist_smtp_list set mailhost='$_POST[mailhost]',smtpuser='$_POST[smtpuser]',smtppassword='$_POST[smtppassword]',smtpport='$_POST[smtpport]',smtpsecure='$_POST[smtpsecure]' where id='$_POST[id]'";
        $result = Sql_query($query);
        $userid = Sql_insert_id();
		echo ActionResult($GLOBALS['I18N']->get('SMTP Seting Updated'));
    }
	else {
	
	 $query = "insert into phplist_smtp_list (user_id,mailhost,smtpuser,smtppassword,smtpport,smtpsecure) values('$adminid','$_POST[mailhost]','$_POST[smtpuser]','$_POST[smtppassword]','$_POST[smtpport]','$_POST[smtpsecure]')";
        $result = Sql_query($query);
        $userid = Sql_insert_id();
		echo ActionResult($GLOBALS['I18N']->get('SMTP Seting added'));

	}
	echo "<script>window.location='?page=smtplists';</script>";
}


if(isset($_GET['del'])) { $smtp_req = Sql_Query("delete  from phplist_smtp_list  where id = '$_GET[del]'"); 	echo "<script>window.location='?page=smtplists';</script>";


  }

 
 if(isset($_GET['edit'])) { $smtp_req = Sql_Query("select * from phplist_smtp_list  where id = '$_GET[edit]'");
$smtpdata = Sql_Fetch_Array($smtp_req);  }
?>

<form action="" method="post" enctype="multipart/form-data"> <input type="hidden" name="id" value="<?=$smtpdata[id]?>" />
<table width="100%" >
 <tr><td>MAILER HOST</td><td><input type="text" required   value="<?=$smtpdata[mailhost]?>" name="mailhost"  /></td> <td>SMTP Port</td><td><input type="text" required name="smtpport"  value="<?=$smtpdata[smtpport]?>"  /></td></tr>

<tr><td>SMTP User</td><td><input type="text" required name="smtpuser" value="<?=$smtpdata[smtpuser]?>"   /></td><td>SMTP Password</td><td><input type="text" required name="smtppassword"  value="<?=$smtpdata[smtppassword]?>"  /></td></tr>

<tr><td>SMTP Secure </td><td><input type="text" required name="smtpsecure"  value="<?=$smtpdata[smtpsecure]?>"  /></td><td><input type="submit" value="Submit" required name="smtp"  /></td><td></td></tr>


 </table></form>
 
 
 
 
 
 <div class="content" >
 <table class="listing" width="100%" >
<tr class="rowelement"><th>Maller Host</th><th>SMTP User</th><th>SMTP Password</th><th>SMTP Port</th><th>SMTP Secure</th><th>Default</th><th>Action</th></tr>

<?php  $att_req = Sql_Query("select * from phplist_smtp_list  where user_id = '$adminid'");
while ($row = Sql_Fetch_Array($att_req)) { ?>
<tr class="row1"><td><div align="center">
  <?=$row[mailhost]?>
</div></td><td><div align="center">
  <?=$row[smtpuser]?>
</div></td><td><div align="center">
  <?=$row[smtppassword]?>
</div></td><td><div align="center">
  <?=$row[smtpport]?>
</div></td><td><div align="center">
  <?=$row[smtpsecure]?>
</div></td><td><div align="center">
 <input type="radio" name="status[]"  class="makedefaltsmtp" <?php if($row[status]==1) { ?> checked="checked" <? } ?>  value="<?=$row[id]?>"  />
</div></td><td><a href="?page=smtplists&edit=<?=$row[id]?>" >  Edit</a><a onclick="return confirm('Are you sure Delete This SMTP Seting ?')" href="?page=smtplists&del=<?=$row[id]?>" >  Delete</a></td></tr>

<?php }?>
 </table>
 </div>
 
 
 