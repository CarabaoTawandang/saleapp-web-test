<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();$('#btn_add2').button();
		$('#txt_DC').change(function(){
				
				$.ajax({
					url:'report/UserByDC.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_User').html(result);
					}
				});
		});
		$('#btn_search').click(function(){
					if($('#txt_User').prop('value')==''){alert("โปรดเลือก User  !");}
					else if($('#txt_month').prop('value')==''){alert("โปรดเลือก เดือน  !");}
					else if($('#txt_year').prop('value')==''){alert("โปรดเลือก ปี  !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_Inplan2.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
	$('#dateTo,#dateEnd').datepicker({
                                            
                        dateFormat:'yy-mm-dd'

                                });
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาการวางแผน/เดือน</h3>
            
          <p>
		   <input type="button" value="วางแผน/เดือน" id="btn_add2" onclick="window.location='?page=add_planMonth';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0">
	<tr><td align="center">
	<B>DC: </B>
	<select  id="txt_DC" name="txt_DC" style="width:170px;" >
	<option value="">-เลือก DC-</option>
		<? $sqlOp="select a.dc_groupname,a.dc_groupid
			from st_user_group_dc a   ";
			if($userType <>"7" and $userType2<>""){
				$sqlOp.=" left join st_user u
				on u.dc_groupid =a.dc_groupid
				where u.User_id= '$USER_id'"; }
			echo $sqlOp;
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['dc_groupid']." '>";
			echo $deOp['dc_groupname'];
			echo "</option>";
			}
		?>
	</select>
	<B>User: </B>
	<select  id="txt_User" name="txt_User" style="width:170px;" >
	<option value="">-เลือกพนักงานขาย-</option>
		<? $sqlOp="select st_user_lv_Detail.user_id_head
			,st_user_lv_Detail.user_id_detail
			,st_user.*
			from st_user_lv_Detail left join st_user
			on st_user_lv_Detail.user_id_detail = st_user.User_id
			where  st_user_lv_Detail.user_id_head ='$USER_id' 
			order by st_user.Salecode asc ";
			$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
			while($deOp=sqlsrv_fetch_array($qryOp)){
			echo "<option value='".$deOp['user_id_detail']." '>";
			echo $deOp['Salecode']." ".$deOp['name']." ".$deOp['surname'];
			echo "</option>";
			}
		?>
	</select>
<B>เดือน : </B>
	<select  id="txt_month" name="txt_month" style="width:100px;" required/>
	<option value="<?=date('m');?>"><?
										$date_date = date('m');
										switch($date_date)
										{ 
										case 01 : $month="มกราคม"; break;
										case 02 : $month="กุมภาพันธ์"; break;
										case 03 : $month="มีนาคม"; break;
										case 04 : $month="เมษายน"; break;
										case 05 : $month="พฤษภาคม"; break;
										case 06 : $month="มิถุนายน"; break;
										case 07 : $month="กรกฎาคม"; break;
										case 08 : $month="สิงหาคม"; break;
										case 09 : $month="กันยายน"; break;
										case 10 : $month="ตุลาคม"; break;
										case 11 : $month="พฤศจิกายน"; break;
										case 12 : $month="ธันวาคม"; break;
										}
										echo $month;
									?>
	</option>
	<option value="1">มกราคม</option>
	<option value="2">กุมภาพันธ์</option>
	<option value="3">มีนาคม</option>
	<option value="4">เมษายน</option>
	<option value="5">พฤษภาคม</option>
	<option value="6">มิถุนายน</option>
	<option value="7">กรกฎาคม</option>
	<option value="8">สิงหาคม</option>
	<option value="9">กันยายน</option>
	<option value="10">ตุลาคม</option>
	<option value="11">พฤศจิกายน</option>
	<option value="12">ธันวาคม</option>
	</select>

<B>ปี : </B>
	<select  id="txt_year" name="txt_year" style="width:70px;" required/>
	<option value="<?=date('Y');?>"><?=date('Y');?></option>
	<option value="<?=date('Y')-1;?>"><?=date('Y')-1;?></option>
	<option value="<?=date('Y')-2;?>"><?=date('Y')-2;?></option>
	<option value="<?=date('Y')+1;?>"><?=date('Y')+1;?></option>
	<option value="<?=date('Y')+2;?>"><?=date('Y')+2;?></option>
	</select>

	<br><br>
	<input type="button" value="ค้นหาแผน" class="myButton_form" id="btn_search" name="btn_search">
	<br><br><div id="txt_search"></div>
	
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br>
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	
	$del3="delete from st_plan_head where Plan_Docno='$id'";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options); //tb stock ท้ายรถ
	
	
	  
	  
	$sqlDel4="delete st_plan_detail where Plan_Docno='$id'";//เปิดใบรับของเข้าท้ายรถ หลัก
	$qryDel4=sqlsrv_query($con,$sqlDel4,$params,$options);
	
	
	if($qrydel3)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบแผนของUser เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_Inplan';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ  ไม่สำเร็จ ");';
			echo "window.location='?page=from_Inplan';";
			echo '</script>';
	}
	
	
}
?>