<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
$txtNameDC=$_POST['txtNameDC'];
$txtGeo = $_POST['txtGeo'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">

	$(function(){	
	$('#btn_add').button();
	<? for($i=1;$i<=77;$i++){ ?>
		$('#R_amp_<?=$i;?>').click(function(){
					if($(this).is(":checked")){
					$(".showAmp<?=$i;?>").show();
					
					} 
					else{
					$(".showAmp<?=$i;?>").hide();
					
					}
		});//txtGeo1
		<? } ?>
	
	
	
	
	
	});//function
	
</script>



</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>เพิ่ม DC</h3>
            
          <p>รายชื่อ DC
		  <input type="button" value="ค้นหาDC" id="btn_add" onclick="window.location='?page=from_DC';" align="center" class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<form  method="post" name="frmuser2" id="frmuser2"  action="?page=add_DC3">
<table cellpadding="0" cellspacing="0"  border="0" >
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td align="left" width="100px"><B style="color:black;text-align:center;">ชื่อDC :</B></td>
<td align="left">
		<input type="text" id="qqqq" name ="qqqq" value="<?=$txtNameDC;?>" disabled="disabled" />
		<input type="hidden" id="txtNameDC" name ="txtNameDC" value="<?=$txtNameDC;?>"  />
</td>
</tr>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left" valign="top"><B style="color:black;text-align:center;">พื้นที่ดูแล:</B></td>
<td align="left" valign="top">***หมายเหตุ:ถ้าไม่ติกเลือก หมายถึงเลือกทุกอำเภอ,ทุกตำบลในจังหวัดที่คุณเลือกมานะคะ
</td>
<tr>
<?
foreach ($txtGeo as $txtGeos=>$value) 
{ //echo $value;
		$sqlSelectGeo="SELECT  GEO_ID ,GEO_NAME  FROM dc_geography where  GEO_ID='$value' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qrySelectGeo=sqlsrv_query($con,$sqlSelectGeo,$params,$options);
		$rowSelectGeo=sqlsrv_num_rows($qrySelectGeo);
		$detailGeo=sqlsrv_fetch_array($qrySelectGeo);
?>
<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr>
<td align="left" valign="top"><B style="color:red;text-align:center;">&nbsp;&nbsp;<? echo $detailGeo['GEO_NAME']; ?></B>
<input type="hidden" id="txtGeo<?=$i;?>" name="txtGeo[]" value="<?print $detailGeo['GEO_ID'];?>">
</td>
<td align="left" valign="top">
	
	<table cellpadding="0" cellspacing="0"  border="1"  >
	<? 
	for($i=1;$i<=6;$i++){
	if($value==$i){$txtPro = $_POST['txtPro'.$i]; foreach ($txtPro as $txtPros=>$valuePro) {
		if ( is_numeric($valuePro) ){$sqlPro="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where PROVINCE_ID='$valuePro' ";}
		else{$sqlPro="SELECT PROVINCE_NAME,PROVINCE_ID FROM dc_Province where GEO_ID='$value' ";}
		//echo $sqlPro;
		$qryPro=sqlsrv_query($con,$sqlPro,$params,$options);
		$rowPro=sqlsrv_num_rows($qryPro); 
		while($detailPro=sqlsrv_fetch_array($qryPro)){
			$PROVINCE_ID=$detailPro['PROVINCE_ID'];
	?>
	
	<tr><td align="left" valign="top" width="200px" ><font color="#0000ff">จ.<? echo $detailPro['PROVINCE_NAME'];?></font>
	<input type="hidden" id="txtPro<?=$i;?>" name="txtPro[]" value="<?print $detailPro['PROVINCE_ID'];?>">
	<td align="left" valign="top" width="700px" >
	<input type="checkbox" name="R_amp_<?=$PROVINCE_ID;?>" id="R_amp_<?=$PROVINCE_ID;?>" value="selectAmp_<?=$PROVINCE_ID;?>"><font color="#0000ff">Selectเลือกอำเภอ </font>
	<div id="showAmp<?=$PROVINCE_ID;?>" class="showAmp<?=$PROVINCE_ID;?> " style="display:none">
		<? 
		$sqlAmp="SELECT AMPHUR_CODE,AMPHUR_NAME FROM dc_amphur where PROVINCE_ID='$PROVINCE_ID' ";
		$qryAmp=sqlsrv_query($con,$sqlAmp,$params,$options); 
		while($detailAmp=sqlsrv_fetch_array($qryAmp))
		{$AMPHUR_CODE=$detailAmp['AMPHUR_CODE'];
		?>	&nbsp;&nbsp;<input type="checkbox" id="DetailAmp[]" name="DetailAmp[]" value="<?=$AMPHUR_CODE?>">อ.<? echo $detailAmp['AMPHUR_NAME'];?>
			<!---<input type="radio" name="R_dis_<?=$AMPHUR_CODE?>" id="R_dis_<?=$AMPHUR_CODE?>" value="selectDis_<?=$AMPHUR_CODE;?>" >Select 
			<input type="radio" name="R_dis_<?=$AMPHUR_CODE?>" id="R_dis_<?=$AMPHUR_CODE?>" value="AllDis_<?=$AMPHUR_CODE;?>" >All--->
			
			<br>
		<?}//while?>
		
		</div>
		
	
	</td></tr>
	
	<?
	}//while
	}//foreach
	}//if
}//for	?>

	</table>
	
</td>
<tr>
<? } ?>

<tr><td colspan="2" align="left">&nbsp;</td></tr>
<tr><td><B>บริษัท</B></td><td>
	<select id="txt_COMPANY" name="txt_COMPANY"  style="width:300px;">
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
<tr>	
<td colspan="2" align="left" >
	<input type="hidden" id="hd_cmd"  name="hd_cmd" />
				
				<input type="submit" class="myButton_form"  id="NEXT2" name="NEXT2" value="NEXT">			
</tr>	
</table>
</form>
</div>
</div>
</body>
</html>