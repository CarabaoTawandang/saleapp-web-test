<?
session_start();
include("../includes/config.php"); //connect database db.carabao.comฃ

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>

<?php
  

   /* $a = $_POST["test"];
   foreach($a as $key => $value){
        foreach($value as $key_sub => $value_sub){
            echo "<br>".$a[$key][$key_sub]. "\n";
        }
        echo '<br>------------------------- ';
    }*/
 ?>
 
<table  style="width: 100%; border-collapse:collapse;color: #000"    border="1" bgcolor="#FFF" >
<thead>
        <tr style="text-align: center; background-color: #201f10; color: white">
		<td  rowspan="2" style="width:30px">ลำดับ</td>
		<td style="width:100px">กลุ่มคำถาม</td>
		<td style="width:200px">คำถาม</td>
		<td style="width:150px">ประเภทการตอบ</td>
		<td style="width:150px">อธิบายคำตอบ</td>
        <td  rowspan="2">หมายเหตุ</td> 
		<td style="width:100px">รูปของคำถาม</td> 
        </tr>
</thead>

<tbody class="div_this_item">
<?php $a=0; $t=1;

    $array_id = $_POST['array_id'];
	$array_id2 = $_POST['array_id2'];
	$array_id22 = $_POST['array_id22'];
	$array_id3 = $_POST['array_id3'];
	$array_id4 = $_POST['array_id4'];
	$array_detail = $_POST['array_detail'];
	$array_img = $_POST['array_img'];
	/*echo "<pre>";
	$data = $_POST['myArray'];
	print_r($data);
	echo "</pre>";
	*/
	//$array_id = array_filter( $array_id );	
    foreach($array_id as $array_ids)
	{	$b=0; $array_ids =trim($array_ids);
        if(	($array_ids!= 'undefined')
			&& ($array_ids != '')
			&&($array_id22[$a]!='' or $array_id2[$a][$b]!='')
			&& ($array_id3[$a] != '')
			)
		{	
		
			
			$Group[$a]=$array_ids; //echo " <br>  กลุ่ม   ".$Group[$a];
			//echo '<span style="cursor: pointer"> ';
			echo '<tr cursor: pointer class="this_item ui-state-default" >';
			
			
			echo '<td>';
			echo '<input type="checkbox" class="checkbox" value="'.$a.'">';
			echo '<input type="hidden" class="Group"  value="'.$Group[$a].'"> ';
			echo $t.'</td>';
			echo '<td>';
				if($Group[$a]=="อื่นๆ"){echo $Group[$a];}
				else {$sqlOp="select prd_type_id,prd_type_nm from st_item_type where  prd_type_id='$Group[$a]' ";
				$qryOp=sqlsrv_query($con,$sqlOp);
				$deOp=sqlsrv_fetch_array($qryOp);
				echo $deOp['prd_type_nm']; echo '</td>';//กลุ่ม
				}
			
				echo '<td >';
				IF($array_id22[$a]){echo $array_id22[$a];}
				ELSE{for($b=0;$array_id2[$a][$b]<>'';$b++)
				{	$ab =$array_id2[$a][$b];
					$SQLSearch="select P_Code,PRODUCTNAME from st_item_product where P_Code='$ab' ";
					$SQLSearch=sqlsrv_query($con,$SQLSearch);
					$Search=sqlsrv_fetch_array($SQLSearch);
					echo $Search['PRODUCTNAME']."<br>";
				}}
				
				echo '</td>';//คำถาม
			$type[$a] =$array_id3[$a];//echo " ประเภท   ".$type[$a];
			$Answer[$a]=$array_id4[$a];//echo "   ตอบ   ".$Answer[$a];
			
			echo '<td >'.$type[$a].'</td>';
			echo '<td >'.$Answer[$a].'</td>';
			echo '<td >';
			echo $array_detail[$a];
			echo '</td><td>';
			echo $array_img[$a];
			echo '</td>';
			
			echo '</tr>';
			
		
		
		
		$t++;
		}//if
		


	$a++; 
	}//foreach



?>

</tbody>
</table>
</body>
</html>