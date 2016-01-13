<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
		session_start();
		set_time_limit(0);
		include("../includes/config.php");
		$USER_id=	$_SESSION["USER_id"];	//รหัสพนักงาน
?>
<script type="text/javascript">
$(function()

});//function	
</script>


<?			include("../includes/config.php");
			$txt_chenge=trim($_POST['value']);
		
?>
<table border="0"><tr><td >&nbsp;&nbsp;จำนวน :</td>
<? 						

					if($txt_chenge){$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$txt_chenge' order by st_unit_qty desc ";
								  $P_Code= $txt_chenge;
								  }
					if($txt_receive){$sql2="  select st_unit_id,st_unit_name,P_Code
								  from st_item_unit_con
								  where P_Code ='$txt_receive' order by st_unit_qty desc ";
								   $P_Code= $txt_receive;
								  }
								$qry2=sqlsrv_query($con,$sql2);
						while($re2=sqlsrv_fetch_array($qry2)){
						?>
						<td>
						<input type="text"  id="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" name="NumP_<?=$P_Code;?>_U_<?=$re2['st_unit_id']?>" 
						 size="5" class="boxNo_<?=$P_Code;?>"  >
						 <? echo $re2['st_unit_name']?>
						</td>
						<?}//while ?>























				<td>
					
				
						<? 
						 //โชว์จำนวน Stock
						 if($txt_receive){ }
						 else {
								$sql3="select st_warehouse_stock.P_Code, st_warehouse_stock.stock_count ,st_item_product.st_unit_id 
								from st_warehouse_stock left join st_item_product
								on st_warehouse_stock.P_Code = st_item_product.P_Code left join st_user u
								on u.warehouse_locationNo= st_warehouse_stock.locationno
								where st_warehouse_stock.P_Code='$txt_chenge' and u.User_id='$USER_id'";
								$qry3=sqlsrv_query($con,$sql3);
								$detail3=sqlsrv_fetch_array($qry3);
						
							echo '<td>';
							echo '<font color="#FF0000">';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;stockคลัง : ';
							echo number_format($detail3['stock_count'])." ".$detail3['st_unit_id'];
							echo '</font>';
							echo '</td>';
						}
						?>
				</tr>
	



</table>