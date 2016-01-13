<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
		 $RoleID =$_SESSION["RoleID"];
		
		$sqlOpen="select cust_type_id,cust_type_name from st_cust_type";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryOpen=sqlsrv_query($con,$sqlOpen,$params,$options);
		$rowOpen=sqlsrv_num_rows($qryOpen);
		
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
	<link rel="stylesheet" href="css_mo/app.css" type="text/css">

<script type="text/javascript">
$(function(){	
		$('#btn_add').button();
		$('#txt_userPlan,#txt_month,#txt_year,#txt_like').change(function(){
				if($('#txt_userPlan').prop('value')==''){alert("โปรดเลือก User ที่จะวางแผน !");}
				else if($('#txt_month').prop('value')==''){alert("โปรดเลือก เดือน ที่จะวางแผน !");}
				else if($('#txt_year').prop('value')==''){alert("โปรดเลือก ปี ที่จะวางแผน !");}
				else{
				$('#txt_calender').html("<img src='images/89.gif'>");
				$.ajax({
					url:'report/CalenderPlan.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_calender').html(result);
					}
				});
				}
		});
		$(".btn_load").click(function(){ 
			
            $(".alert_box").css("display", "block").html("<img src='images/89.gif'>");
				
    });
		
		
});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>วางแผนเข้าพื้นที่ให้ลูกน้อง/เดือน</h3>
            
          <p>
		  <input type="button" value="ค้นหาการวางแผน" id="btn_add" onclick="window.location='?page=from_Inplan2';"  class="inner_position_right">
		  </p>

            
    </div>
        
    <div class="sep"></div><br>
<!---<button class="btn_load">Londing</button><div class="alert_box"></div>--->
<form  method="post" name="frmuser" id="frmuser" action="" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td colspan="10" align="center">
<B>วางแผนให้ : </B>
	<select  id="txt_userPlan" name="txt_userPlan" style="width:170px;" required/>
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
	?></option>
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
<B>กรองแผน</B>
	<input type="text" id="txt_like" name="txt_like">
</td></tr>
<tr><td colspan="10" align="center">&nbsp;</td></tr>
<tr><td colspan="10" align="center">
<div id="txt_calender">
กรุณาเลือก User เลือกเดือน/ปี ก่อนวางแผน
</div>
</td></tr>

</table>
</form>
</div>
</div>

</body>
</html>