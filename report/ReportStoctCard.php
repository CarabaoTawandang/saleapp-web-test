<?//------------------------------------------------------แก้ไข โดย DREAM 10/07/2015------------------------------------
		session_start();
		set_time_limit(0);
		include("../includes/config.php");

		$txt_loca =trim($_POST['txt_loca']);
		$txt_item =trim($_POST['txt_item']);
		$txt_date1 =trim($_POST['txt_date1']);
		
		$txt_aDate =date("Y-m-d",strtotime("-1 days",strtotime($txt_date1 )));
		
		$sqlaa="select  top 1 
		a.receive_locationno ,d.locationname,d.Companyname,e.COMPANYNAME
		,b.P_Code,f.PRODUCTNAME, c.st_unit_qty,c.st_unit_id, sum(b.receive_qty) as SumRe 
		,sum(b.receive_qty)/ c.st_unit_qty as TotalUnitMaxaa
		from st_warehouse_stock_receive_head a left join st_warehouse_stock_receive_detail b on a.receive_no = b.receive_no 
		left join st_item_unit_con c on b.P_Code=c.P_Code left join st_warehouse_location d on a.receive_locationno = d.locationno
		left join st_companyinfo_exp e on d.Companyname = e.COMPANYCODE
		left join st_item_product f on b.P_Code =f.P_Code
		where a.receive_locationno='$txt_loca' 
		and b.P_Code ='$txt_item'
		and cast(a.receive_date as date) between '2015-01-01' and '$txt_aDate'
		group by a.receive_locationno,d.locationname,d.Companyname,e.COMPANYNAME ,b.P_Code,f.PRODUCTNAME, c.st_unit_qty,c.st_unit_id
		order by c.st_unit_qty desc
		";
		$sqlaa=sqlsrv_query($con,$sqlaa);
		$sqlaa=sqlsrv_fetch_array($sqlaa);
		
		//echo "<br>";
		
		$sqlbb="select top 1 sum(b.picking_qty) as Sum_picking_qty,c.st_unit_qty ,sum(b.picking_qty)/c.st_unit_qty as TotalPackMax
		from st_warehouse_stock_picking_head a left join st_warehouse_stock_picking_detail b on a.picking_no = b.picking_no  left join st_item_unit_con c on b.P_Code=c.P_Code
		where a.picking_locationno='$txt_loca'  
		and b.P_Code ='$txt_item'
		and cast(a.picking_date as date) between '2015-01-01' and '$txt_aDate'
		group by c.st_unit_qty
		order by c.st_unit_qty desc ";
		$sqlbb=sqlsrv_query($con,$sqlbb);
		$sqlbb=sqlsrv_fetch_array($sqlbb);
		
		
		
		//echo $sqlaa['TotalUnitMaxaa']."-".$sqlbb['TotalPackMax']." = ";
		$aa=$sqlaa['TotalUnitMaxaa']-$sqlbb['TotalPackMax'];
		
		$sql="select  top 1 
		a.receive_locationno ,d.locationname,d.Companyname,e.COMPANYNAME
		,cast(a.receive_date as date) as date ,b.P_Code,f.PRODUCTNAME, c.st_unit_qty,c.st_unit_id, sum(b.receive_qty) as SumRe 
		,sum(b.receive_qty)/ c.st_unit_qty as TotalUnitMax
		from st_warehouse_stock_receive_head a left join st_warehouse_stock_receive_detail b on a.receive_no = b.receive_no 
		left join st_item_unit_con c on b.P_Code=c.P_Code left join st_warehouse_location d on a.receive_locationno = d.locationno
		left join st_companyinfo_exp e on d.Companyname = e.COMPANYCODE
		left join st_item_product f on b.P_Code =f.P_Code
		where a.receive_locationno='$txt_loca' 
		and cast(a.receive_date as date)='$txt_date1' 
		and b.P_Code ='$txt_item'
		group by a.receive_locationno,d.locationname,d.Companyname,e.COMPANYNAME,cast(a.receive_date as date) ,b.P_Code,f.PRODUCTNAME, c.st_unit_qty,c.st_unit_id
		order by c.st_unit_qty desc
		";
		$sql=sqlsrv_query($con,$sql);
		$re=sqlsrv_fetch_array($sql);
		
		
		
		
?>
<BR><?=$sqlaa['COMPANYNAME'];?>
<BR>รายงานสินค้าคงเหลือ(Stock Card)
<BR>ณ วันที่ <?$date=date_create($txt_date1); echo date_format($date,"d-m-Y");?>
<BR><BR>
<BR>คลัง : <?=$sqlaa['locationname'];?> 
<BR>รหัสสินค้า : <?=$sqlaa['P_Code']." ".$sqlaa['PRODUCTNAME'];?> 
<table width="980" border="1" cellspacing="0" cellpadding="0">
<tr align="center"  bgcolor="#A0CD64">
<td width="100px">วันที่</td>
<td width="100px">รับ(<?=$sqlaa['st_unit_id'];?>)</td>
<td width="100px">จ่าย(<?=$sqlaa['st_unit_id'];?>)</td>
<td width="100px">คงเหลือ(<?=$sqlaa['st_unit_id'];?>)</td>
</tr>


<tr align="right" >
<td align="center" >ยอดยกมา</td>
<td> </td>
<td> </td>
<td><? echo number_format($aa); ?></td>
</tr>

<tr  align="right" >
<td align="center" ><?=date_format($re['date'],'d-m-Y');?></td>
<td><?  $TotalUnitMax =$re['TotalUnitMax']+$aa; echo  number_format($re['TotalUnitMax']); ?></td>
<td> </td>
<td><? echo number_format($TotalUnitMax); ?></td>
</tr>


<? 
 $sql2="select cast(a.picking_date  as date)  as date ,b.P_Code,b.picking_qty,a.picking_user_id , c.st_unit_qty,c.st_unit_id
		from st_warehouse_stock_picking_head  a left join st_warehouse_stock_picking_detail b
		on a.picking_no = b.picking_no  left join st_item_unit_con c on b.P_Code=c.P_Code
		where a.picking_locationno='$txt_loca' 
		and cast(a.picking_date as date)='$txt_date1' 
		and b.P_Code ='$txt_item' and st_unit_id ='ลัง' ";
		$sql2=sqlsrv_query($con,$sql2);
while($re2=sqlsrv_fetch_array($sql2)){?>
<tr class="mousechange" align="right" >
<td align="center" ><?=date_format($re2['date'],'d-m-Y');?></td>
<td></td>
<td><? $picking_qty= $re2['picking_qty']/$re2['st_unit_qty']; 
	echo number_format($picking_qty); 
	$TotalUnitMax =$TotalUnitMax - $picking_qty ;
	?></td>
<td><? echo number_format($TotalUnitMax); ?></td>
</tr>
<? } ?>



</table>