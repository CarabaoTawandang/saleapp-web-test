<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$txt_id = $_POST['txt_id'];
$txt_name = $_POST['txt_name'];
$sql="select * from st_user_group_dc  ";
if($txt_id){$sql.="where   dc_groupid like '$txt_id%' ";}
else if($_GET['id']){$sql.="where   dc_groupid='$_GET[id]' ";}
else if($txt_name){$sql.="where  dc_groupname  like '%$txt_name%' ";}
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
//echo $sql ;
$qry=sqlsrv_query($con,$sql,$params,$options);
$r=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
$(function(){	
			
		$('#btn_add').button();
		$('#btn_add2').button();
		
	});//function	
</script>
<style type="text/css">  
.inner_position_right{  
    
    top:0px; /* css กำหนดชิดด้านบน  */  
    left:70%; /* css กำหนดชิดขวา  */  
    z-index:999;  
} 
</style>
</head>
<body>
<div class="container_box">
             
  <div id="box">

      <div class="header">
        
        <h3>ค้นหาDC</h3>
            
          <p>รายชื่อ DC
		  <input type="button" value="เพิ่ม DC" id="btn_add" onclick="window.location='?page=add_DC';"  class="inner_position_right">
		   <input type="button" value="เพิ่มร้านค้าเข้าDC" id="btn_add2" onclick="window.location='?page=add_CustInDC';"  class="inner_position_right">
		  </p>
  
            
    </div>
        
    <div class="sep"></div><br>
<table cellpadding="0" cellspacing="0"  border="0" align="center"  >
<tr><td colspan="2">
	<table cellpadding="0" cellspacing="0"  border="1" align="center"  width="1000px">
	<tr><td align="center">รหัสDC</td><td align="center">ชื่อDC</td><td align="center">พื้นที่ดูแล ภาค/จังหวัด/อำเถอ</td><TD align="center">ลบ</TD></tr>
	<? while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr bgcolor="<?=$col;?>" height="30" >
	<td align="left" valign= "top">&nbsp;<?=$dc_groupid= $re['dc_groupid'];?> </td>
	<td align="left" valign= "top">&nbsp;<?=$re['dc_groupname'];?> </td>
	<td align="left" valign= "top"><br><table  ><?
	 $sqlType="SELECT   st_user_group_dc.dc_groupid
			,st_user_group_dc.dc_groupname
			,st_user_group_dc_detail.dc_GeoId
			,st_user_group_dc_detail.dc_ProId
			,st_user_group_dc_detail.dc_ampId
			,st_user_group_dc_detail.dc_DisId
			, dc_geography.GEO_NAME
			,dc_province.PROVINCE_NAME
			,dc_amphur.AMPHUR_NAME
			from st_user_group_dc left join st_user_group_dc_detail
			on  st_user_group_dc.dc_groupid= st_user_group_dc_detail.dc_groupid left join dc_geography
			on st_user_group_dc_detail.dc_GeoId = dc_geography.GEO_CODE left join dc_province
			on st_user_group_dc_detail.dc_ProId = dc_province.PROVINCE_CODE left join dc_amphur
			on st_user_group_dc_detail.dc_ampId = dc_amphur.AMPHUR_CODE
			 where st_user_group_dc.dc_groupid='$dc_groupid' 
			 order by dc_geography.GEO_NAME asc
			 ,dc_province.PROVINCE_NAME asc
			 ,dc_amphur.AMPHUR_NAME asc";
	$qryType=sqlsrv_query($con,$sqlType,$params,$options);
	while($re2=sqlsrv_fetch_array($qryType)){ echo "<tr>"; 
	if($re2['GEO_NAME'] <> $GEO_NAME){echo "<td width='200'>&nbsp;&nbsp;&nbsp;".$re2['GEO_NAME'];} 
		else{echo "<td width='200'>&nbsp;&nbsp;&nbsp;";} $GEO_NAME=$re2['GEO_NAME'];
	if($re2['PROVINCE_NAME'] <> $PROVINCE_NAME){echo "</td><td width='200'>&nbsp;&nbsp;&nbsp;".$re2['PROVINCE_NAME'];}
		else{echo "</td><td width='200'>&nbsp;&nbsp;&nbsp;";} $PROVINCE_NAME=$re2['PROVINCE_NAME'];
	if($re2['AMPHUR_NAME'] <> $AMPHUR_NAME){echo "</td><td width='400'>&nbsp;&nbsp;&nbsp;".$re2['AMPHUR_NAME']; }
		else {echo "</td><td width='200'>&nbsp;&nbsp;&nbsp;"; }$AMPHUR_NAME=$re2['AMPHUR_NAME'];
	echo"</tr>";
	}//while
	
	?> </table>
	<?
	 $sql2="select DISTINCT  st_user_group_dc_cust.CustNum ,st_View_cust_web.*
	from st_user_group_dc_cust  left join st_View_cust_web
	on st_user_group_dc_cust.CustNum  = st_View_cust_web.CustNum
	where st_user_group_dc_cust.dc_groupid='$dc_groupid'";
	$qry2=sqlsrv_query($con,$sql2,$params,$options);
	if($qry2){echo "&nbsp;&nbsp;&nbsp;***หมายเหตุ : ร้านค้าที่ดูเพิ่ม<br>";}
	while($re2=sqlsrv_fetch_array($qry2))
	{
	echo "&nbsp;&nbsp;&nbsp;".$re2['CustNum']."  &nbsp;&nbsp;&nbsp;".$re2['CustName'];
	echo "&nbsp;&nbsp;&nbsp;จ.  ".$re2['PROVINCE_NAME'];
	echo "&nbsp;&nbsp;&nbsp;อ.  ".$re2['AMPHUR_NAME'];
	//echo "&nbsp;&nbsp;&nbsp;ต.  ".$re2['DISTRICT_NAME'];
	echo "<br>";
	}
	?>
	<br></td>
	<td align="center" valign= "top"><br>
	<a href="?page=from_DC&do=del&id=<?=$dc_groupid;?>" onclick="return confirm('คุณต้องการลบข้อมูล DC หรือไม่?');" >
	<img src="./images/del.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	</tr>
	<? $r++;
	$GEO_NAME="";
	$PROVINCE_NAME="";
	$AMPHUR_NAME="";
	}//while ?>
	</table>
</td></tr>
</table>
</div>
</div>
</body>
</html>

