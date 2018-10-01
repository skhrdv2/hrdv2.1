<?php
include_once('../lib/config.inc.php');
$Db = new MySqlConn;

if(isset($_POST['show_department'])){  //แสดง department ทั้งหมด
$sql="SELECT * FROM hrd_department";
$result=$Db->query($sql);
   //วนลูปแสดงข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
   foreach($result as $row) {
                
    //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
    $json_result[] = [
        'id'=>$row['department_id'],
		'name'=>$row['department_name'],
		
    ];
   
   }
   echo json_encode($json_result);
}

	if(isset($_POST['department_swow_sub'])){

	
		$sql = "SELECT * FROM hrd_department_sub    
		WHERE department_id =  '".$_POST['department_id']."'
		
		";
		
		//ประมวณผลคำสั่ง SQL
		$result = $Db->query($sql);
            foreach($result as $row) {
				
				//เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
				$json_result[] = [
					'id'=>$row['department_sub_id'],
					'name'=>$row['department_sub_name'],
				];
        } 
        echo json_encode($json_result);
	}

