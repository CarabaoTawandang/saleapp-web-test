<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$sql1="select dc_groupname,dc_groupid
			from st_View_User_DC 
			where User_id='$USER_id'
			group by dc_groupname,dc_groupid
			";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry1=sqlsrv_query($con,$sql1,$params,$options);
			$detail1=sqlsrv_fetch_array($qry1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_scarch').button();
		
		
		/*$('#btn_scarch').click(function(){
				$('#DIV_search').html("<img src='images/89.gif'>").css({'text-align':'center'});
					$.ajax({
					url:'report/scarch_cust.php',
					type:'POST',
					data:'',
					success:function(result){
						$('#DIV_search').html(result);
								
					}
				});

			});*/
		$('#btn_scarch').click(function(){
		$('#DIV_search').html("<img src='images/89.gif'>");
				$.ajax({
					
					url:'report/scarch_cust_DC.php',
					type:'POST',
					data:$('#frmuser').serialize(),
					success:function(result){
						$('#DIV_search').html(result);
					}
					});
						
						
						
					
		});
		$('#txt_geo').change(function(){
				$.ajax({
					url:'report/provinceDC.php',
					type:'POST',
					data:'value='+$('#txt_geo').prop('value'),
					//alert("phung");
					//data:{name:'1'}
					success:function(result){
						$('#txt_pro').html(result);
					}
				});
		});	
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphurDC.php',
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
					url:'report/districtDC.php',
					type:'POST',
					data:'value='+$('#txt_aum').prop('value'),
					//alert(data);
					//data:{name:'1'}
					success:function(result){
						$('#txt_dis').html(result);
					}
				});
		});
	});//function	
</script>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาร้านค้า</h3>
            
          <p>รายชื่อร้านค้า</p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form id="frmuser" name="frmuser" action="" method="post" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  class="box" width="1124px">
<tr><td><div class="h_head"><? echo $detail1['dc_groupid']; echo "  : ". $detail1['dc_groupname']; ;?></div></td>
<td ></td></tr>
<tr><td colspan="2">
	<B style="color:black;text-align:center;">ชื่อร้าน : </B>
	<B style="color:black;text-align:center;">ภาค :</B>
	<select id="txt_geo" name="txt_geo"  style="width:150px;">
		<option value=""> - Selete -</option>
	<?	  $sql="select st_user.User_id,st_user.dc_groupid
				,st_user_group_dc_detail.dc_GeoId as GEO_CODE
				,dc_geography.GEO_NAME

				from st_user left join st_user_group_dc_detail
				on st_user.dc_groupid =st_user_group_dc_detail.dc_groupid  left join  dc_geography
				on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE

				where st_user.User_id='$USER_id'

				group by  st_user.User_id,st_user.dc_groupid
				,st_user_group_dc_detail.dc_GeoId
				,dc_geography.GEO_NAME 
				order by dc_geography.GEO_NAME asc";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j++){

		$detail=sqlsrv_fetch_array($qry);
			?>
			<option value="<?print $detail['GEO_CODE']?>" ><?print $detail['GEO_NAME']?></option>
		
			<?
			}

		
	
	?>
	</select><? //echo $sql;?>
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select id="txt_pro" name="txt_pro"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select id="txt_dis" name="txt_dis"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<input type="button" value="ค้นหา" id="btn_scarch">
	
	</td>
</tr>
</table>

</form>
	
</div>
</div>
<div id="DIV_search" align="center"></div>
</body>
</html>

