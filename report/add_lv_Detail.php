<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$id =$_GET['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
	 
	
	
	$(function(){	
		$('#btn_Search').button();
		$('#save').button();
		$('#reset').button();
		$('#No').button();
		$('#txtType').change(function(){
				
				$.ajax({
					url:'report/Role2.php',
					type:'POST',
					data:'value='+$('#txtType').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txtType2').html(result);
					}
				});
		});
		
		$('#save').click(function(){
					
					
					
					
					$('#txt_check').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/save_lv_Detail.php',
						type:'POST',
						data:$('#frmuser').serialize(),
						success:function(result){
							$('#txt_check').html(result);
							}
							});
							
						
		});
		$('#custAll').change(function()
	{		
				if (this.checked) 
				{ 	//alert('checked'); 
					$(".checkbox").attr("checked", "true");
				} 
				else 
				{ 	//alert('no');
					//$(".checkbox").attr("checked", "false");
					$(".checkbox").removeAttr("checked"); 
				}
				
	});
		
		});//function	
</script>
<style type="text/css">  
.inner_position_center{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:40%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>
<style type="text/css">
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
        position: absolute;
        left:230px;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 30px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }
</style> 
</head>
<body>
<form  method="post" name="frmuser" id="frmuser" action="#" >
<div class="container_box">
    <div id="box">
	<div class="header"><h3>เลือก User ที่ต้องการผูก</h3><!---หัวเรื่องหลัก-->
           <p>เลือก User ที่ต้องการให้อยู่ภายใต้คุณ</p><!---หัวเรื่องรอง-->
	</div><div class="sep"></div>
		<!---เนื้อหา-->
	<div align="center"><br>
	<B>คลัง</B>
			<select id="txt_warehouse_location" name="txt_warehouse_location"  style="width:200px;">
			<option value="" > - ALL- </option>
			<?	$sql="SELECT * FROM st_warehouse_location   ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){

				
					?>
					<option value="<?print $detail['locationno']?>" ><?print $detail['locationname']?></option>
				
					<?
					}

				
			
			?>
			</select>
			<B>DC</B>
			<select id="txtDC" name="txtDC"  style="width:200px;">
				<option value="">-ALL-</option>
				<?	$sql="SELECT  dc_groupid ,dc_groupname  FROM st_user_group_dc  order by  dc_groupid asc ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){
				?>
				<option value="<?print $detail['dc_groupid']?>" ><?print $detail['dc_groupname']?></option>
				<?}?>
			</select>
			
			<br><br>
		<b>ชื่อ</b><input type="text" id="txt_name" name="txt_name" value="">
		<b> นามสกุล </b><input type="text" id="txt_surname" name="txt_surname" value="">
		<b> Username </b><input type="text" id="txt_username" name="txt_username" value="">
			<br><br>
			<b> ประเภทตำแหน่ง: </b>
				<select id="txtType" name="txtType"  style="width:170px;">
				<option value="">-ALL-</option>
				<?	$sql="SELECT  RoleID ,RoleName  FROM st_user_rolemaster_head   ";
					$qry=sqlsrv_query($con,$sql);
					while($detail=sqlsrv_fetch_array($qry)){
				?>
				<option value="<?print $detail['RoleID']?>" ><?print $detail['RoleName']?></option>
				<?}?>
			</select> 
			<b> ตำแหน่ง:</b>
			<select id="txtType2" name="txtType2"  style="width:190px;">
				<option value="">-ALL-</option>
			</select>
		<br><br>
		<input type="submit" id="btn_Search" name="btn_Search" value="ค้นหา">
		
</div>
</div><!--/-box-->
</div><!--/-container_box-->
	
	
	
	
	
	
	
	
	
	
	
<br><br>	
<table  align="center" class="tables" width="100%" >
	
	<tr>
	<th ><input type="checkbox" id="custAll">All</th>
	<th align="center" width="50px">รหัส</th>
	<th align="center" width="50px">รูป</th>
	<th >ชื่อ-นามสกุล</th>
	<th >Username</th>
	<th align="center" width="200px">คลัง</th>
	<th align="center" width="200px">DC</th>
	<th >ตำแหน่ง</th>
	
	</tr>
	
	<? 
	$txt_warehouse_location =$_POST['txt_warehouse_location'];
	$txtDC=$_POST['txtDC'];
	$txt_name=$_POST['txt_name'];
	$txt_surname =$_POST['txt_surname'];
	$txt_username =$_POST['txt_username'];
	$txtType =$_POST['txtType'];
	$txtType2 =$_POST['txtType2'];
	$sql="select st_user.*,st_user_group_dc.dc_groupname ,st_user_rolemaster_head.RoleName,st_user_rolemaster_detail.RoleName_Linename,st_warehouse_location.locationname
		from  st_user left join st_user_group_dc
		on st_user.dc_groupid = st_user_group_dc.dc_groupid  left join st_user_rolemaster_head
		on st_user.RoleID=st_user_rolemaster_head.RoleID left join st_user_rolemaster_detail
		on st_user.RoleID_Lineid = st_user_rolemaster_detail.RoleID_Lineid left join st_warehouse_location
		on st_user.warehouse_locationNo = st_warehouse_location.locationno
		where st_user.User_id <>'$id' and  st_user.status <>'N' ";
	
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
	
	
	$sql.="order by st_user.name desc ";
		//echo $sql;
		$qry=sqlsrv_query($con,$sql);
		$r=1;
		while($re=sqlsrv_fetch_array($qry)){ 
		$sqlCheck ="select user_id_detail from st_user_lv_Detail where user_id_head = '$id' and user_id_detail='$re[User_id]'";
		$qryCheck=sqlsrv_query($con,$sqlCheck,$params,$options);
		$reCheck=sqlsrv_fetch_array($qryCheck);
		
	?>
	<tr  height="30" >
	<td align="center" >
		<? echo $r.". ";?>
		<input type="checkbox" class="checkbox" id="user_under[]" name="user_under[]" value="<?=$re['User_id']?>" <? if($reCheck){echo "checked";}?>>
		<input type="hidden" id="user_id_head" name="user_id_head" value="<?=$id;?>">
	</td>
	<td align="center "><? echo $re['User_id']; ?> </td>
	<td align="left ">
	<? $Photo= $re['User_pic'];
	if ($Photo)//โชว์รูปภาพและ เช็คบล็อกที่จะลบรูป 
	{
			echo "<a href='#'><span id='mouseOver'><img id='img2'src ='./$Photo' width='200' height='200'>";
			echo "<img src ='../images/icon-image.png' >";
			echo "</span></a> ";
	}
	?>
	</td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['name']."  ".$re['surname'];?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['User_name'];?> </td>
	<td align="left "><?=$re['locationname'];?> </td>
	<td align="left "><?=$re['dc_groupname'];?> </td>
	<td align="left ">&nbsp;&nbsp;&nbsp;<?=$re['RoleName']."&nbsp;&nbsp;&nbsp; ".$re['RoleName_Linename'];?> </td>
	
	</tr>
	<? $r++;} ?>
	
	
	<tr  height="50" >
	<td align="center" colspan="10" bgcolor="#E8E8E8">
		<B>บริษัท : </B>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;" >
	<?	$sql="SELECT COMPANYCODE,COMPANYNAME  FROM st_companyinfo_exp   ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);

		
			?>
			<option value="<?print $detail['COMPANYCODE']?>" ><?print $detail['COMPANYNAME']?></option>
		
			<?
			}

		
	
	?>
	</select>
	</td></tr>
	<tr  height="50">
	<td align="center" colspan="10" bgcolor="#E8E8E8">
	<input type="button" id="save" name="save" value="save" class="inner_position_center">
	<input type="reset" id="reset" name="reset" value="reset" class="inner_position_center">
	<input type="button" id="No" name="No" value="ข้าม" class="inner_position_center" onclick="window.location.href = '?page=from_user'">
	</td></tr>
</table>
</form>
<div id="txt_check"></div>
</body>
</html>