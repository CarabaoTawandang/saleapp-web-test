<?
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		
?>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_add2').button();
		$('#btn_search').click(function(){
					if(($('#txt_id').prop('value')=='')&&($('#txt_name').prop('value')=='')&&(document.getElementById("txt_all").checked != true))
					{alert("โปรดใส่สิ่งที่ต้องการที่ต้องการ !");}
					else {
					$('#txt_search').html("<img src='images/89.gif'>");
					$.ajax({
						
						url:'report/data_rolemaster.php',
						type:'POST',
						data:$('#frmSearch').serialize(),
						success:function(result){
							$('#txt_search').html(result);
							}
							});
							
						}	
		});
	});//function	
</script>

<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:50%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาตำแหน่ง</h3>
            
          <p>รายชื่อตำแหน่ง
	<input type="button" value="ประเภทตำแหน่ง" id="btn_add" onclick="window.location='?page=add_rolemaster';"  class="inner_position_right">
	<input type="button" value="ตำแหน่ง" id="btn_add2" onclick="window.location='?page=add_rolemaster2';"  class="inner_position_right">
            
    </div>
        
    <div class="sep"></div><br>
	<form method="post" action="" id="frmSearch" name="frmSearch">
	<table  align="center" border="0"><tr><td align="center">
	รหัสตำแหน่งหลัก<input type="text" id="txt_id" name="txt_id">
	ชื่อตำแหน่งหลัก<input type="text" id="txt_name" name="txt_name">
	<input type="checkbox" value="all" id="txt_all" name="txt_all">ดูทั้งหมด
	<input type="button" value="ค้นหา" class="myButton_form" id="btn_search" name="btn_search">
	
	<br><br><div id="txt_search"></div>
	</td></tr></table>
	
</div>
</div>




</form>
<?
if($_GET['do']=="del")
{
	 $id=$_GET['id'];
	$sqlOp="select RoleID_Lineid from st_user_rolemaster_detail where RoleID='$id' ";
	$qryOp=sqlsrv_query($con,$sqlOp,$params,$options);
	while($reOp=sqlsrv_fetch_array($qryOp))
	{
	//echo $reOp['RoleID_Lineid'];
	//echo "<br>";
	$del4="delete from st_user_rolemaster_head_type where RoleID='$reOp[RoleID_Lineid]'";
	$qrydel4=sqlsrv_query($con,$del4,$params,$options);
	}
	
	$del="delete from st_user_rolemaster_head where RoleID='$id'";
	$qrydel=sqlsrv_query($con,$del,$params,$options);
	
	$del3="delete from st_user_rolemaster_detail where RoleID='$id'";
	$qrydel3=sqlsrv_query($con,$del3,$params,$options);
	
	
	
	if($qrydel && $qrydel3)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบตำแหน่งหลัก เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_rolemaster';";
			echo '</script>';
	}
	
}
if($_GET['do']=="del2")
{
	$id=$_GET['id'];
	$del="delete from st_user_rolemaster_detail where RoleID_Lineid='$id'";
	$qrydel=sqlsrv_query($con,$del,$params,$options);
	
	$del4="delete from st_user_rolemaster_head_type where RoleID='$id'";
	$qrydel4=sqlsrv_query($con,$del4,$params,$options);
	if($qrydel)
	{
			echo'<script type="text/javascript">';
			echo'alert("ลบตำแหน่งย่อย เรียบร้อยแล้ว ");';
			echo "window.location='?page=from_rolemaster';";
			echo '</script>';
	}
	
}
?>