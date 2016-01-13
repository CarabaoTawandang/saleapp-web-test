<?
session_start();
set_time_limit(0);
include("../includes/config.php");

?>

<br><br>
<table  align="center" class="tables" >
	<tr>
	<th align="center" width="50px">ลำดับ</th>
	<th align="center" width="50px">รหัส</th>
	<th align="center" width="50px">รูป</th>
	<th align="center" width="200px">ชื่อ-นามสกุล</th>
	<th align="center" width="150px">Username</th>
	<th align="center" width="200px">คลัง</th>
	<th align="center" width="200px">DC</th>
	<th align="center" width="100px">ประเภทขาย</th>
	<th align="center" width="100px">เบอร์โทร</th>
	<th align="center" width="100px">ทะเบียนรถ</th>
	<th align="center" width="200px">บริษัท</th>
	<th align="center" width="100px">ตำแหน่ง</th>
	<th align="center" width="100px">รหัสAX</th>
	
	<th align="center" width="300">User ที่ผูก</th>
	<th align="center"  width="50px">แก้ไข</th>
	<th align="center"  width="50px">ผูก</th>
	
	<th align="center" width="50px">สถานะ</th>
	<th align="center" width="50px">ยกเลิก</th>
	</tr>
	<? 
	
	$txt_warehouse_location =trim($_POST['txt_warehouse_location']);
	$txtDC=trim($_POST['txtDC']);
	$txt_saletype =trim($_POST['txt_saletype']);
	$txt_name=trim($_POST['txt_name']);
	$txt_surname =trim($_POST['txt_surname']);
	$txt_username =trim($_POST['txt_username']);
	$txtType =trim($_POST['txtType']);
	$txtType2 =trim($_POST['txtType2']);
	$txt_userId =trim($_POST['txt_userId']);
	
	$sql="select st_user.*
	,st_saletype.SaleTypeName
	,st_user_group_dc.dc_groupname ,st_user_rolemaster_head.RoleName,st_user_rolemaster_detail.RoleName_Linename
	,st_warehouse_location.locationname,st_companyinfo_exp.COMPANYNAME
	from  st_user left join st_user_group_dc
	on st_user.dc_groupid = st_user_group_dc.dc_groupid  left join st_user_rolemaster_head
	on st_user.RoleID=st_user_rolemaster_head.RoleID left join st_user_rolemaster_detail
	on st_user.RoleID_Lineid = st_user_rolemaster_detail.RoleID_Lineid left join st_warehouse_location
	on st_user.warehouse_locationNo = st_warehouse_location.locationno left join st_saletype
	on st_user.st_saletype = st_saletype.SaleType  left join st_companyinfo_exp
	on st_user.COMPANYCODE = st_companyinfo_exp.COMPANYCODE where st_user.status <>'N' ";
	
	
	if($txt_warehouse_location)//ถ้ามีการเลือกคลัง
	{$sql.="and st_user.warehouse_locationNo like '$txt_warehouse_location%' ";
		if($txtDC)			{$sql.="and st_user.dc_groupid like '$txtDC%' ";}
		if($txt_saletype)	{$sql.="and st_user.st_saletype like '$txt_saletype%' ";}
		if($txt_name)		{$sql.="and st_user.name like '$txt_name%' ";}
		if($txt_surname)	{$sql.="and st_user.surname like '$txt_surname%' ";}
		if($txt_username)	{$sql.="and st_user.User_name like '$txt_username%' ";}
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txtDC)
	{$sql.="and st_user.dc_groupid like '$txtDC%' ";
		if($txt_saletype)	{$sql.="and st_user.st_saletype like '$txt_saletype%' ";}
		if($txt_name)		{$sql.="and st_user.name like '$txt_name%' ";}
		if($txt_surname)	{$sql.="and st_user.surname like '$txt_surname%' ";}
		if($txt_username)	{$sql.="and st_user.User_name like '$txt_username%' ";}
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txt_saletype)
	{$sql.="and  st_user.st_saletype like '$txt_saletype%' ";
		if($txt_name)		{$sql.="and st_user.name like '$txt_name%' ";}
		if($txt_surname)	{$sql.="and st_user.surname like '$txt_surname%' ";}
		if($txt_username)	{$sql.="and st_user.User_name like '$txt_username%' ";}
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txt_name)
	{$sql.="and st_user.name like '$txt_name%' ";
		if($txt_surname)	{$sql.="and st_user.surname like '$txt_surname%' ";}
		if($txt_username)	{$sql.="and st_user.User_name like '$txt_username%' ";}
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txt_surname)
	{$sql.="and st_user.surname like '$txt_surname%' ";
		if($txt_username)	{$sql.="and st_user.User_name like '$txt_username%' ";}
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txt_username)
	{$sql.="and st_user.User_name like '$txt_username%' ";
		if($txtType)		{$sql.="and st_user.RoleID like '$txtType%' ";}
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txtType)
	{$sql.="and st_user.RoleID like '$txtType%' ";
		if($txtType2)		{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";}
	}
	else if($txtType2)
	{$sql.="and st_user.RoleID_Lineid like '$txtType2%' ";
	}
	else if($txt_userId)
	{$sql.="and st_user.User_id like '$txt_userId%' ";
	}
	
	
	$sql.="order by st_user.name asc ";
	
	//echo $sql;
	$qry=sqlsrv_query($con,$sql);
	$r=1;
	while($re=sqlsrv_fetch_array($qry))
	{ ?>
	<tr  class="mousechange"  height="30" valign= "top" >
	<td align="center "><? echo $r.". ";?> </td>
	<td align="center "><? echo $re['User_id']; ?> </td>
	<td align="left ">
	<? $Photo= $re['User_pic'];
	if ($Photo)//โชว์รูปภาพและ เช็คบล็อกที่จะลบรูป 
	{
			echo "<a href='#'><span id='mouseOver'><img id='img2'src ='./$Photo' width='200' height='200'>";
			echo "<img src ='images/icon-image.png' >";
			echo "</span></a> ";
	}
	?>
	</td>
	<td align="left "><?=$re['name']." ".$re['surname'];?></td>
	<td align="left "><?=$re['User_name'];?> </td>
	<td align="left "><?=$re['locationname'];?> </td>
	<td align="left "><?=$re['dc_groupname'];?> </td>
	<td align="left "><?=$re['SaleTypeName'];?> </td>
	<td align="left "><?=$re['phone'];?> </td>
	<td align="left "><?=$re['Car_plate'];?> </td>
	<td align="left "><?=$re['COMPANYNAME'];?> </td>
	<td align="left "><? IF($re['RoleName_Linename']){ECHO $re['RoleName_Linename'];}ELSE { ECHO $re['RoleName'];}?> </td>
	<td align="left " ><?=$re['UserID_byAX'];?> </td>
	<td align="left " >
		<?   	$sql2="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$re[User_id]' 
			order by name asc";
			$query2=sqlsrv_query($con,$sql2,$params,$options);
			$row2=sqlsrv_num_rows($query2);
				if($row2>0){
		?>
		<button onclick="if(document.getElementById('spoiler<?=$re['User_id'];?>') .style.display=='none') {document.getElementById('spoiler<?=$re['User_id'];?>') .style.display=''}
		else{document.getElementById('spoiler<?=$re['User_id'];?>') .style.display='none'}" title="Click to show/hide content" type="button">
		<span style="font-size: small;"><b>คลิก</b></span></button>
		<div id="spoiler<?=$re['User_id'];?>" style="display: none;">
			<? $aa=1;
			while($re2=sqlsrv_fetch_array($query2)){ ?>
			&nbsp;&nbsp;&nbsp;<?="[".$aa."] ".$re2['name']." ".$re2['surname']; ECHO"<BR>";?>
			
			<? $aa++;}?>
		</div>
		<? } ?>
	</td>
	
	<td align="center" >
	<a href="?page=edit_user&id=<?=$re['User_id'];?>"><img src="./images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="center" >
	<a href="?page=add_lv_Detail&id=<?=$re['User_id'];?>"  >
	<img src="./images/group_edit.png" style="cursor:pointer" alt="Complete" width="20" height="20"></a>
	</td>
	<td align="center" >
	<!---<a href="?page=from_user&do=del&id=<?=$re['User_id'];?>" onclick="return confirm('คุณต้องการลบข้อมูล User หรือไม่?');" >
	<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>--->
	 <? IF($re['status']=="Y"){echo "ใช้งาน";}else IF($re['status']=="N"){echo "ไม่ใช้งาน";}?>
	</td>
	<td align="center" >
	<a href="?page=from_user&do=canceled&id=<?=$re['User_id'];?>" onclick="return confirm('คุณต้องการยกเลิก User นี้หรือไม่?');" >
	<img src="./images/no.gif" style="cursor:pointer" alt="Complete"></a>
	
	</td>
	</tr>
	<?
	
	$r++;} ?>
	</table>
</body>
</html>
