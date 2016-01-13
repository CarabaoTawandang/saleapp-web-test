<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
?>
<?
//echo " สินค้าที่เปลี่ยน  =".
$txt_chenge=trim($_POST['txt_chenge']);
								if($txt_chenge){ $sql2="select a.st_unit_id,a.st_unit_name,a.P_Code,a.st_unit_qty ,b.PRODUCTNAME
										from st_item_unit_con a left join st_item_product b
										on a.P_Code = b.P_Code
										where a.P_Code ='$txt_chenge' order by a.st_unit_qty desc ";
								  }
	
								$qry2=sqlsrv_query($con,$sql2);
								while($re2=sqlsrv_fetch_array($qry2)){
									$txt_chengeName =$re2['PRODUCTNAME'];
									$num="NumP_".$txt_chenge."_U_".$re2['st_unit_id'];
									$NumP_ =$_POST[$num];//ชื่อ text
									$st_unit_idChenge=$re2['st_unit_id']; //ชื่อหน่วย
									$st_unit_qtyChenge=$re2['st_unit_qty'];//หน่วยที่นำไปคูณ
									$num=$NumP_*$st_unit_qtyChenge; 	//คูณจำนวนหน่วยของสินค้า
									$Total1=$Total1+$num;
									}

				$stock ="select a.* from 
				st_warehouse_stock a left join st_user u
				on a.locationno = u.warehouse_locationNo
				where a.P_Code='$txt_chenge'  and u.User_id ='$USER_id'";
				$stock=sqlsrv_query($con,$stock);//----ปรับยอดstock
				$stock=sqlsrv_fetch_array($stock);
				$stock1=$stock['stock_count'];
				$stock1Balance = $stock1-$Total1; //stock เหลือของสินค้าที่นำมาแลก
				if($stock1Balance <0)
				{ 
						echo'<script type="text/javascript">';
						echo'alert("ขออภัยสินค้าที่เปลี่ยน: '.$txt_chengeName.' ระบุเกินจาก  stockคลัง ");';
						echo "window.location='?page=stockBalance';";
						echo '</script>';
						exit();
				}
				
				$stockUp1="update st_warehouse_stock set stock_count='$stock1Balance' where P_Code='$txt_chenge' and locationno='$stock[locationno]' ";
				$stockUp1=sqlsrv_query($con,$stockUp1);//----ปรับยอด stock เหลือของสินค้าที่นำมาแลก
				

//echo " <br>สินค้าที่ได้  = ".
$txt_receive = trim($_POST['txt_receive']);

$sql2="select a.st_unit_id,a.st_unit_name,a.P_Code,a.st_unit_qty ,b.PRODUCTNAME
										from st_item_unit_con a left join st_item_product b
										on a.P_Code = b.P_Code
										where a.P_Code ='$txt_receive' order by a.st_unit_qty desc ";//เปิดตารางเก็บหน่วย
				$qry2=sqlsrv_query($con,$sql2);
					while($re2=sqlsrv_fetch_array($qry2))
					{	$txt_receiveName =$re2['PRODUCTNAME']; 	
						$st_unit_id=$re2['st_unit_id']; //ชื่อหน่วย
						$st_unit_qty=$re2['st_unit_qty'];//หน่วยที่นำไปคูณ
						$NumP = "NumP_".$txt_receive."_U_".$st_unit_id;//ชื่อ text
						$re2['st_unit_name']." = ";
						$num=$_POST[$NumP]*$st_unit_qty; 	//คูณจำนวนหน่วยของสินค้า
						$Total2=$Total2+$num;
					}


				$stock ="select a.* from 
				st_warehouse_stock a left join st_user u
				on a.locationno = u.warehouse_locationNo
				where a.P_Code='$txt_receive'  and u.User_id ='$USER_id'";
				$stock=sqlsrv_query($con,$stock);//----ปรับยอดstock
				$stock=sqlsrv_fetch_array($stock);
				$stock2=$stock['stock_count'];
				$stock2Balance = $stock2+$Total2; //stock เหลือของสินค้าที่นำมาแลก
				
				$stockUp2="update st_warehouse_stock set stock_count='$stock2Balance' where P_Code='$txt_receive' and locationno='$stock[locationno]' ";
				$stockUp2=sqlsrv_query($con,$stockUp2);//----ปรับยอด stock เหลือของสินค้าที่นำมาแลก

$detail="เปลี่ยนของ  ".$txt_chenge."  [".$txt_chengeName."] จำนวน = ".$Total1." ".$st_unit_idChenge." ได้สินค้า ".$txt_receive." [".$txt_receiveName."] จำนวน ".$Total2." ".$st_unit_id;

//ECHO "<br>  หมายเหตุ  ".$detail;

$txt_location=$stock['locationno'];
$sqlMax="select SUBSTRING(max(receive_no),11,15) as MaxID from st_warehouse_stock_receive_head
where   SUBSTRING(receive_no,2,2) ='$year' and SUBSTRING(receive_no,5,5) ='$txt_location'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="R".$year."-".$txt_location."-".$MaxID ; //----------------------ID CODE 


				
$sqlInDetail="insert into st_warehouse_stock_receive_detail 
				(receive_no,P_Code,receive_qty,receive_unit,Remark,Createby,Updateby,CreateDate,UpdateDate,Updatestatus) values
				('$MaxID','$txt_receive','$Total2','$st_unit_id','$detail','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
$sqlInDetail=sqlsrv_query($con,$sqlInDetail);//add--detail

$txt_receive_date =$_POST['txt_receive_date'];//วันที่รับเอกสาร
$txt_receive_date =   date("Y-m-d",strtotime($txt_receive_date));

$sqlInHead="insert into st_warehouse_stock_receive_head
(receive_no,receive_date,receive_locationno,receive_Remark,Createby,CreateDate,Updatestatus) values
('$MaxID','$txt_receive_date','$txt_location','$detail','$USER_id',GETDATE(),'1')";
$sqlInHead=sqlsrv_query($con,$sqlInHead);//add--หลัก				
				

if($sqlInHead)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกการเปลี่ยนของเรียบร้อยแล้ว ");';
			echo "window.location='?page=data_receive_head&receive_no=$MaxID';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกการเปลี่ยนของ ไม่สำเร็จ!!!");';
			//echo "window.location='?page=stockBalance';";
			//echo $sqlIn1;
			echo '</script>';
	}
?>