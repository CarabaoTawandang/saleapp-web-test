<?include("../includes/config.php");

$txt_geo=$_POST['txt_geo'];
$txt_pro=$_POST['txt_pro'];
$txt_aum=$_POST['txt_aum'];
$txt_dis=$_POST['txt_dis'];
$sql3="SELECT  DISTINCT CustNum,CustName FROM st_cust where ";// GEO_ID like'%$txt_geo%' 
			if($txt_pro){$sql3.="PROVINCE_CODE='$txt_pro' ";}
			if($txt_aum){$sql3.=" and AMPHUR_CODE='$txt_aum' ";}
			if($txt_dis){$sql3.=" and DISTRICT_CODE='$txt_dis' ";}
			$sql3.="order by CustName asc  ";
	//echo $sql3;
	
				$params = array();
				$options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
				$qry3=sqlsrv_query($con,$sql3,$params,$options);
				$row3=sqlsrv_num_rows($qry3);//echo $sql3;

?>
<select id="txt_CUST" name="txt_CUST"   style="width:300px;background:#FFFFCC;">

<? if($row3>0){echo"<option value=''>- เลือกร้านค้า -</option>";}else{echo"<option value=''>- ไม่มีร้านค้า -</option>";}
			
				for($i=0;$i<$row3;$i+=1)
				{
				$detail3=sqlsrv_fetch_array($qry3);
			?>
			<option value="<?print $detail3['CustNum']?>"><?print $detail3['CustName']   ?></option>
					
				<?
				
			
				}	
				
				
			
				?>
				</select>