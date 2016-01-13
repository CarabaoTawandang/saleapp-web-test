<?//-------------------------------------------------by pong 23/07/2015
session_start();
set_time_limit(0);
include("../includes/config.php");
$USER_id				=	$_SESSION["USER_id"];	//รหัสพนักงาน
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);


if($_GET['do']=="edit")
{
	$id_P=$_POST['id_P'];//P_Code
	$id_unit=$_POST['id_unit'];//id unit
	$unit= $_POST['unit'];//หน่วย
	$count=$_POST['count'];//จำนวน
	$buy= $_POST['buy'];//ราคาซื้อ
	$sell= $_POST['sell'];//ราคาขาย
			
			
			
	echo $sqlUpdate="update st_item_unit_con set st_unit_qty='$count',Updateby='$USER_id'
	,UpdateDate=GETDATE() 
	where  st_unit_id='$id_unit'and P_Code='$id_P' "; 		
		$qryUpdate=sqlsrv_query($con,$sqlUpdate,$params,$options);
	
	echo $sqlUpdate2="update st_item_price set st_unit_qty='$count',st_sell_price='$sell',st_buy_price='$buy',Updateby='$USER_id'
	,UpdateDate=GETDATE()
	where  st_unit_id='$id_unit'and P_Code='$id_P' "; 		
		$qryUpdate2=sqlsrv_query($con,$sqlUpdate2,$params,$options);
		
			if($qryUpdate&&$qryUpdate2)
			  {
				echo "<script type=\"text/javascript\">";
				echo "alert(\"แก้ไขข้อมูลเรียบร้อยแล้ว\");";
				echo "window.location='?page=from_item';";
				echo "</script>";
				}
}else
if($_GET['do']=="del")
{
	 $id=$_GET['id'];
	 $id_=$_GET['id_'];
	
		$sqlDe2=" delete st_item_unit_con
		where P_Code='$id' and st_unit_id ='$id_' "; 
		$qryDe2=sqlsrv_query($con,$sqlDe2,$params,$options);
		
		$sqlDe3=" delete st_item_price
		where P_Code='$id' and st_unit_id ='$id_' "; 
		$qryDe3=sqlsrv_query($con,$sqlDe3,$params,$options);

	  $SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	  $qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);
	  if($sqlDe2&&$sqlDe3)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบสินค้า+หน่วย เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	}

else
{
	$txt_location=$_POST['txt_location'];//สินค้า
	$unit= $_POST['unit'];//หน่วย
	$count=$_POST['count'];//จำนวน
	$buy= $_POST['buy'];//ราคาซื้อ
	$sell= $_POST['sell'];//ราคาขาย

	
	
	
	
  $SQLIn2="insert into st_item_unit_con(st_unit_id,st_unit_name,
  Createby,Updateby,CreateDate,UpdateDate,P_Code,st_unit_qty) 
  values('$unit','$unit','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_location','$count') ";
	$QryIn2 =sqlsrv_query($con,$SQLIn2,$params,$options);//-----------Add หน่วย+
	
	
	$sql3="insert into st_item_price(st_unit_id,st_unit_name,Createby,Updateby
      ,CreateDate,UpdateDate,P_Code,st_unit_qty,st_buy_price,st_sell_price)
	  values('$unit','$unit','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_location','$count','$buy','$sell')";
	$QryIn3 =sqlsrv_query($con,$sql3,$params,$options);//----------Add ราคา
	

		
	$SqlUp_tbUser="update st_user set Updatestatus='1' where User_id='$USER_id'";
	$qryUp_tbUser =sqlsrv_query($con,$SqlUp_tbUser,$params,$options);

		if($QryIn2&&$qryUp_tbUser)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_item';
				</script>
				<?
			}
				
	}			
?>