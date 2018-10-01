<?php
include_once('../lib/config.inc.php');
$Db = new MySqlConn;
$sql="SELECT person_id,cid from hrd_person
 WHERE cid='".$_POST['cid']."'";
$result=$Db->query($sql);
$a_data=array();
foreach ($result as $row){
       array_push($a_data,$row);	
       
   }
echo json_encode($row);
?>