<?
include("../include/db1.php");// Include DB connection
include("../include/functions.php"); // Include DB functions 
include("../phpMailer/class.phpmailer.php");
include("../phpMailer/class.smtp.php");

if(isset($_REQUEST['posted']))
{
    //mysql_connect("localhost",$dbuname,$dbpsw) or die("cannot connect to database"); 
	//mysql_select_db(DBMAINDB) or die("cannot select the database"); // Select DB

	//Get Company URL from office_master
	$office_qry = select_single_record("office_master","office_id,database_name,from_email_id","office_id='$ofidd'"); 
	$office_id     = $office_qry["office_id"];
	$database_name = $office_qry["database_name"];
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$ssmtp = 'smtp.mailgun.org';  
	//echo $ssmtp; die;                                 // send via SMTP
	if($ssmtp == "smtp.mailgun.org")
	{
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	}
	$mail->Host     = $ssmtp; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	/*$mail->Username = $uemail;*/  // SMTP username
	$mail->Username = 'postmaster@skiper.us'; 
	/*$mail->Password = $upsw;*/ // SMTP password
	$mail->Password = 'c4e7e9bd358da6f279be6efd398dff8f-acb0b40c-2deff2c9';
	
	$mail->Port 	= '587'; // SMTP Port
	
	 //To connect ls_1 database again here
     //mysql_connect("localhost",$dbuname,$dbpsw) or die("cannot connect to database"); 
	 //mysql_select_db($database_name)or die(mysql_error()); 

	//To request the user 
	$user = $_REQUEST['user']; 
	$total = totalrows("user_master","*","username='$user'");  
	  
	if($total > 0)
	{
	    $getpass_qry 	= select_single_record("user_master","*","username='$user'"); 
		//To connect again the database of ls_main
		//mysql_connect("localhost",$dbuname,$dbpsw) or die("cannot connect to database"); 
 		//mysql_select_db(DBMAINDB)or die(mysql_error());	
	    $mailcontent_qry 	= select_single_record("mail_settings","*","Mail_Id='2'");  
		$Password	 		= $getpass_qry["Password"];
		$email		 		= $getpass_qry["Email_ID"]; 
		$subject			=$mailcontent_qry["Mail_Subject"];       
		$content			=$mailcontent_qry["Mail_Content"];
		$content = str_replace("###USERNAME###",$user,$content);
		$content = str_replace("###USERID###",$user,$content);    
		$content = str_replace("###PASSWORD###",$Password,$content);
		$mail->WordWrap = 500;
		$mail->IsHTML(true);
		$from_email_id = '24.7plumbingservice@gmail.com';  
		$mail->From     = $from_email_id;
		$mail->FromName = "Administrator";
		$mail->AddAddress($email);               // optional name
		$mail->Subject  =  $subject;
		$mail->Body     =  $content;
		$mail->Send();
		redirect("forgotpassword.php?msg=success");
	}
	else
	{
		// Display Error Message On Index page
		redirect("forgotpassword.php?msg=fail"); 
	}
} 

if($_REQUEST['msg'] == "fail" ) 
{
 $msg = "Invalid Username. Try Again!"; 
} 
elseif($_REQUEST['msg'] == "success" ) 
{
 $msg = "Password has been sent to your Email."; 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$off_title?></title>
<meta name="generator" content="WordPress 2.2.2"><!-- leave this for stats --> 
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
	<link rel="stylesheet" href="../css/dropmenu.css" type="text/css" media="screen">
	<style type="text/css">	::placeholder {
    color: grey;
}
.login-sms {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    position: absolute;
    margin-top: 70px;
    color: #559BF5 !important;
    margin-left: 105px;
    font-weight: bold;
    text-align: center;
    padding: 5px;
}
</style>
    	</head>
<script language="javascript" src="../script/formvalidation.js" type="text/javascript"></script>
		
<body style="background-color: #569cf5 !important">
<div id="wrapperSmalllogin">
<!-- begin navigation -->
<div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2" align="center" valign="middle" class="loginpad">
      
	<form id="form1" name="form1" method="post">		
	<input type="hidden" name="posted" id="posted" value="1"   />
	<img src="./images/skiper-logo.PNG" width="100px" style="margin-bottom: -50px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="login-bg2">
  <tr>
    <td  valign="bottom" id="login-text5">&nbsp;</td>
    <td height="20" valign="bottom">&nbsp;</td>
  </tr>
<?php 
if($msg <> "")
{
?>  
  <tr>
    <td height="28" colspan="2" align="center"  valign="bottom" class="login-sms" id="login-text3"><?=$msg?></td>
  </tr>
<? } ?>  
  <!-- <tr>
    <td height="31" colspan="2"  valign="bottom" id="head-text">FORGOT PASSWORD</td>
    </tr> -->
    <tr><td class="form_tittle" colspan="2"><h2>Forgot Password ?</h2></td></tr>
  <tr>
    <!-- <td  align="left" valign="middle" id="login-text">User Name</td> -->
    <td height="60" align="left" valign="middle"><input type="text" name="user" id="user" placeholder="Username"/></td>
  </tr>
  <!-- <tr>
    <td >&nbsp;</td>
    <td height="20" align="left" valign="top" id="login-text"><div align="left">Forgot My Password</div></td>
  </tr> -->
  <tr>
    <td height="20" align="left" valign="middle">
	<input type="submit" src="../images/btn_send.gif" value="Send" onclick="javascript:return validate();"/>
	<input type="submit" src="../images/btn_back.gif" value="Back" onClick="javascript: window.location='index.php'; return false;"/>

	</td> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
</form>

</td>
      <td style="background-image: url(../images/login_right_bg.jpg); background-repeat: repeat-y"></td>
    </tr>
   <!--  <tr>
      <td width="56" align="left" valign="top"><img src="../images/login_bottom_left_curve.jpg" width="56" height="49" border="0" /></td>
      <td colspan="2" style="background-image: url(../images/login_bottom_bg.jpg); background-repeat: repeat-x;"></td>
      <td align="left" valign="top"><img src="../images/login_bottom_right_curve.jpg" border="0" /></td>
    </tr> -->
  </table>
</div>
  <!-- end navigation -->
<!-- <div>
  <div align="center">Copyright © 2008 <a href="#">locksmith.com</a></div> 
</div>
 --></div><!-- END BODY WRAPPER -->
	 
</body></html>

<script language="javascript">
function validate()
{
	if(isCheckAlert(document.form1.user,"Enter the User Name")==false)
				{return false;}
	
}
				
</script>
 
 