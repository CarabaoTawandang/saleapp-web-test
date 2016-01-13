<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		
		$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$txtNameDC=$_POST['txtNameDC'];
$txtGeo = $_POST['txtGeo'];
$txt_COMPANY =$_POST['txt_COMPANY'];
$id=$_POST['txtID'];		
				$sqlDel1="delete st_user_group_dc where dc_groupid='$id'";
				$qryDel1=sqlsrv_query($con,$sqlDel1,$params,$options);//delete  Table DC หลัก
				
				$sqlDel2="delete st_user_group_dc_detail where dc_groupid='$id'";
				$qryDel2=sqlsrv_query($con,$sqlDel2,$params,$options);//delete  Table DC detail
				
				$sqlSave1="insert into st_user_group_dc (dc_groupid,dc_groupname,Createby ,Updateby,CreateDate,UpdateDate
				,Updatestatus,COMPANYCODE) 
				values ('$id','$txtNameDC','$USER_id','$USER_id',GETDATE(),GETDATE(),'1','$txt_COMPANY')";
				$qrySave1=sqlsrv_query($con,$sqlSave1,$params,$options);//add เข้า Table DC หลัก
				
				$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
				$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
				
/*for($i=1;$i<=77;$i++)
{
	if($_POST['R_amp_'.$i])
	{ 
	 $a=$_POST['R_amp_'.$i];
	
	
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
{ //echo "<br>*****".$result;
		
	 $DetailAmp = $_POST['DetailAmp'];
	foreach ($DetailAmp as $DetailAmps=>$DetailAmp) 
	{  //echo "<br> อ. ".$DetailAmp;
				$sqlAmp22="SELECT  PROVINCE_CODE FROM dc_province where  PROVINCE_ID='$result' ";
				$qryAmp22=sqlsrv_query($con,$sqlAmp22,$params,$options);
				$reAmp22=sqlsrv_fetch_array($qryAmp22);
	
		$sqlAmp="SELECT  GEO_ID,PROVINCE_ID,AMPHUR_CODE FROM dc_amphur where  AMPHUR_CODE='$DetailAmp' and PROVINCE_ID='$result' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qryAmp=sqlsrv_query($con,$sqlAmp,$params,$options);
		$reAmp=sqlsrv_fetch_array($qryAmp);
		if($reAmp['AMPHUR_CODE'])
			{	//echo "<br> ภ.  ".$reAmp['GEO_ID']; echo "  จ.  ".
				$Pro2[]=$reAmp['PROVINCE_ID'];  
				//echo "  อ. ".$reAmp['AMPHUR_ID'];
				$sqlSave2="insert into st_user_group_dc_detail (dc_groupid,dc_GeoId,dc_ProId,dc_ampId,Updatestatus) values
				('$id','$reAmp[GEO_ID]','$reAmp22[PROVINCE_CODE]','$reAmp[AMPHUR_CODE]','1')";
				$qrySave2=sqlsrv_query($con,$sqlSave2,$params,$options);//add เข้า Table DC Detail
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
				('$id','$reAmp2[GEO_ID]','$reAmp22[PROVINCE_CODE]','$reAmp2[AMPHUR_CODE]','1')";
				$qrySave3=sqlsrv_query($con,$sqlSave3,$params,$options);//add เข้า Table DC Detail
		
			}
		}



}
if($qrySave1){	?>
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
				
			?>
	

