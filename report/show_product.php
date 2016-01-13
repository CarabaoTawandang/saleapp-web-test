<script type="text/javascript">
$(function()
{

<?			
			include("../includes/config.php");
			$sql="SELECT P_Code,PRODUCTNAME  FROM st_item_product ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry); $P_Code=$detail['P_Code'];
			
		
	?>

   $('#checkItem_<?=$P_Code;?>').change(function(){
		if (this.checked) 
				{ 	//alert('checked'); 
					$(".boxNo_<?=$P_Code;?>").removeAttr("disabled");
				} 
				else 
				{ 	 
					$(".boxNo_<?=$P_Code;?>").attr("disabled", "true");
				}
		
   });
	<?}//for ?>	
	
	
});//function	
</script>

<table>
<?			include("../includes/config.php");
			$txt_typePro=trim($_POST['txt_typePro']);
			$txt_location=trim($_POST['txt_location']);
			
			 
			 
			$sql="SELECT 
			st_item_product.P_Code
			,st_item_product.PRODUCTNAME 
			FROM st_item_product 
			where st_item_product.prd_type_id='$txt_typePro' order by st_item_product.P_Code ";
			
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
			$qry=sqlsrv_query($con,$sql,$params,$options);
			$row=sqlsrv_num_rows($qry);
			for($j=0;$j<$row;$j+=1){
			$detail=sqlsrv_fetch_array($qry);$P_Code=$detail['P_Code'];
			
						
		
?>
	
		
				<tr>
				<td>
					
					<input type="checkbox" id="checkItem_<?=$P_Code;?>" name="checkItem_<?=$P_Code;?>" value="<?print $P_Code;?>" >
					<?=$detail['PRODUCTNAME'];?>
				</td>
						<? 		$sql2="select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$detail[P_Code]' ";
								 if($detail['P_Code']=='FG310102' ||$detail['P_Code']=='FG9001001' 
								 ||$detail['P_Code']=='FG9001002'||$detail['P_Code']=='FG9001003') { $sql2.="and st_unit_id <>'ลัง'  "; 
								 }
								  
								  $sql2.="order by st_unit_qty desc ";
								  //echo "<br>".$sql2;
								$qry2=sqlsrv_query($con,$sql2,$params,$options);
								while($re2=sqlsrv_fetch_array($qry2)){
								
						?>
						<td>
						<input type="text"  id="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" name="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" 
						 size="5" class="boxNo_<?=$P_Code;?>" disabled >
						<?=$re2['st_unit_name']?>
						</td>
						<?}//while ?>
						
						<? 
						 $picking = $_POST['picking'];
						 $txt_packName =$_POST['txt_packName'];
						 $sqlCheck="select ";
						if($picking)
						{
							$sql3="select st_warehouse_stock.P_Code, st_warehouse_stock.stock_count
							,st_item_product.st_unit_id
							from st_warehouse_stock left join st_item_product on  st_warehouse_stock.P_Code = st_item_product.P_Code 
							where st_warehouse_stock.locationno='$txt_location'
							and st_warehouse_stock.P_Code='$P_Code'";
							$qry3=sqlsrv_query($con,$sql3);
							$detail3=sqlsrv_fetch_array($qry3);
						
							echo '<td>';
							echo '<font color="#FF0000">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;stockคลัง : ';
							echo number_format($detail3['stock_count'])." ".$detail3['st_unit_id'];
							echo '</font>';
							echo '</td>';
						}
						else if($txt_packName)
						{	$sql3="select a.wh_stock_qty,b.st_unit_id
							from st_warehouse_sale_stock a left join st_item_product b
							on a.P_Code =b.P_Code
							where a.User_id='$txt_packName' and a.P_Code='$P_Code'";
							$qry3=sqlsrv_query($con,$sql3);
							$detail3=sqlsrv_fetch_array($qry3);
							if($detail3){
							echo '<td>';
							echo '<font color="#FF0000">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;stockท้ายรถ  : ';
							echo number_format($detail3['wh_stock_qty'])." ".$detail3['st_unit_id'];
							echo '</font>';
							echo '</td>';}
						}
						?>
						
				</tr>
	
<?}
if(!$txt_typePro){echo "โปรดใส่ประเภทสินค้า";}
else if(!$txt_location){echo "โปรดใส่คลังสินค้า";}
else if($row<1){echo "ยังไม่มีสินค้าประเภทนี้";}
echo " <font color='red'>ตย. 20000  ไม่ต้องใส่ลูกน้ำ กรอกเฉพาะตัวเลขเท่านั้น</font>";
//for?>
</table>