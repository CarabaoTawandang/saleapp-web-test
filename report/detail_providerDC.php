<?
session_start();
include("../includes/config.php"); //connect database db.carabao.com

$id=$_POST['id_provider'];
$_SESSION["DCid"] = $id; 
?>
<script type="text/javascript">
$(function(){	
		$('#btn_scarch,#btn_close').button();
		$('#txt_pro').change(function(){
				
				$.ajax({
					url:'report/aumphur.php',
					type:'POST',
					data:'value='+$('#txt_pro').prop('value'),
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
		$('#btn_scarch').click(function(){
		$('#DIV_search').html("<img src='images/89.gif'>");
				$(".show2").hide();
				$.ajax({
					
					url:'report/scarch_cust_providerDC.php',
					type:'POST',
					data:$('#frmSearch').serialize(),
					success:function(result){
						$('#DIV_search').html(result);
						$(".show2").show();
					}
					});
		});
		$("#btn_close").click(function(){
                    //hidden alert
                    $(".alert_box").css("display", "none");
        });
		
	});//function	
</script>
<div id="save_con" align="center">

<form method="post" action="" id="frmSearch" name="frmSearch">
<div style="width: 100%; text-align: center;    margin-bottom: 2%" >
    <?php 
	$sql1="select dc_groupname from st_user_group_dc where dc_groupid='$id' ";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
	$qry1=sqlsrv_query($con,$sql1,$params,$options);
	$re1=sqlsrv_fetch_array($qry1);
	echo "DC : "; if($id==""){echo "กรุณาเลือก DC ก่อน!!!";}else{ echo $re1['dc_groupname'];}
	?>
	<br>
	<br>
	<B style="color:black;text-align:center;">จังหวัด  :</B>
	<select id="txt_pro" name="txt_pro"   style="width:150px;">
	<option value="" > - Selete -</option>
		<?
			$sqlPro="select stView_DC_Pro.dc_groupid
,stView_DC_Pro.dc_groupname
,stView_DC_Pro.dc_ProCode as PROVINCE_CODE
,dc_province.PROVINCE_NAME
from  stView_DC_Pro left join  dc_province
on stView_DC_Pro.dc_ProCode = dc_province.PROVINCE_CODE

where stView_DC_Pro.dc_groupid ='$id'

order by dc_province.PROVINCE_NAME asc";
			$qryPro=sqlsrv_query($con,$sqlPro,$params,$options);
			while($rePro=sqlsrv_fetch_array($qryPro)){
		?><option value="<?=$rePro['PROVINCE_CODE']; ?>" ><?=$rePro['PROVINCE_NAME']; ?></option>
		<? }?>
	</select>
	<input type="hidden" id="idDC" name="idDC" value="<?=$id; ?>">
	<B style="color:black;text-align:center;">อำเภอ / แขวง  :</B>
	<select id="txt_aum" name="txt_aum"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select>
	<B style="color:black;text-align:center;">ตำบล / แขวง  :</B>
	<select id="txt_dis" name="txt_dis"   style="width:150px;">
		<option value="" > - Selete -</option>
	</select><br><br>
	<B style="color:black;text-align:center;">ประเภท :</B>
	<select id="txt_type" name="txt_type"   style="width:150px;">
		<option value="" > - Selete -</option>
		<?
		$sqlType="select cust_type_id, cust_type_name from st_cust_type";
		$qryType=sqlsrv_query($con,$sqlType,$params,$options);
		while($reType=sqlsrv_fetch_array($qryType)){
			echo '<option value="'.$reType['cust_type_id'].'" >';
			echo $reType['cust_type_name'];
			echo '</option>';
		}
		?>
	</select>
	
	
	
	<input type="button" value="ค้นหา" id="btn_scarch">
	<input type="button" value="ปิด" id="btn_close">
</div>
</form>
<div id="DIV_search" align="center">

</div>
<div style="width: 100%; margin-top: 2%; text-align: center" class="show2 boxhide">
    <button id="save_detail" class="myButton_login">Save</button>
    <button id="close_detail" class="myButton_login">close</button>
</div>
</div>