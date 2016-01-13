<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
$year = substr(date('Y')+543,2,2);//----------------------------------ปีนี้

$txt_ref_docno =$_POST['txt_ref_docno'];//เลขที่PO
$txt_date =$_POST['txt_date'];//วันที่รับเอกสาร
$txt_date =   date("Y-m-d",strtotime($txt_date));
$txt_receive_Remark = $_POST['txt_receive_Remark'];//หมายเหตุการเบิก
$txt_location =$_POST['txt_location'];//คลังสินค้า
$txt_packName = trim($_POST['txt_packName']);//จ่ายให้ USER ไหน


$txt_item =$_POST['txt_item']; //สินค้า
$txt_receive_qty=$_POST['txt_receive_qty'];
$txt_unit =$_POST['txt_unit'];





$sqlMax="select SUBSTRING(max(picking_no),12,16) as MaxID from st_warehouse_stock_picking_head
where   SUBSTRING(picking_no,2,2) ='$year' and SUBSTRING(picking_no,5,6) ='$txt_packName'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="P".$year."-".$txt_packName."-".$MaxID ; //----------------------ID CODE 



			$sql="SELECT P_Code,PRODUCTNAME,st_unit_id  FROM st_item_product   ";//เปิดตารางเก็บสินค้าproduct
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1) //วนสินค้า
			{	$detail=sqlsrv_fetch_array($qry); $P_Code=$detail['P_Code'];
				$checkItem ="checkItem_".$P_Code;
				$item=$_POST[$checkItem];//ชื่อสินค้าที่มีการติก
				
				if($item)
				{
				$sql2="  select st_unit_id,st_unit_name,P_Code,st_unit_qty from st_item_unit_con where P_Code ='$item' order by st_unit_id asc ";//เปิดตารางเก็บหน่วย
				$qry2=sqlsrv_query($con,$sql2,$params,$options);
					while($re2=sqlsrv_fetch_array($qry2))
					{ 	$st_unit_id=$re2['st_unit_id']; //ชื่อหน่วย
						$st_unit_qty=$re2['st_unit_qty'];//หน่วยที่นำไปคูณ
						$NumP = "NumP_".$item."_U_".$st_unit_id;//ชื่อ text
						//echo " ".$re2['st_unit_name']." = ";
						$num=$_POST[$NumP]*$st_unit_qty; 	//คูณจำนวนหน่วยของสินค้า
						$Total=$Total+$num;
					}
				
				$Total;//ผลรวมของสินค้าที่เป็นหน่วยต่ำสุดแล้ว
				//echo "<br>";
				
				
				//echo "<br>";
				if($Total<>0)
				{
					$stock ="select *
					from st_warehouse_stock 
					where P_Code='$item'
					and locationno='$txt_location'";
					$stock=sqlsrv_query($con,$stock,$params,$options);//----เปิดstockคลัง
					$stock=sqlsrv_fetch_array($stock);
					$stock=$stock['stock_count'];
					if($stock<$Total)
					{
						echo'<script type="text/javascript">';
						echo'alert("ขออภัยสินค้า  : '. $detail['PRODUCTNAME']. ' ยอดในคลัง ไม่พอจ่ายคะ");';
						echo '</script>';
						
						
					
					}
					else
					{	
					$Total2=$Total2+$Total;//จำนวนทั้งหมดทุกสินค้า
					$sqlIn2="insert into st_warehouse_stock_picking_detail 
					(picking_no,P_Code,PRODUCTNAME,picking_qty,picking_unit,picking_Remark,Createby,Updateby,CreateDate ,UpdateDate,Updatestatus) values
					('$MaxID','$item','','$Total','$detail[st_unit_id]',' $txt_receive_Remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
					$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);//add--detail
				
					
					$stock=$stock-$Total;
					$stockUp="update st_warehouse_stock set stock_count='$stock' where P_Code='$item' and locationno='$txt_location' ";
					$stockUp=sqlsrv_query($con,$stockUp,$params,$options);//----ปรับยอดstockคลัง ***ลบ Stock ในคลัง
					
					$stockSale ="select *
					from st_warehouse_sale_stock 
					where P_Code='$item'
					and User_id='$txt_packName'";
					$stockSale=sqlsrv_query($con,$stockSale,$params,$options);//----เปิดstockท้ายรถ
					$stockSale=sqlsrv_fetch_array($stockSale);
					$stockSale=$stockSale['wh_stock_qty'];
					$stockSale=$stockSale+$Total;
					$stockSaleUp="update st_warehouse_sale_stock set wh_stock_qty='$stockSale' where P_Code='$item' and User_id='$txt_packName' ";
					$stockSaleUp=sqlsrv_query($con,$stockSaleUp,$params,$options);//----ปรับยอดstockท้ายรถ ***เพิ่ม Stock ท้ายรถ
					}//else
				}//if Total
				}//if item
				$Total ='';
			}//for

if($Total2<>0)
{		
$sqlIn1="insert into st_warehouse_stock_picking_head
(picking_no,ref_docno,picking_date,picking_user_id,picking_Remark,Createby,Updateby,CreateDate,UpdateDate,picking_locationno,Updatestatus) values
('$MaxID','$txt_ref_docno','$txt_date','$txt_packName','$txt_receive_Remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_location','1')";
$qryIn1=sqlsrv_query($con,$sqlIn1,$params,$options);//add--หลัก
			
$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
}

if($qryIn1)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกรับจ่ายของเข้ารถเรียบร้อยแล้ว ");';
			echo "window.location='?page=data_picking_head&picking_no=$MaxID';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ขออภัย บันทึกจ่ายของเข้ารถไม่สำเร็จ");';
			echo "window.location='?page=add_picking_head';";
			echo '</script>';
	}

?>
