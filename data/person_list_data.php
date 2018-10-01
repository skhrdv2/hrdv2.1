<?php
include_once('../lib/config.inc.php');
$Db = new MySqlConn; 
if($_POST['req']=='req'){
if(isset($_POST['person_status'])){
    $person_statusl=$_POST['person_status'];
}else{
    $person_status='1';
}
$sql="SELECT ps.*,CONCAT(pn.prename_name,ps.fname,' ',ps.lname) AS fullname,YEAR( FROM_DAYS( DATEDIFF( NOW( ) ,birthday ) ) ) as agey,pst.position_name,dp.department_name,ds.department_sub_name,pn.prename_name,
if(DATE_FORMAT(ps.birthday,'%m')<10 , year(ADDDATE(ps.birthday,INTERVAL 60 YEAR))+543 , 
year(ADDDATE(ps.birthday,INTERVAL 60 YEAR))+544) as y_exp ,ps.startwork_date,hps.person_status_name,
CONCAT(TIMESTAMPDIFF(YEAR,ps.startwork_date,CURDATE())) AS age_work,hpg.position_groups_name
FROM hrd_person ps 
      LEFT OUTEr JOIN hrd_prename pn ON pn.prename_id = ps.prename_id  
      LEFT OUTER JOIN hrd_position pst ON pst.position_id = ps.position_id
      LEFT OUTER JOIN hrd_department dp ON dp.department_id = ps.department_id
      LEFT OUTER JOIN hrd_department_sub ds ON ds.department_sub_id = ps.department_sub_id
	  LEFT OUTER JOIN hrd_position hp ON ps.position_id = hp.position_id   
      LEFT OUTER JOIN hrd_position_groups hpg ON hp.position_groups_id = hpg.position_groups_id 
      LEFT OUTER JOIN hrd_person_status hps ON hps.person_status_id=ps.person_status_id
     
";

if(isset($_POST["is_department"]) & isset($_POST["is_department_sub"]))
{
 $sql .= " WHERE ps.department_id = '".$_POST["is_department"]."' AND ps.department_sub_id ='".$_POST["is_department_sub"]."'";
}else if(isset($_POST["is_department"])){
    $sql .= " WHERE ps.department_id = '".$_POST["is_department"]."'";
}

//$sql.="AND ps.person_status_id=".$person_status;" ";

                $sql = $Db->query($sql,'');
               $data = array();
        foreach ($sql as $row ) {
            $data[] = $row ;
        }
                $response = array(
      
        "data" => $data
    );	
                echo json_encode($response);   
}       
     ?>
