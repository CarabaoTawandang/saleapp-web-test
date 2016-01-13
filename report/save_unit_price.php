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
	$id_type=$_POST['id_type'];
	$buy= $_POST['buy'];//ราคาซื้อ
	$sell= $_POST['sell'];//ราคาขาย
			
			
			
	
	
	$sqlUpdate2="update st_item_price set st_sell_price='$sell',st_buy_price='$buy',Updateby='$USER_id'
	,UpdateDate=GETDATE()
	where  st_unit_id='$id_unit'and P_Code='$id_P' and SaleType='$id_type'"; 		
		$qryUpdate2=sqlsrv_query($con,$sqlUpdate2,$params,$options);
		
			if($qryUpdate2)
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
	 $id__=$_GET['id__'];
	 
		$sqlDe3=" delete st_item_price
		where P_Code='$id' and st_unit_id ='$id_' and SaleType='$id__' "; 
		$sqlDe3=sqlsrv_query($con,$sqlDe3,$params,$options);

	  
	  if($sqlDe3)
	  {
		echo "<script type=\"text/javascript\">";
		echo "alert(\"ลบหน่วย+ราคา เรียบร้อยแล้ว\");";
		echo "window.location='?page=from_item';";
		echo "</script>";
	  }
	}

else
{
	$txt_location=$_POST['txt_location'];//สินค้า
	$unit= $_POST['unit'];//หน่วย
	
	$buy= $_POST['buy'];//ราคาซื้อ
	$sell= $_POST['sell'];//ราคาขาย
	$Typesale=$_POST['Typesale'];
	
	$open="SELECT st_unit_qty FROM st_item_unit_con WHERE P_Code ='$txt_location'and st_unit_id='$unit' ";
	$open=sqlsrv_query($con,$open,$params,$options);
	$open=sqlsrv_fetch_array($open);
	
	$sql3="insert into st_item_price(st_unit_id,st_unit_name,Createby,Updateby
      ,CreateDate,UpdateDate,P_Code,st_unit_qty,st_buy_price,st_sell_price,SaleType)
	  values('$unit','$unit','$USER_id','$USER_id',GETDATE(),GETDATE(),'$txt_location','$open[st_unit_qty]','$buy','$sell','$Typesale')";
	$QryIn3 =sqlsrv_query($con,$sql3,$params,$options);//----------Add ราคา
	

		
	

		if($QryIn3)
	  {?>
				<script type="text/javascript">
					alert("บันทึกเรียบร้อยแล้ว ");
					window.location='?page=from_item';
				</script>
				<?
			}
				
	}			
?>