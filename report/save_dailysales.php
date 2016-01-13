<?
session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$flag = 0;
	   $USER_id				=	$_SESSION["USER_id"];	//รหัสUser
$do =  $_POST['do']; 
$dc =  $_POST['dc_group']; 
$date_to =  $_POST['date_to']; 
   
			$file = $_FILES['txt_file']['tmp_name'];//เท็มสำหรับการอัพโหลดเก็บที่อยู่ไฟล์ชั่วคราว
			$file_name=$_FILES['txt_file']['name'];//ชื่อไฟล์ที่อัพโหลด
			$file_type=$_FILES['txt_file']['type'];//ประเภทชนิดของไฟล์
			$file_size=$_FILES['txt_file']['size'];//ขนาดไฟล์หน่วยเก็บเป็นไบต์

			if($file)
			{
			$array_last = explode(".", $file_name);//แยกข้อความให้อยู่ในรูปของอะเรย์
			$c = count($array_last)-1;
			$lastname = strtolower($array_last[$c]);//เปลี่ยนอักษรในสติงเป็นอักษรเล็ก
				if ($file_name and($lastname=="pdf" ))//เซฟรูปที่นามสกุลถูก 
				{ 	$set_file = explode("." ,$file_name);
					
					
					$CheckFile="select id from st_dailysales_file where Dc_groupid='$dc' and Date_pay='$date_to' ";
					$CheckFile=sqlsrv_query($con,$CheckFile);
					$CheckFile=sqlsrv_fetch_array($CheckFile);
					
					if($CheckFile['id'])
					{$id=$CheckFile['id'];
					
					$fileDel='../dailysales_file/'.$id.'.pdf';
					unlink($fileDel);
					$filenameNew = $id;//ชื่อไฟล์ที่ตั้งใหม่
					$plname = $set_file[1];
					$filenameNew = $filenameNew .".".pdf;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
					$folder ='../dailysales_file/'.$filenameNew;
						if (copy($file,$folder))  $Check="นำ file PDF เข้า Foder update แล้ว ";	
						{ 	//echo 'update';
							$sqlUpdateFile="update st_dailysales_file set 
							Dc_groupid ='$dc'
							,Date_pay = '$date_to'
							,id_file ='$filenameNew'
							,UpdateBy ='$USER_id'
							,CreateBy ='$USER_id'
							,UpdateDate =GETDATE() where id ='$id' ";
							$UpdateFile=sqlsrv_query($con,$sqlUpdateFile);
						}
					}
					else if(!$CheckFile['id'])
					{	 $sqlMax="select count(Dc_groupid)  as MaxID from st_dailysales_file
							where   SUBSTRING(id,2,2) ='$year' and Dc_groupid ='$dc'";
							$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
							$reMax=sqlsrv_fetch_array($qryMax);
							$MaxID=$reMax['MaxID']; 
							$MaxID= $MaxID+1;
							$MaxID =str_pad($MaxID,3,"0",STR_PAD_LEFT);
							$id ="F".$year."-".$dc."-".$MaxID ; //----------------------ID CODE 
							$filenameNew = $id;//ชื่อไฟล์ที่ตั้งใหม่
							$plname = $set_file[1];
							$filenameNew = $filenameNew .".".pdf;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
							$folder ='../dailysales_file/'.$filenameNew;
							copy ($file, $folder);//โพร์เดอร์สำหรับเก็บรูปภาพ
							if (copy($file,$folder)) { $Check= "นำ file PDF เข้า Foder insert แล้ว ";	
							$sqlInsertFile="insert into st_dailysales_file(id ,Dc_groupid ,Date_pay,id_file ,CreateBy ,CreateDate) 
							values('$id' ,'$dc' ,'$date_to','$filenameNew' ,'$USER_id' ,GETDATE())";
							$InsertFile=sqlsrv_query($con,$sqlInsertFile);}
					}
							
						
						/*if($InsertFile){echo $Check."  ***Insert แล้ว";}
						else if($UpdateFile){echo $Check." ****Update แล้ว";}
						*/
						
					}//เช็คนามสกุล
					else
					{
						echo '<script type="text/javascript">';
						echo "alert('ไม่บันทึกไฟล์เอกสารนี้');";
						echo '</script>';
					}
					
				}//ถ้ามีไฟล์


		
			
 $sqlOp="select * from st_user  where dc_groupid='$dc' and RoleID_Lineid = '6_2'";   // select  เพื่อ Insert ข้อมูลของ DC นั้น 
  $qryOp=sqlsrv_query($con,$sqlOp);
	while($deOp=sqlsrv_fetch_array($qryOp))
	{                       ///   วนรอบตามจำนวนเซลที่มี โดยแยกตาม Sale
        $sale_id = $deOp["User_id"]; 
        $salecode = $deOp["Salecode"]; 
         $Pay_diff = "txtPay_diff_".$sale_id;
         $Pay_total =  "txtPay_total_".$sale_id;
         $Bank =  "txtBank_".$sale_id;
         $R_num = "txtR_num_".$sale_id;
         $Total = "total_".$sale_id;
		 $R_Detail ="txtR_Detail_".$sale_id;
		 $dis_S ="txtdis_S_".$sale_id;
		 
         $txtPay_diff =  $_POST[$Pay_diff];
          $txtPay_total = $_POST[$Pay_total];
          $txtBank   = $_POST[$Bank];
          $txtR_num   =  $_POST[$R_num];
          $txtTotal  = $_POST[$Total];
		  $txtR_Detail =$_POST[$R_Detail];
		  $txtdis_S =$_POST[$dis_S];

         if($do == "insert") {   //// Insert
          $sql="insert into st_dailysales(User_id,Salecode,Dc_groupid,Total,Pay,Pay_diff,Bank,Receipt_number,Date_pay,CreateBy,CreateDate,detail,disS) values
			('$sale_id','$salecode','$dc','$txtTotal','$txtPay_total','$txtPay_diff','$txtBank','$txtR_num','$date_to','$USER_id',GETDATE(),'$txtR_Detail','$txtdis_S')";
			
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry=sqlsrv_query($con,$sql); 
		
		if($qry){
			$flag = 1;
		}else {

		echo "<br>".$sql;
		}
           } ///Insert 

            elseif($do == "update") { //Update 
		$sql="update st_dailysales set 
	
		
	     Total='$txtTotal'
		,Pay='$txtPay_total'
		,Pay_diff='$txtPay_diff'
		,Bank='$txtBank'
		,Receipt_number='$txtR_num'
		,Updateby='$USER_id'
		,UpdateDate=GETDATE()
		,detail='$txtR_Detail'
		,disS ='$txtdis_S'
		";		
		$sql.="where Dc_groupid='$dc' and Date_pay = '$date_to' and User_id = '$sale_id'";
			
			
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
		$qry=sqlsrv_query($con,$sql,$params,$options); 
		
		
		
		if($qry){
			$flag = 1;
		}else {

		echo $sql;
		}
            }  // Update 
      }
      if($flag){	
				echo '<script type="text/javascript">';
				echo "alert('บันทึกข้อมลเรียบร้อยแล้ว');";
				echo "window.location='?page=form_dailysales';";
				
				echo '</script>';
				
			}//if
		else{
				echo '<script type="text/javascript">';
				echo 'alert("ตรวจสอบข้อมูลอีกที");';
				echo '</script>';
				 echo $sql;
			}
			
		?>