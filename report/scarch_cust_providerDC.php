<?
include("../includes/config.php"); //connect database db.carabao.com
$txt_pro =$_POST['txt_pro'];
$txt_aum =$_POST['txt_aum'];
$txt_dis =$_POST['txt_dis'];
$idDC =$_POST['idDC'];
$txt_type =$_POST['txt_type'];

$sqlCust="select  CustNum
,CustName
,AddressNum
,AddressMu
,DISTRICT_NAME
,AMPHUR_NAME
,PROVINCE_NAME
,cust_type_name
from st_View_CustInDc_web where dc_groupid='$idDC'"; //            and CustNum='S111-100028'

if($txt_pro)
{$sqlCust.="and  PROVINCE_CODE='$txt_pro' ";
	if($txt_aum){$sqlCust.="and AMPHUR_CODE='$txt_aum' ";}
	if($txt_dis){$sqlCust.="and DISTRICT_CODE='$txt_dis' ";}
}
if($txt_type)
{$sqlCust.="and  cust_type_id='$txt_type' ";
}

$sqlCust.="and CustNum  is not null order by PROVINCE_NAME asc,AMPHUR_NAME asc ,DISTRICT_NAME asc ";
$qryCust=sqlsrv_query($con,$sqlCust);
//echo $sqlCust;


/*$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$qryCust=sqlsrv_query($con,$sqlCust,$params,$options);
$rowCust=sqlsrv_num_rows($qryCust);*/





		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type='text/javascript'>
$(function(){
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
</head>
<body>
<table style="width: 100%; border-collapse: collapse" border="1">
    <thead>
        <tr style="text-align: center; background-color: #201f10; color: white">
            <td style="width: 60px" rowspan="2"><input type="checkbox" id="custAll">All</td>
			<td style="width: 60px" rowspan="2">รหัสร้าน</td>
            <td style="width: 60px" rowspan="2">ชื่อร้าน</td>
			<td style="width: 60px" colspan="5">ที่อยู่</td>
			<td style="width: 60px" rowspan="2">ประเภท</td>
            
        </tr>
		<tr style="text-align: center; background-color: #201f10; color: white">
            <td style="width: 60px" >บ้านเลขที่</td>
			<td style="width: 60px" >หมู่ที่</td>
            <td style="width: 60px" >ตำบล</td>
			<td style="width: 60px" >อำเภอ</td>
			<td style="width: 60px" >จังหวัด</td>
            
        </tr>
    </thead>
    <tbody>
        <?php
			$a=1;
            while($detail=sqlsrv_fetch_array($qryCust)){
        ?>
            <tr><td style="text-align: center;"><?=$a;?><input type="checkbox" class="checkbox"></td>
                <td style="text-align: center" class="id_detail_provider"><?php echo $detail['CustNum'];?></td>
                <td style="text-align: left; padding-left: 1%"><?php echo $detail['CustName'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['AddressNum'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['AddressMu'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['DISTRICT_NAME'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['AMPHUR_NAME'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['PROVINCE_NAME'];?></td>
				<td style="text-align: left; padding-left: 1%"><?php echo $detail['cust_type_name'];?></td>
            </tr>
        <?php $a++;}?>
    </tbody>
</table>
</body>
</html>

