<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

if(isset($_GET["mode"])){
  $p_code=$_GET["mode"];

  $sql="SELECT * from `package` where `p_code` = '$p_code';";
  $member_sql="SELECT * from `member` where `id` = '$id';";

}
// 쿼리문실행문장

$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$p_name=$row['p_name'];
$p_dp_date=$row['p_dp_date'];
$p_dp_time=$row['p_dp_time'];
$p_arr_time=$row['p_arr_time'];
$p_pay=$row['p_pay'];
$p_main_img_copy1=$row['p_main_img_copy1'];
$p_main_img_copy2=$row['p_main_img_copy2'];
$p_main_img_copy3=$row['p_main_img_copy3'];
$p_arr_mt=$row['p_arr_mt'];
$p_period=$row['p_period'];
$p_detail_content=$row['p_detail_content'];
$timestamp = strtotime("$p_dp_date +$p_period days");
$p_arr_date1 = date('y-m-d', $timestamp);
$p_arr_date2 = "20".$p_arr_date1;

$yoil = array("일","월","화","수","목","금","토");
$day = $yoil[date('w', strtotime($p_dp_date))];
$day2 = $yoil[date('w', strtotime($p_arr_date2))];

$dp_date=explode("-", $p_dp_date);
$dp_date2=explode("-", $p_arr_date2);



$member_result=mysqli_query($conn,$member_sql);
$member_row=mysqli_fetch_array($member_result);
$name=$member_row['name'];
$hp1=$member_row['hp1'];
$hp2=$member_row['hp2'];
$email=$member_row['email'];
$hp=$hp1.$hp2;
$email=explode("@", $email);

 ?>
