<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$txt_geo=trim($_POST['txt_geo']);//ภาค
$txt_pro=trim($_POST['txt_pro']);//จังหวัด
$txt_aum=trim($_POST['txt_aum']);//อำเภอ
$txt_dis=trim($_POST['txt_dis']);//ตำบล

$txt_idCust=trim($_POST['txt_idCust']);
$txt_name =trim($_POST['txt_name']);
$txtDC = trim($_POST['txtDC']);
if($txtDC){$sql="select a.*,tbU.name,tbU.surname,tbU2.name as name2,tbU2.surname  as surname2 from st_View_CustInDc_web a  
left join st_user tbU on a.Updateby = tbU.User_id
left join st_user tbU2 on a.Createby = tbU2.User_id
where a.dc_groupid='$txtDC' ";
	if($txt_idCust){$sql.="and  a.CustNum like '$txt_idCust%' ";}
	if($txt_name){$sql.="and a.CustName like '%$txt_name%' ";}
	if($txt_geo){$sql.="and a.GEO_ID='$txt_geo' ";}
	if($txt_pro){$sql.="and a.PROVINCE_CODE='$txt_pro' ";}
	if($txt_aum){$sql.="and a.AMPHUR_CODE='$txt_aum' ";}
	if($txt_dis){$sql.="and a.DISTRICT_CODE='$txt_dis' ";}
}
else
{

$sql="select  a.*,tbU.name,tbU.surname,tbU2.name as name2,tbU2.surname  as surname2 from st_View_cust_web a  
left join st_user tbU on a.Updateby = tbU.User_id
left join st_user tbU2 on a.Createby = tbU2.User_id ";
if($txt_idCust)
{ 	$sql.="where a.CustNum like '$txt_idCust%' ";
	if($txt_name){$sql.="and a.CustName like '%$txt_name%' ";}
	if($txt_geo){$sql.="and a.GEO_ID='$txt_geo' ";}
	if($txt_pro){$sql.="and a.PROVINCE_CODE='$txt_pro' ";}
	if($txt_aum){$sql.="and a.AMPHUR_CODE='$txt_aum' ";}
	if($txt_dis){$sql.="and a.DISTRICT_CODE='$txt_dis' ";}
}
else if($txt_name)
{ 	$sql.="where a.CustName like '%$txt_name%' ";
	if($txt_geo){$sql.="and a.GEO_ID='$txt_geo' ";}
	if($txt_pro){$sql.="and a.PROVINCE_CODE='$txt_pro' ";}
	if($txt_aum){$sql.="and a.AMPHUR_CODE='$txt_aum' ";}
	if($txt_dis){$sql.="and a.DISTRICT_CODE='$txt_dis' ";}
}
else if($txt_pro)
{ 	$sql.="where  a.PROVINCE_CODE='$txt_pro' ";
	if($txt_aum){$sql.="and a.AMPHUR_CODE='$txt_aum' ";}
	if($txt_dis){$sql.="and a.DISTRICT_CODE='$txt_dis' ";}
}

}
$sql.="order by   a.PROVINCE_CODE asc ,a.AMPHUR_CODE asc, a.DISTRICT_CODE asc,a.CustName asc ";
//echo $sql;

echo $Excel;
$qry=sqlsrv_query($con,$sql);
$r=1;
?>
<br>




<style type="text/css">
#mouseOver {
        display: inline;
        position: relative;
    }
    
    #mouseOver #img2 {
		z-index: 1-2000;
        position: absolute;
		left:230px;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: 20px;
    }
    
    #mouseOver:hover #img2 {
        opacity: 1;
        transition-duration: 400ms;
    }

	 #mouseOver #img3 {
		z-index: 1-2000;
        position: absolute;
		left:0;
        transform: translate(-100%);
        bottom: 0em;
        opacity: 0;
        pointer-events: none;
        transition-duration: 800ms; 
		top: -5px;
		font-family: Tahoma;
		font-size: 20px;
    }
    
    #mouseOver:hover #img3 {
        opacity: 1;
        transition-duration: 400ms;
		
    }




</style> 
<table cellpadding="0" cellspacing="0"  border="1"  >
	<tr><td colspan="20">Total : <? $qryrow2=sqlsrv_query($con,$sql,$params,$options);$row=sqlsrv_num_rows($qryrow2); echo number_format($row);?></td></tr>
	<tr>
	<td align="center" width="50">ลำดับ </td>
	<td align="center" width="150">รหัสร้านค้า </td>
	<td align="center" width="50">รูป</td>
	<td align="center" width="50">อัลบัม</td>
	<td align="center" width="150">ชื่อร้านค้า </td>
	<td align="center" width="150">เบอร์โทร</td>
	<td align="center" width="150">ที่อยู่</td>
	
	<td align="center" width="150">ตำบล</td>
	<td align="center" width="150">อำเภอ</td>
	<td align="center" width="150">จังหวัด</td>
	<td align="center">รหัสไปรษณีย์</td>
	<td align="center">latitude</td>
	<td align="center">longitude</td>
	<td align="center">ประเภทร้าน</td>
	<td align="center">Update</td>
	</tr>
	<? while($re=sqlsrv_fetch_array($qry)){ if($r%2==0){ $col="#EEEEEE";}else{$col="#F2FAEB";}?>
	<tr class="mousechange" bgcolor="<?=$col;?>" height="30" >
	<td align="center"><?=$r;?></td>
	<td align="left">&nbsp;&nbsp;<?=$re['CustNum'];?></td>
	<td align="center ">
	<? $Photo= $re['Cust_pic'];
	if ($Photo)//โชว์รูปภาพและ เช็คบล็อกที่จะลบรูป 
	{
			if($Excel=="2")
			{
			echo "มีรูปร้าน";
			
			}
			else
			{
			/*echo "<a href='#'><span id='mouseOver'><img id='img2'src ='http://saletool-api.carabao.co.th/$Photo' width='200' height='200'>";
			echo "<img src ='images/icon-image.png' >";
			echo "</span></a> ";*/
			echo "<img id='img2'src ='http://saletool-api.carabao.co.th/$Photo' width='100' height='70'>";
			
			}
	}
	?>
	</td>
	<td align="center ">
	<?
	$sqlPacDetail="select a.CustNum
				,a.File_Name
				,a.PhotoLocation
				,a.TimeStamp
				,a.User_id
				,a.pic_group_id
				,b.pic_group_name
				from st_photo_detail a left join st_photo_group b
				on a.pic_group_id = b.pic_group_id
				where a.CustNum='$re[CustNum]'";
	$sqlPacDetail=sqlsrv_query($con,$sqlPacDetail,$params,$options);
	$rowsqlPacDetail=sqlsrv_num_rows($sqlPacDetail); 
	//echo $rowsqlPacDetail;
	if($rowsqlPacDetail>="1"){
	
			if($Excel=="2")
			{
			echo "มีอัลบัมรูป";
			
			}
			else
			{
			echo "<a href='fancyBox/showImgCust.php?&id=".$re['CustNum']."' target='_blank' >";
			echo "<span id='mouseOver'><div id='img3'>".$rowsqlPacDetail."</div>";
			echo "<img src ='images/My-Pictures-icon.png' widih='20px' height='20px'>";
			echo "</span>";
			echo "</a> ";
			}
	}
	?>

<!-- Howls in the moonlight! -->
</span>



	</td>
	<td align="left">&nbsp;<?=$re['CustName'];?></td>
	<td align="left">&nbsp;<?=$re['Phone'];?></td>
	<td align="left">&nbsp;<?=$re['AddressNum'];?></td>
	
	<td align="left">&nbsp;<?=$re['DISTRICT_NAME'];?></td>
	<td align="left">&nbsp;<?=$re['AMPHUR_NAME'];?></td>
	<td align="left">&nbsp;<?=$re['PROVINCE_NAME'];?></td>
	<td align="left">&nbsp;<?=$re['POSTCODE'];?></td>
	<td align="left">&nbsp;<?=$re['lat'];?></td>
	<td align="left">&nbsp;<?=$re['long'];?></td>
	<td align="left">&nbsp;<?=$re['cust_type_name'];?></td>
	<td align="left"><? if($re['name']){ echo $re['name'];} else if($re['name2']) { echo $re['name2'];}?></td>
	</tr>
	<? 
	$r++;}//while ?>
	</table>
	
	
	 