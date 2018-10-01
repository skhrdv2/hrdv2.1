<?php 
session_start();

?>
<?php
	$intUsername = 0;
	$strSessionID = session_id();
	$ip =GetHostByName($REMOTE_ADDR);
	$comname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	if(isset($_SESSION['loginname']))
	{
		$intUsername = $_SESSION['loginname'];
	}
	  $sql = "INSERT INTO hrd_useronline (sessionid,username,Onlinelasttime,ip,comname) VALUES ('$strSessionID','$intUsername',NOW(),'$ip','$comname') ON DUPLICATE KEY UPDATE username = '$intUsername',Onlinelasttime = NOW()";
  	  $query = mysqli_query($db_report,$sql);

  	  $intRejectTime = 3; // Minute
      $sql = "DELETE FROM hrd_useronline WHERE DATE_ADD(Onlinelasttime, INTERVAL $intRejectTime MINUTE) <= NOW() ";
      $query = mysqli_query($db_report,$sql);

      $intGuestOnline = 0;
  	  $sql = "SELECT COUNT(sessionid) AS OnlineGuest FROM hrd_useronline WHERE sessionid = '0' ";
      $query = mysqli_query($db_report,$sql);
      if($query)
      {
      $objResult = mysqli_fetch_array($query,MYSQLI_ASSOC);
      $intGuestOnline = $objResult["OnlineGuest"];
      }
      $intMemberOnline = 0;
  	  $sql = "SELECT COUNT(sessionid) AS OnlineMember FROM hrd_useronline WHERE sessionid != '0'  ";
      $query = mysqli_query($db_report,$sql);
      if($query)
      {
      $objResult = mysqli_fetch_array($query,MYSQLI_ASSOC);
      $intMemberOnline = $objResult["OnlineMember"];
      }
     // @mysqli_close($db_report);

?>