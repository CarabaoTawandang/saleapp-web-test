<?
session_start();
include("../includes/config.php"); //connect database db.carabao.comฃ

$DCid=$_SESSION["DCid"];	
?>
								
											
											



<div class="div_this_item" style="overflow-y: auto;width: 90%; height: 400px; border-radius: 10px; padding: 2%; text-align: left; position: relative; margin: 0 ; margin-top: 2%; background-color: rgba(81,80,40, 0.2)">

<?php $a=1; 
    $array_id = $_POST['array_id'];
    foreach($array_id as $item){
        if(trim($item) != ''){
?>
        <div class="this_item ui-state-default"   >
            <input type="checkbox" class="checkbox" value="<?php echo $item;?>">
            <?php 
				
				
				 $sqlCheck="select CustNum,CustName,AddressNum,AddressMu 
				,DISTRICT_NAME,AMPHUR_NAME,PROVINCE_NAME,cust_type_name
				from st_View_CustInDc_web where dc_groupid='$DCid' and CustNum='$item' ";
				$qryCkeck=sqlsrv_query($con,$sqlCheck);
				$reCkeck=sqlsrv_fetch_array($qryCkeck);
					
					
					echo "<span style='cursor: pointer'>[".$a."] -". $item."" ;
					echo " ".$CustName=$reCkeck['CustName'];
					echo "  ที่อยู่  ".$reCkeck['AddressNum'];
					echo " ม.  ".$reCkeck['AddressMu'];
					echo " ต.  ".$reCkeck['DISTRICT_NAME'];
					echo " อ.  ".$reCkeck['AMPHUR_NAME'];
					echo " จ.  ".$reCkeck['PROVINCE_NAME'];
					echo " ".$reCkeck['cust_type_name'];
					echo "</span>";
					
?>
			
        </div>

<?php $a++;}}?>

</div>

