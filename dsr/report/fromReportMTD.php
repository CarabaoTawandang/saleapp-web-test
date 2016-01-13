
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
			
		$('#btn_search,#btn_excel').button();
		$('#btn_search').click(function(){
					if($('#txt_DC').prop('value')=='')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_mouth').prop('value')=='')
					{ alert("โปรดใส่เดือนที่ต้องการค้นหา");
					}
					else {
					$('#txt_search').html("<img src='../images/89.gif'>");
					$.ajax({
						
						url:'report/ReportMTD.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		$('#btn_excel').click(function(){
				//alert("test");
					if($('#txt_DC').prop('value')=='')
					{ alert("โปรดใส่ศุนย์ที่ต้องการค้นหา");
					}
					else if($('#txt_mouth').prop('value')=='')
					{ alert("โปรดใส่เดือนที่ต้องการค้นหา");
					}
					else {
					$('#frmSearch').submit();
					}
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
        
        <h3>ค้นหาMTDสรุปยอดขายประจำวัน</h3>
            
          
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" id="frmSearch" name="frmSearch"   action="report/ExcelReportMTD.php">
	<table  align="center" border="0">
	<tr><td align="center">
	<B>ศูยน์DC: </B>
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
	<b style="color:black;text-align:center;">เดือน</b>
			<select id="txt_mouth" name="txt_mouth"   style="width:100px;">
				<option value=""> -เลือกเดือน- </option>
				<option value="01">มกราคม</option>
				<option value="02">กุมภาพันธ์</option>
				<option value="03">มีนาคม</option>
				<option value="04">เมษายน</option>
				<option value="05">พฤษภาคม</option>
				<option value="06">มิถุนายน</option>
				<option value="07">กรกฏาคม</option>
				<option value="08">สิงหาคม</option>
				<option value="09">กันยายน</option>
				<option value="10">ตุลาคม</option>
				<option value="11">พฤศจิกายน</option>
				<option value="12">ธันวาคม</option>
			</select>
			<b style="color:black;text-align:center;">ปี</b>
			<select id="txt_year" name="txt_year"   style="width:100px;">
				<option value="<?=date('Y');?>"><?=date('Y');?></option>
				<option value="<?=date('Y')-3;?>"><?=date('Y')-3;?></option>
				<option value="<?=date('Y')-2;?>"><?=date('Y')-2;?></option>
				<option value="<?=date('Y')-1;?>"><?=date('Y')-1;?></option>
				<option value="<?=date('Y');?>"><?=date('Y');?></option>
				<option value="<?=date('Y')+1;?>"><?=date('Y')+1;?></option>
				<option value="<?=date('Y')+2;?>"><?=date('Y')+2;?></option>
				<option value="<?=date('Y')+3;?>"><?=date('Y')+3;?></option>
			</select>
	
	<br><br>
	<a href="#/btn_search" id="btn_search" style="width:200px;text-align:center;" >Search Report</a>
	<a href="#/btn_excel" id="btn_excel" style="width:200px;text-align:center;" >Export Excel</a>
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->

<br><br><div id="txt_search" align="center"></div>
</form>

