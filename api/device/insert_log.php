<?php  

include("config.php");
   $response = array();  
   if (isset($_POST['imei']) && isset($_POST['CreateDate']) && isset($_POST['CreateBy'])) {  
 
         /// GET DATA FROM ANDROID 
        $user =  $_POST['user'];
         $imei = $_POST['imei'];    
         $brand = $_POST['brand'];
         $model_phone = $_POST['model_phone'];
         $serial_number  = $_POST['serial_number'];
         $ram = $_POST['ram'];
         $rom = $_POST['rom'];
         $rom_free  = $_POST['rom_free'];
         $sim_id = $_POST['sim_id'];
         $UpdateBy = $_POST['CreateBy'];
         $UpdateDate = $_POST['CreateDate'];
         $CreateDate = $_POST['CreateDate'];
         $CreateBy = $_POST['CreateBy'];
         //////  Check  device_tablet_detail 

          if($user == '9999'){
          $status = 'Salestools';

         }else{
          $status = '-';
         }

                 $sql0="SELECT  *  ";
                    $sql0.="FROM  st_device_tablet_detail  ";
                        $sql0.="where imei ='$imei' ";
                    $params = array();
                     $options=  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                    $qry0=sqlsrv_query($con,$sql0,$params,$options);
                      $row0=sqlsrv_num_rows($qry0);
                      if($row0 > 0){
                                          $sql3="Update st_device_tablet_detail SET   "; 
                                          $sql3.=" memory='$rom',sim_id='$sim_id' ,memory_available='$rom_free',UpdateBy='$CreateBy'
                                                 ,UpdateDate='$CreateDate'  ";
                                          $sql3.=" Where imei='$imei' ";
                                          $params3 = array();
                                          $options3 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                                          $qry3=sqlsrv_query($con,$sql3,$params3,$options3);
                                          $detail3=sqlsrv_fetch_array($qry3);       

                              } // Update  Table 
                        else {
                                    $sql1="INSERT INTO st_device_tablet_detail (imei,manufacturer,model_num,serail_number
                                       ,ram,memory,memory_available,sim_id,CreateDate,CreateBy,Status)   ";   
                                    $sql1.="VALUES('$imei','$brand','$model_phone','$serial_number','$ram'
                                       ,'$rom','$rom_free','$sim_id','$CreateDate','$CreateBy','$status')   ";
                                    $params1 = array();
                                    $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                                    $qry1=sqlsrv_query($con,$sql1,$params1,$options1);
                                    $detail1=sqlsrv_fetch_array($qry1);

                        }  // Insert Device 
  
                ///// Insert  Log 
               $strSQL = "INSERT INTO st_device_log_login(user_id,imei,CreateDate,CreateBy)";
               $strSQL .="VALUES ";
               $strSQL .= "('".$user."','".$imei."','".$CreateDate."','".$CreateBy."')";
               $params2 = array();
               $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
               $qry2=sqlsrv_query($con,$strSQL,$params2,$options2); 
                // check if row inserted or not  
               if ($qry2) {  
                   $response["msg"] = 200;  
                   $response["message"] = "Insert Complete.";  
                   echo json_encode($response);  
                 } else {  
                   // failed to insert row  
                   $response["msg"] = 400;  
                   $response["message"] = "Error Insert";  
                   // echoing JSON response  
                   echo json_encode($response);  
                        }  
   }  else { // Data is NULL 
         $response["msg"] = 400;  
         $response["message"] = "Please insert Data";  
         // echoing JSON response  
         echo json_encode($response);  

   } 
?> 