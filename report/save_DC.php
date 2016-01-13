<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$txtNameDC=$_POST['txtNameDC'];
$txtGeo = $_POST['txtGeo'];
		$sqlMax="select SUBSTRING(max(dc_groupid),5,9) as MaxDC from st_user_group_dc";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
		$reMax=sqlsrv_fetch_array($qryMax);
$CodeId=$reMax['MaxDC']; //รหัสtaxi
$CodeId=$CodeId+1;
$year = substr(date('Y')+543,2,2);
$CodeIdShow ="DC".$year.str_pad($CodeId,5,"0",STR_PAD_LEFT);

				$sqlSave1="insert into st_user_group_dc (dc_groupid,dc_groupname,Createby,CreateDate,Updatestatus) 
				values ('$CodeIdShow','$txtNameDC','$USER_id',getdate(),'1')";
				//$qrySave1=sqlsrv_query($con,$sqlSave1,$params,$options);//add เข้า Table DC หลัก
				
				$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
				//$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
				
	/*$group='software';
$group_chk=array('hardware','software');
if(in_array($group, $group_chk)) {
echo $group_chk. 'have $group';
}

else {
echo $group_chk. 'havn’t $group';
}
	
	$txtPro = $_POST['txtPro'];
	foreach ($txtPro as $txtGeos=>$txtPro) //เอาจังหวัดใน Array $txtPro[] ใส่ใน  Array $ProGet[]
	{  echo "<br> ID จังหวัดนะ ";
		echo $ProGet=$txtPro; //id จังหวัดนะ
		
		
		
	}
	echo "<br>///////////////";
	
	$DetailAmp = $_POST['DetailAmp'];
	foreach ($DetailAmp as $DetailAmps=>$DetailAmp)
	{  echo "<br> CODE อำเภอนะ   ";echo $AmpGET=$DetailAmp; //CODE อำเภอนะ
	
				$selectAmp="select * from dc_amphur where AMPHUR_CODE='$AmpGET'";
				$qryAmp=sqlsrv_query($con,$selectAmp,$params,$options);
				$reAmpNo=sqlsrv_fetch_array($qryAmp);
				echo "  ID จังหวัดที่เลือกอำเภอ   ";
				echo $ProNo[]=$reAmpNo['PROVINCE_ID'];//Id จังหวัดที่จะตัดออก
				
	}	
echo "<br>///////////////";
	echo $ProNo[0];
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/*for($i=1;$i<=77;$i++)
{
	if($_POST['R_amp_'.$i])
	{ 
	 echo $a=$_POST['R_amp_'.$i];
	
	
		$b = explode("_", $a);
		$ProNo[]= $b[1]; //จ.ที่มีการ select เลือกอำเภอ
	
	}
}


foreach ($ProNo as $ProNos=>$ProNo) 
{ 
	 $ProGet[]=$ProNo;	//เอา จ.ที่ Select ใส่ใน  Array $ProGet[]

}
*/

$txtPro = $_POST['txtPro'];
	foreach ($txtPro as $txtGeos=>$txtPro) 
	{  $ProGet[]=$txtPro; //เอาจังหวัดใน Array $txtPro[] ใส่ใน  Array $ProGet[]
	}

	
	

$result = array_unique( $ProGet );
//print_r($result);

foreach ($result as $results=>$result) 
{ //echo  "<br> ID จังหวัดนะ    ".$result;
		
	 $DetailAmp = $_POST['DetailAmp'];
	foreach ($DetailAmp as $DetailAmps=>$DetailAmp) 
	{   "<br> อ. ".$DetailAmp;
		echo$sqlAmp="SELECT  GEO_ID,PROVINCE_ID,AMPHUR_CODE FROM dc_amphur where  AMPHUR_CODE='$DetailAmp' and PROVINCE_ID='$result' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryAmp=sqlsrv_query($con,$sqlAmp,$params,$options);
		$reAmp=sqlsrv_fetch_array($qryAmp);
		if($reAmp['AMPHUR_CODE'])
			{//echo "<br> ภ.  ".$reAmp['GEO_ID']; echo "  จ.  ".
				$Pro2[]=$reAmp['PROVINCE_ID'];  //echo "  อ. ".$reAmp['AMPHUR_ID'];
				$sqlSave2="insert into st_user_group_dc_detail (dc_groupid,dc_GeoId,dc_ProId,dc_ampId,Updatestatus) values
				('$CodeIdShow','$reAmp[GEO_ID]','$reAmp[PROVINCE_ID]','$reAmp[AMPHUR_CODE]','1')";
				//$qrySave2=sqlsrv_query($con,$sqlSave2,$params,$options);//add เข้า Table DC Detail
			}
		
		 
		
	}
	
		$group=$result;
		$group_chk=$Pro2;
		if(in_array($group, $group_chk)) {
		//echo " <br>have $group";
		}

		else {
		//echo " <br>havn’t $group";
		$sqlAmp2="SELECT  AMPHUR_CODE,GEO_ID FROM dc_amphur where  PROVINCE_ID='$group' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryAmp2=sqlsrv_query($con,$sqlAmp2,$params,$options);
		while($reAmp2=sqlsrv_fetch_array($qryAmp2))
		
			{ 
				$sqlAmp22="SELECT  PROVINCE_CODE FROM dc_province where  PROVINCE_ID='$group' ";
				$qryAmp22=sqlsrv_query($con,$sqlAmp22,$params,$options);
				$reAmp22=sqlsrv_fetch_array($qryAmp22);
				//echo "<br> ภ.  ".$reAmp2['GEO_ID']; echo "  จ.  ".$reAmp2['PROVINCE_ID'];  echo "  อ.  all";
				$sqlSave3="insert into st_user_group_dc_detail (dc_groupid,dc_GeoId,dc_ProId,dc_ampId,Updatestatus) values
				('$CodeIdShow','$reAmp2[GEO_ID]','$reAmp22[PROVINCE_CODE]','$reAmp2[AMPHUR_CODE]','1')";
				//$qrySave3=sqlsrv_query($con,$sqlSave3,$params,$options);//add เข้า Table DC Detail
		
			}
		}



}




/*if($qrySave1){	?>
				<script type="text/javascript">
					alert("บันทึกDCใหม่เรียบร้อย ");
					window.location='?page=show_DC&id=<?=$CodeIdShow;?>';
				</script>
				<?//echo $sqlSave1; echo "<br>".$sqlSave2;  echo "<br>".$sqlSave3;
			}//if
				else{?>
						<script type="text/javascript">
							alert("ตรวจสอบข้อมูลอีกที");
						</script>
				<? echo $sqlSave1; 
				}
			*/
			?>
	

