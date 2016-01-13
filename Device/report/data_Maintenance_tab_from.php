<?
//------------------------------------------------------โดย PONG 14/10/2015-------------------
session_start();
set_time_limit(0);
include("../../includes/config.php");

$txt_all2 =$_POST['txt_all2'];
$txt_id2 =$_POST['txt_id2'];
$Equipment=$_POST['Equipment'];
$count2=$_POST['count2'];
$txt_imei=$_POST['txt_imei'];
$per_page = $count2;

$sql="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY ID_Maintenance) AS
rownum,ID_Maintenance,Serial_No,IMEI,Category,Description,Status
      ,Cost,Equipment,Date_receiver,Mac,UpdateDate,Createby FROM st_D_Maintenance where Equipment like'%$Equipment%'
	  and IMEI like '%$txt_imei%' and Mac like '%$txt_id2%' ) AS Table1 ";
$sql.="order by ID_Maintenance asc ";
$result=sqlsrv_query($con,$sql,$params,$options);
$num_rows=sqlsrv_num_rows($result);
	
?>
<html>
<body>
<?if($num_rows==0){echo"<p align='center'><b>----------ไม่พบข้อมูล------------</b></p>";}else{	?>
<table cellpadding="0" cellspacing="0"  border="0" align="left"  class="box" width="1200px">
<tr><td colspan="2"> 

	<table cellpadding="0" cellspacing="0" BORDERCOLOR="#FF9933" border="1" align="left"  width="1200px">
	<tr bgcolor="#FFCC99">
	<td align="center"><font size="2">ลำดับ</font></td>
	<td align="center"><font size="2">NO.</font></td>
	<td align="center"><font size="2">อุปกรณ์</font></td>
	<td align="center"><font size="2">IMEI</font></td>
	<td align="center"><font size="2">MAC</font></td>
	<td align="center"><font size="2">Serial No.</font></td>
	<td align="center"><font size="2">การซ่อม</font></td>
	<td align="center"><font size="2">คำอธิบาย</font></td>
	<td align="center"><font size="2">สถานะ</font></td>
	<td align="center"><font size="2">ค่าซ่อม</font></td>
	<td align="center"><font size="2">คนรับของ</font></td>
	<td align="center"><font size="2">วันที่ส่งซ่อม</font></td>
	<td align="center"><font size="2">วันที่อับเดต</font></td>
	
	<td align="center"><font size="2">แก้ไข</font></td>
	<td align="center"><font size="2">ลบ</font></td>


	</tr>
<style type="text/css">	
#container {
    width: 0 auto;
    margin: 0 auto;
    padding: 0px;

}

.pagination {
    background: #f2f2f2;
    padding: 20px;
    margin-bottom: 20px;
}

.page {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

</style> 
<?


$P=$per_page;
if(!$page_)

	if($_POST['do2']=="NOW")
	{
	$page__2=$_POST['page__2'];
	$page_=$page__2;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do2']=="NEXT")
	{
	$page__2=$_POST['page__2'];
	$page_=$page__2+1;
	$P=$per_page*$page_;

	}else
	
	if($_POST['do2']=="BEFORE")
	{
	$page__2=$_POST['page__2'];
	$page_=$page__2-1;
	$P=$per_page*$page_;

	}
	else{	
	$page_=1;
	
	}
	$prev_page=$page_-1;
	$next_page=$page_+1;
	

	$page_start=($per_page*$page_)-$per_page+1;
	
	
if($num_rows<=$per_page)
	$num_pages=1;
else if(($num_rows%$per_page)==0)
	$num_pages=($num_rows/$per_page);
else
	$num_pages=($num_rows/$per_page)+1;
	$num_pages=(int)$num_pages;

if(($page_>$num_pages)||($page_<0))
	echo"จำนวนรายการ เท่ากับ 0 รายการ";
	
	
$sql_="SELECT * FROM  (SELECT ROW_NUMBER() OVER(ORDER BY ID_Maintenance) AS
rownum,ID_Maintenance,Serial_No,IMEI,Category,Description,Status
      ,Cost,Equipment,Date_receiver,Mac,UpdateDate,Createby FROM st_D_Maintenance where Equipment like'%$Equipment%' 
	  and IMEI like '%$txt_imei%' and Mac like '%$txt_id2%'  ) AS Table1
WHERE rownum >= $page_start AND rownum <= $P ";


$sql_.="order by ID_Maintenance asc ";
$result_=sqlsrv_query($con,$sql_,$params,$options);


while ($re = sqlsrv_fetch_array($result_))
	
	/*while($re=sqlsrv_fetch_array($qrySearch))*/
	{{ $col="#FFFFCC";}
	
	$c="select Category_name from st_D_Maintenance_Category where Category_ID='$re[Category]' ";
	$c =sqlsrv_query($con,$c,$params,$options);
	$c=sqlsrv_fetch_array($c);
		
	$s="select  Status_NAME from st_D_Status where Status_ID='$re[Status]' ";
	$s =sqlsrv_query($con,$s,$params,$options);
	$s=sqlsrv_fetch_array($s);
	
	$uu="select  name from st_user where user_id='$re[Createby]' ";
	$uu =sqlsrv_query($con,$uu,$params,$options);
	$uu=sqlsrv_fetch_array($uu);
	
?>
	
	<tr bgcolor="<?=$col;?>" height="30">
	<td align="left"><font size="2">&nbsp;<?=$re['rownum']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['ID_Maintenance']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?if($re['Equipment']=='TL'){echo "Tablet";}else if($re['Equipment']=='MP'){echo "Moblie printer";}?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['IMEI']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Mac']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Serial_No']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$c['Category_name']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$re['Description']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$s['Status_NAME']; ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=number_format($re['Cost'],2); ?></font></td>
	<td align="left"><font size="2">&nbsp;<?=$uu['name']; ?></font></td>
	<td align="left"><font size="2"><?=date_format($re['Date_receiver'],'d/m/Y');?></font></td>
	<td align="left"><font size="2"><?=date_format($re['UpdateDate'],'d/m/Y');?></font></td>
	
	<td align="center">
		<a href="?page=edit_Maintenance&id=<?=$re['ID_Maintenance'];?>"  >
		<img src=".././images/edit.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	<td align="center">
		<a href="?page=save_Maintenance&do=del&id=<?=$re['ID_Maintenance'];?>" onclick="return confirm('คุณต้องการลบรายการซ่อมบำรุงนี้ใช่หรือไม่?');" >
		<img src=".././images/del.gif" style="cursor:pointer" alt="Complete"></a>
	</td>
	


	
	<? 
	}	
	?>

		</table><tr><td>
จำนวนรายการทั้งหมด:<b><?echo $num_rows;?></b>&nbsp;&nbsp;หน้าทั้งหมด:<b><?echo $num_pages?></b>
<div id="container">
	<div class="pagination">
<?
if($prev_page)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do2=BEFORE&page__2=$page_&S2=$txt_id2&txt_imei=$txt_imei&E=$Equipment&C2=$count2&A2=$txt_all2#tabs-3\">กลับไป&nbsp;</a>";
	
for($i=1;$i<=$num_pages;$i++)
{
if($i!=$page_)
	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do2=NOW&page__2=$i&S2=$txt_id2&txt_imei=$txt_imei&E=$Equipment&C2=$count2&A2=$txt_all2#tabs-3\">$i</a>";
	
	else
	echo"<b class='page active'>$i</b>";
	}
if($page_!=$num_pages)

	echo"<a class='page' href=\"$PHP_SELF?page=from_asset&do2=NEXT&page__2=$page_&S2=$txt_id2&txt_imei=$txt_imei&E=$Equipment&C2=$count2&A2=$txt_all2#tabs-3\">&nbsp;หน้าต่อไป</a>";
?></div></div>

<?}?></tr></td>


</td>
</tr>
</table>
</body>
</html>