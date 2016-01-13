<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">

$(function(){	
			
		$('#btn_add').button();$('#btn_add2').button();
		$('#btn_search').click(function(){
					if(($('#txt_DC').prop('value')=='')&&($('#txt_name').prop('value')=='')
					&&($('#txt_pro').prop('value')=='')&&($('#txt_aum').prop('value')=='')
					&&($('#txt_dis').prop('value')=='')
					&&($('#txt_id').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_plan.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
		
		$('#txt_DC').change(function(){
				
				$.ajax({
					url:'report/province_from_plan.php',
					type:'POST',
					data:'value='+$('#txt_DC').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
			});	
			
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_aum').html(result);
					}
				});
			});
		
		$('#txt_aum').change(function(){
				
				$.ajax({
					url:'report/district.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
			});
		
	$('#order_n').change(function(){
		if($('#order_n').val()=='') {

		$('#order_by').attr("disabled", true); 
	
		} else {

	  $('#order_by').removeAttr("disabled");
	 
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
        
        <h3>ค้นหาแผน</h3>
            
          <p>
		   <input type="button" value="สร้างแผน" id="btn_add2" onclick="window.location='?page=add_Masterplan';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
	
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  cellpadding="0" cellspacing="0" align="center" border="0">
	<tr><td align="center">
	
	รหัสแผน :&nbsp;<input type="text" id="txt_id" name="txt_id">
	&nbsp;&nbsp;ชื่อแผน :&nbsp;<input type="text" id="txt_name" name="txt_name">
	&nbsp;&nbsp;
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
	
	
	
	</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="center">
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select style="width:150px;text-align:left;" id="txt_pro"  name="txt_pro" >
	<option value="">-เลือก-</option>
	<?	$sql3="SELECT * FROM dc_Province  order by PROVINCE_NAME asc  ";
			$qry3=sqlsrv_query($con,$sql3);
			while($detail3=sqlsrv_fetch_array($qry3))
				{
				echo '<option value="'.$detail3['PROVINCE_CODE'].'">'.$detail3['PROVINCE_NAME'].'</option>';
				}
		?>
	
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_aum"  name="txt_aum" >
	<option value="">-เลือก -</option>
		
	</select>&nbsp;&nbsp;
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select style="width:150px;text-align:left;" id="txt_dis"  name="txt_dis" >
	<option value="">-เลือก -</option>
		
	</select></td></tr>
	
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr><td align="center">
	เรียง  :
	<select style="width:100px;text-align:left;" id="order_n"  name="order_n" >
	<option value="">-เลือก-</option>
	<option value="st_Master_plan.Plan_id">รหัส</option>
	<option value="st_Master_plan.Plan_name">ชื่อ</option>
	</select>&nbsp;&nbsp;
	<select style="width:100px;text-align:left;" id="order_by"  name="order_by" disabled>
	<option value="">-แบบ-</option>
	<option value="ASC">น้อยไปมาก</option>
	<option value="DESC">มากไปน้อย</option>
	</select>
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหาแผน" class="myButton_form" id="btn_search" name="btn_search">
	</td></tr>
	</table>
	</form>


</div><!--/-box-->
</div><!--/-container_box-->
<br><br><div id="txt_search" align="center"></div>
<?
if($_GET['do']=="del")
{
	$id=$_GET['id'];
	
	$del3="delete from st_Master_plan where Plan_id=$id ";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options); 
	
	
	  
	  
	$sqlDel4="delete st_Master_PlanDetail  where Plan_id=$id ";
	$qryDel4=sqlsrv_query($con,$sqlDel4,$params,$options);
	
	
	if($qrydel3)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบแผนเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบ  ไม่สำเร็จ ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	
	
}
if($_GET['do']=="Cancel")
{
	$id=$_GET['id'];
	
	$del3="update  st_Master_plan
	set Plan_status ='N'
	where Plan_id=$id ";
	$qrydel3=sqlsrv_query($con,$del3); 
	
	
	
	
	if($qrydel3)
	{
			echo'<script type="text/javascript">';
			echo'alert("ยกเลิกแผนเรียบร้อยแล้ว ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	else
	{
			echo'<script type="text/javascript">';
			echo'alert("  ไม่สำเร็จ ");';
			echo "window.location='?page=from_plan';";
			echo '</script>';
	}
	
	
}
?>