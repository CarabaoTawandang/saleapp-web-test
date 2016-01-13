<?
session_start();
set_time_limit(0);
include("../includes/config.php");
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ



$txt_receive_date =$_POST['txt_receive_date'];//วันที่รับเอกสาร
$txt_receive_date =   date("Y-m-d",strtotime($txt_receive_date));
$txt_location =$_POST['txt_location'];//คลังสินค้า
$txt_receive_qty=$_POST['txt_receive_qty'];
$txt_unit =$_POST['txt_unit'];
$txt_ref_docno =$_POST['txt_ref_docno']; //เลขที่PO
$txt_receive_Remark = $_POST['txt_receive_Remark'];
$txt_packName =trim($_POST['txt_packName']);
$txt_ref_pack =$_POST['txt_ref_pack'];

if($_GET['do']=="edit")
{	//echo "edit";
	$txt_receive_no =$_POST['txt_receive_no'];
	
	$sqlIn1="update st_warehouse_stock_receive_head set
	ref_docno='$txt_ref_docno'
	,receive_date='$txt_receive_date'
	,receive_locationno='$txt_location'
	,receive_Remark='$txt_receive_Remark'
	,Updateby='$USER_id'
	,Createby=GETDATE()
	,Updatestatus='1'
	,receive_user_id='$txt_packName'
	,ref_pack='$txt_ref_pack'
	where receive_no='$txt_receive_no'";
	$qryIn1=sqlsrv_query($con,$sqlIn1);//update H--หลัก
	
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser);
	
	//คืนคลังก่อน 
	$sqlReture="select a.P_Code,a.receive_qty,b.receive_locationno
	from st_warehouse_stock_receive_detail a left join st_warehouse_stock_receive_head b on a.receive_no =b.receive_no
	where a.receive_no='$txt_receive_no' ";
	$sqlReture=sqlsrv_query($con,$sqlReture);
	while($Reture=sqlsrv_fetch_array($sqlReture))
	{
		 $ReItem =$Reture['P_Code']; 
		$ReWhereH=$Reture['receive_locationno'];
		$ReQty  =$Reture['receive_qty']; 
		
				$stock ="select *
				from st_warehouse_stock 
				where P_Code='$ReItem'
				and locationno='$ReWhereH'";
				$stock=sqlsrv_query($con,$stock);//----ปรับยอดstock คลัง
				$stock=sqlsrv_fetch_array($stock);
				
				$stock=$stock['stock_count'];
				$stockSum=$stock-$ReQty;
				$stockUp="update st_warehouse_stock set stock_count='$stockSum' where P_Code='$ReItem' and locationno='$ReWhereH' ";
				$stockUp=sqlsrv_query($con,$stockUp);//-----ปรับยอดstock คลัง
				
		 
		
	}
	//ลบDetail
	$sqlDelDetail="delete st_warehouse_stock_receive_detail where  receive_no='$txt_receive_no'  ";
	$sqlDelDetail=sqlsrv_query($con,$sqlDelDetail);
	
	
	//ADD Detail ใหม่	
	
	
			$sql="SELECT st_unit_id,P_Code,PRODUCTNAME,st_unit_id  FROM st_item_product   ";//เปิดตารางเก็บสินค้าproduct
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
				$qry2=sqlsrv_query($con,$sql2);
					while($re2=sqlsrv_fetch_array($qry2))
					{ 	$st_unit_id=$re2['st_unit_id']; //ชื่อหน่วย
						$st_unit_qty=$re2['st_unit_qty'];//หน่วยที่นำไปคูณ
						$NumP = "NumP_".$item."_U_".$st_unit_id;//ชื่อ text
						$re2['st_unit_name']." = ";
						$num=$_POST[$NumP]*$st_unit_qty; 	//คูณจำนวนหน่วยของสินค้า
						$Total=$Total+$num;
					}
				
				//echo "  = " .
				$Total;   //ผลรวมของสินค้าที่เป็นหน่วยต่ำสุดแล้ว
				$Total2=$Total2+$Total;
				
				if($Total<>0)
				{
				$sqlIn2="insert into st_warehouse_stock_receive_detail 
				(receive_no,P_Code,receive_qty,receive_unit,Remark,Createby,Updateby,CreateDate,UpdateDate,Updatestatus) values
				('$txt_receive_no','$item','$Total','$detail[st_unit_id]','$txt_receive_Remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
				$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);//add--detail
				
				$stock ="select *
				from st_warehouse_stock 
				where P_Code='$item'
				and locationno='$txt_location'";
				$stock=sqlsrv_query($con,$stock,$params,$options);//----ปรับยอดstock
				$stock=sqlsrv_fetch_array($stock);
				$stock=$stock['stock_count'];
				$stock=$stock+$Total;
				$stockUp="update st_warehouse_stock set stock_count='$stock' where P_Code='$item' and locationno='$txt_location' ";
				$stockUp=sqlsrv_query($con,$stockUp,$params,$options);//----ปรับยอดstock คลัง
				}//if Total
				}//if item
				$Total ='';
			}//for
	
	
	
	
	if($qryIn1)
	{
			echo'<script type="text/javascript">';
			echo'alert("แก้ไขรับของเข้าคลังเรียบร้อยแล้ว ");';
			echo "window.location='?page=data_receive_head&receive_no=$txt_receive_no';";
			
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("ไม่สำเร็จ");';
			echo $sqlIn1;
			echo '</script>';
	}
}











else{



$sqlMax="select SUBSTRING(max(receive_no),11,15) as MaxID from st_warehouse_stock_receive_head
where   SUBSTRING(receive_no,2,2) ='$year' and SUBSTRING(receive_no,5,5) ='$txt_location'";
$qryMax=sqlsrv_query($con,$sqlMax,$params,$options);
$reMax=sqlsrv_fetch_array($qryMax);
$MaxID=$reMax['MaxID']; 
$MaxID= $MaxID+1;
$MaxID =str_pad($MaxID,5,"0",STR_PAD_LEFT);
$MaxID ="R".$year."-".$txt_location."-".$MaxID ; //----------------------ID CODE 




			$sql="SELECT st_unit_id,P_Code,PRODUCTNAME,st_unit_id  FROM st_item_product   ";//เปิดตารางเก็บสินค้าproduct
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
				
				//echo "  = " .
				$Total;//ผลรวมของสินค้าที่เป็นหน่วยต่ำสุดแล้ว
				$Total2=$Total2+$Total;
				//echo "<br>";
				if($Total<>0)
				{
							$stockVan="select a.wh_stock_qty,b.st_unit_id
							from st_warehouse_sale_stock a left join st_item_product b
							on a.P_Code =b.P_Code
							where a.User_id='$txt_packName' and a.P_Code='$item'";
							$stockVan=sqlsrv_query($con,$stockVan);
							$stockVan=sqlsrv_fetch_array($stockVan);
							if($stockVan){ $wh_stock_qtyVAN=$stockVan['wh_stock_qty'];}
							//echo $wh_stock_qtyVAN." == ".$Total;
					
					if(($stockVan) &&($wh_stock_qtyVAN<$Total))
					{
						echo'<script type="text/javascript">';
						echo'alert("ขออภัยสินค้า : '.$item.' Stoct ท้ายรถไม่พอคืนคะ");';
						echo "window.location='?page=add_receive_head';";
						echo '</script>';
						exit();
						
					
					}
					
				$sqlIn2="insert into st_warehouse_stock_receive_detail 
				(receive_no,P_Code,receive_qty,receive_unit,Remark,Createby,Updateby,CreateDate,UpdateDate,Updatestatus) values
				('$MaxID','$item','$Total','$detail[st_unit_id]','$txt_receive_Remark','$USER_id','$USER_id',GETDATE(),GETDATE(),'1')";
				$qryIn2=sqlsrv_query($con,$sqlIn2,$params,$options);//add--detail
				
				$stock ="select *
				from st_warehouse_stock 
				where P_Code='$item'
				and locationno='$txt_location'";
				$stock=sqlsrv_query($con,$stock,$params,$options);//----ปรับยอดstock
				$stock=sqlsrv_fetch_array($stock);
				$stock=$stock['stock_count'];
				$stock=$stock+$Total;
				$stockUp="update st_warehouse_stock set stock_count='$stock' where P_Code='$item' and locationno='$txt_location' ";
				$stockUp=sqlsrv_query($con,$stockUp,$params,$options);//----ปรับยอดstock คลัง
				
					$stockSale ="select *
					from st_warehouse_sale_stock 
					where P_Code='$item'
					and User_id='$txt_packName'";
					$stockSale=sqlsrv_query($con,$stockSale,$params,$options);//----เปิดstockท้ายรถ
					$stockSale=sqlsrv_fetch_array($stockSale);
					$stockSale=$stockSale['wh_stock_qty'];
					$stockSale=$stockSale-$Total;
					$stockSaleUp="update st_warehouse_sale_stock set wh_stock_qty='$stockSale' where P_Code='$item' and User_id='$txt_packName' ";
					$stockSaleUp=sqlsrv_query($con,$stockSaleUp,$params,$options);//----ปรับยอดstockท้ายรถ ***เพิ่ม Stock ท้ายรถ
					
				}//if Total
					
				}//if item
				$Total ='';
			}//for
if($Total2<>0)
{		
$sqlIn1="insert into st_warehouse_stock_receive_head
(receive_no,ref_docno,receive_date,receive_locationno,receive_Remark,Createby,CreateDate,Updatestatus,receive_user_id,ref_pack) values
('$MaxID','$txt_ref_docno','$txt_receive_date','$txt_location','$txt_receive_Remark','$USER_id',GETDATE(),'1','$txt_packName','$txt_ref_pack')";
$qryIn1=sqlsrv_query($con,$sqlIn1,$params,$options);//add--หลัก
			
$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
}


if($qryIn1)
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกรับของเข้าคลังเรียบร้อยแล้ว ");';
			echo "window.location='?page=data_receive_head&receive_no=$MaxID';";
			echo '</script>';
	}
	else 
	{
			echo'<script type="text/javascript">';
			echo'alert("บันทึกรับของเข้าคลังไม่สำเร็จ");';
			echo "window.location='?page=data_receive_head';";
			//echo $sqlIn1;
			echo '</script>';
	}
}//else add
?>

