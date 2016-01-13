<?

include("../includes/config.php");
$id=$_GET['id'];
$do=$_GET['do'];
$sql ="select a.Plan_id,a.Plan_name,a.DC_id,a.Remark,a.COMPANYCODE
		,b.dc_groupname,c.COMPANYNAME
		from st_Master_plan a left join st_user_group_dc b
		on a.DC_id = b.dc_groupid left join st_companyinfo_exp c
		on a.COMPANYCODE = c.COMPANYCODE
where a.Plan_id='$id' ";
$query=sqlsrv_query($con,$sql);
$re=sqlsrv_fetch_array($query);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ดูแผน</title>
<script type="text/javascript">
$(function(){
	$("#btn_add").button();
});
</script>
<link href="../css2/css.css" rel="stylesheet" type="text/css">
 <script src="../css2/ddmenu.js" type="text/javascript"></script>
 <!---------เดิม-<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.css'>
--->
<script type='text/javascript' src='../jQuery/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='../jQuery/jquery-ui-1.10.0.custom.min.js'></script>


<script type="text/javascript" src="../jQuery/path.js"></script>
<link rel='stylesheet' type='text/css' href='jQuery/ui-lightness/jquery-ui-1.10.0.custom.min.css'>

</head>
<body>

<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ดูแผน</h3>
           <? if($do=="not"){}else{?> 
          <p>
		  <input type="button" value="ค้นหาแผน" id="btn_add" onclick="window.location='?page=from_plan';"  class="inner_position_right">
		  </p>
			<? } ?>
            
    </div>
        
    <div class="sep"></div><br>
<div class="box" align="center" >
<table cellpadding="0" cellspacing="0"  border="0" align="center"  width="1124px">


<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>หัวข้อแผนการวิ่ง : </B></td><td>
<input type="text" id="txt_planName" name="txt_planName" value="<? echo $re['Plan_name'];?>" disabled ><B style="color:red;text-align:center;">*</B>
<input type="hidden" id="txt_planID" name="txt_planID" value="<? echo $re['Plan_id']; ?>" >
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150"><B>DC: </B></td><td>
	<select  id="select_provider" name="select_provider" style="width:200px;" disabled>
	<option value="<? echo $re['DC_id']; ?>"><? echo $re['dc_groupname']; ?></option>
		
	<B style="color:red;text-align:center;">*</B>
	
</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td width="150" align="left"  valign= "top" ><B>ร้านค้า : </B></td>
<td align="left">
	
		<div class="div_this_item" style="overflow-y: auto;width: 90%; height: 400px; border-radius: 10px; padding: 2%; text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">
		<?php 
			$sqlCheck="select a.Plan_id,a.row,a.Cust_num
			,b.CustName
			,b.AddressNum
			,b.AddressMu 
			,b.DISTRICT_NAME
			,b.AMPHUR_NAME
			,b.PROVINCE_NAME
			,b.cust_type_name
			from st_Master_PlanDetail a left join st_View_cust_web  b
			on a.Cust_num =b.CustNum
			where a.Plan_id ='$id'
			order by a.row asc";	
			$qryCkeck=sqlsrv_query($con,$sqlCheck);
			while($reCkeck=sqlsrv_fetch_array($qryCkeck))
			{ $Cust_num= $reCkeck['Cust_num']; $row= $reCkeck['row'];
		?>
				<div class="this_item">
					<?php 	
							echo "[".$row."] -";
							echo $Cust_num ;	
							echo " ".$reCkeck['CustName'];
							echo "  ที่อยู่  ".$reCkeck['AddressNum'];
							echo " ม.  ".$reCkeck['AddressMu'];
							echo " ต.  ".$reCkeck['DISTRICT_NAME'];
							echo " อ.  ".$reCkeck['AMPHUR_NAME'];
							echo " จ.  ".$reCkeck['PROVINCE_NAME'];
							echo " ".$reCkeck['cust_type_name'];
							
		?>
					
				</div>

		<?php }?>

		</div>
	</div>
	<div class="alert_box">
        <div class="result_alert">
            <div class="detail_content"></div>
        </div>
	</div>

</td></tr> 
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>


<tr><td width="150"><B>หมายเหตุ</B></td><td>
<input type="text" id="txt_remark"align="center" name="txt_remark" size="35" value="<? echo $re['Remark']; ?>" disabled/></td></tr>
	
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;" disabled>
	<option value="<?print $re['COMPANYCODE']?>" ><?print $re['COMPANYNAME']?></option>
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
	<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="left" ><input type="hidden" id="hd_cmd"  name="hd_cmd" />

</table>
</div>

</div>
</div>


</body>
</html>
