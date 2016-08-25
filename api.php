<?php ob_start();
//$er = error_reporting(0);
$servername = "localhost";
$username = "jobsglob_nle";
$password = "campaign";
$database= "jobsglob_nle";
$conn=mysql_connect($servername, $username, $password);
mysql_select_db($database);

date_default_timezone_set('America/Los_Angeles');

$json =$_POST['json'];
$dataget = json_decode($json);
$date=date('Y-m-d H:i:s');
$md5=md5($data[email]);
foreach($dataget as $data) {
 $email=$data->email;
$is_active=$data->is_active;
$emailcount=mysql_query("select email from phplist_user_user where email='$email'");

$emailcountot=mysql_num_rows($emailcount);

if($emailcountot<1) {

$dd=mysql_query("insert into phplist_user_user(`email`,`confirmed`,`entered`,`modified`,`uniqid`,`disabled`)values('$email','1','$date','$date','$md5','$is_active')");
$userid=mysql_insert_id();
$userattribute=mysql_query("select * from phplist_user_attribute");
while($phplist_user_attribute=mysql_fetch_array($userattribute)){
echo $phplist_user_attribute['id'];
if($phplist_user_attribute['id']=='5') {
$attribute_val=$data->last_name;
}
if($phplist_user_attribute['id']=='6') {
$attribute_val=$data->first_name;
}

if($phplist_user_attribute['id']=='7') {
$attribute_val=$data->gender;
}
if($phplist_user_attribute['id']=='8') {
$attribute_val=$data->position;
}
if($phplist_user_attribute['id']=='9') {
$attribute_val=$data->jobseeker->total_exp;
}
if($phplist_user_attribute['id']=='10') {
$indname=$data->jobseeker->current_work->industry;
$industryattribute=mysql_query("select * from phplist_listattr_industry1 where name ='$indname'");
$phplist_industry=mysql_fetch_array($industryattribute);

$attribute_val=$phplist_industry[id];


}
if($phplist_user_attribute['id']=='11') {
$attribute_val=$data->jobseeker->country;
}
if($phplist_user_attribute['id']=='12') {
$attribute_val=$data->jobseeker->city;
}
if($phplist_user_attribute['id']=='13') {
$attribute_val=$data->birthdate;
}
if($phplist_user_attribute['id']=='14') {
$attribute_val=$data->jobseeker->nationality;
}


mysql_query("insert into phplist_user_user_attribute(`attributeid`,`userid`,`value`)values('$phplist_user_attribute[id]','$userid','$attribute_val')");


}
echo 'record insert';

}

}