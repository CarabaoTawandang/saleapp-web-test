<?//---------------------------------แก้ไข โดย pong 03/07/2015-------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
		 $sqlOpen="select st_user.User_id,st_user_rolemaster_head.RoleName 
		,st_user_rolemaster_detail.RoleName_Linename 
		from st_user left join st_user_rolemaster_head 
		on st_user.RoleID=st_user_rolemaster_head.RoleID left join st_user_rolemaster_detail
		 on st_user.RoleID_Lineid = st_user_rolemaster_detail.RoleID_Lineid where st_user.User_id='$USER_id'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		$reOpen=sqlsrv_fetch_array($qryOpen);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3><font face="Lucida Handwriting">ข่าวประชาสัมพันธ์</font><BLINK>...</BLINK>
		
		</h3>
            
 
<div id="prem_hint" style="position:relative; left:0; visibility:hidden" class="prem_hint">
<font color="#FF0000"><b>เปลี่ยนข้อความตรงนี้จ้า</b></font>
</div>

          <p></p>
  
            
    </div>
        
    <div class="sep"></div>

      <table width="100%" align="center" class="tables">
  <thead>
    <tr>
      <th width="2"> ลำดับ</th>
      <th>ชื่อเรื่อง</th>
      <th>รายละเอียด</th>
    </tr>
  </thead>
  <tfoot>
  </tfoot>
  <? 
	if($reOpen['RoleName']=="Admin")
	{	echo"Admin/เห็นทั้งหมด";
		$sql="select * from st_message_new   where  (cast(DateFrom as date)  <= '$date'  and cast(DateTo as date)  >= '$date' ) ";
	}
	else
	{	//echo"User";
		$sql="select * from st_View_message_new where User_id='$USER_id'  and  (cast(DateFrom as date)  <= '$date'  and cast(DateTo as date)  >= '$date' )";
	}
		//echo $sql;
	$qry=sqlsrv_query($con,$sql,$params,$options);
	$r=1;
	while($re=sqlsrv_fetch_array($qry))
  {
		
  ?>
  <tr>
    <td >&nbsp;<?=$r;?></td>
    <td >&nbsp;<?=$re['Subject']; ?></td>
    <td >&nbsp;<?=$re['Remark']; ?></td>
  </tr>
   <tr><td colspan="3" >&nbsp;</td></tr>
  <? $r++;} ?>
</table>

</div></div>


</body>
</html>

