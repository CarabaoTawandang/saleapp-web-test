<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
		$USER_id=	$_SESSION["USER_id"];	//User ที่เข้าระบบ
		$userType= $_SESSION["RoleID"];
		$userType2 = $_SESSION["RoleID_Lineid"];
		//echo $userType." / ".$userType2;
		$sqlRole="select RoleName_Linename from st_user_rolemaster_detail where RoleID_Lineid='$userType2' ";
		$sqlRole=sqlsrv_query($con,$sqlRole); 
		$sqlRole=sqlsrv_fetch_array($sqlRole);
		//$sqlRole['RoleName_Linename'];
?>
<nav id="ddmenu">
    
    <ul>
        <li class="no-sub"><a class="top-heading" href="?page=fromOriginal">Home</a></li>
		
		<?
		//ผู้จัดการศุนย์
		if ($_SESSION["RoleID_Lineid"]=="6_4" ){ 
		?>
			
			<li><a class="top-heading" href="?page=stockBalance">1.stock</a><!---?page=stockTotal--->
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
							
							<a href="?page=stockBalance" id="" >					1.1 stock ในคลัง</a>
							<a href="?page=stoc_salekBalance" id="" >				1.2 stock ท้ายรถ</a>
							<a href="?page=from_receive_head" id="" >				1.3 ข้อมูลรับของเข้าคลัง</a> 
							<a href="?page=from_picking_head" id="" >				1.4 ข้อมูลจ่ายของออกคลัง<br>หรือรับของเข้ารถ</a>
							
							</div>
				</div>
				</div>
			</li>
			<li><a class="top-heading" href="?page=from_plan">2.สร้างแผน</a></li>
			<li><a class="top-heading" href="?page=from_Inplan">3.วางแผน/วัน</a></li>
			<li><a class="top-heading" href="?page=from_Inplan2">4.วางแผน/เดือน</a></li>
			<li><a class="top-heading" href="?page=form_dailysales">5.สรุปยอดขายรายวัน</a></li>  <!---  Edit เพิ่มรายงาน ยอดขายรายวัน  --->
			
			
			<li class="no-sub"><a class="top-heading" href="?page=from_Quotation">6.ใบเสนอขาย</a></li>
			<li><a class="top-heading" href="#">รายงาน</a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
					<a href="?page=DetailProductSales">รายงานสรุปบิลรายวัน</a>
					<a  href="?page=form_dailysales2">รายงานสรุปยอดขายรายวัน(การเงิน)</a>
					<a  href="?page=form_ReportCN">รายงานยกเลิกบิลCN</a>
					</div>
				</div>
				</div>
			</li>
			<li class="no-sub"><a class="top-heading" href="dsr">ReportDSR</a></li>
				<? if($_SESSION["RoleID_Lineid"]=="7_1"){ //-------------------------------------------------------------น้านง ?>
				<li><a href="?page=from_cust" id="" >				ข้อมูลร้านค้า</a></li> 
				<? } 
		 }
		//---------------------------------------------------------------------------------------------------------------
		
		
		
		
		
		
		//บัญชี
		else if($_SESSION["RoleID_Lineid"]=="7_2"){ 
		?>
			<li><a class="top-heading" href="#">บัญชี</a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   
							<a href="?page=StoctCard">1. รายงานสินค้าคงเหลือ</a>
							<a href="?page=DetailProductSales">2. รายงานสรุปบิลรายวัน </a>
							<a href="?page=fromTax">3. รายงานภาษีขาย </a>
							<a  href="?page=form_dailysales2">4.รายงานสรุปยอดขายรายวัน(การเงิน)</a>
							<a  href="?page=form_dailysales2ALLdc">5.รายงานสรุปยอดขายรายวัน(รวมศูนย์)</a>
							<a  href="?page=form_ReportCN">6.รายงานยกเลิกบิลCN</a>
					</div>
				</div>
				</div>
			</li>
		<? }
		//---------------------------------------------------------------------------------------
		
		
		
		
		
		
		
		
		
		
		
		//การเงิน
		else if($_SESSION["RoleID_Lineid"]=="7_3"){ ?>
		
			<li><a class="top-heading" href="#">การเงิน</a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   
							<a  href="?page=form_dailysales2">4.รายงานสรุปยอดขายรายวัน(การเงิน)</a>
							<a  href="?page=form_dailysales2ALLdc">5.รายงานสรุปยอดขายรายวัน(รวมศูนย์)</a>
					</div>
				</div>
				</div>
			</li>
			<!---  Edit เพิ่มรายงาน ยอดขายรายวัน  --->
		<? }
		//-----------------------------------------------------------------------------------
		
		
		//แม่ทัพ
		else if($_SESSION["RoleID_Lineid"]=="7_6"){ ?>
		
			<li class="no-sub"><a class="top-heading" href="?page=from_CreditNote">ยกเลิกบิล</a></li>
		<? }
		
		
		
		
		
		
		
		
		//admin + adminsale
		else if($_SESSION["RoleID_Lineid"]=="7_1" or $_SESSION["RoleID_Lineid"]=="7_5"){ 
		?>
			<li class="no-sub"><a class="top-heading" href="?page=from_user">จัดการ User</a></li>
			<? if($_SESSION["RoleID_Lineid"]=="7_5") {?>
			<li><a class="top-heading" href="#">1.เพิ่ม/แก้ไข ข้อมูลต่างๆ</a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   
							<a href="?page=from_amuphur">					1.1 อำเภอ </a>
							<a href="?page=from_district">					1.2 ตำบล </a>
							<a href="?page=from_company" id="" >			1.3 บริษัท</a>
							<a href="?page=from_DC">						1.4 DC</a>
							<a href="?page=from_warehouse_location" id="" >	1.5 คลังสินค้า</a>
							<a href="?page=from_rolemaster" id="" >			1.6 ประเภท/ตำแหน่งSale</a> 
							<a href="?page=from_cust_type" id="" >			1.7 ประเภท/รูปแบบร้านค้า</a> 
							<a href="?page=from_item" id="" >				1.8 ประเภท/กลุ่ม/หน่วย/ราคาสินค้า</a>
							<a href="?page=from_cust" id="" >				1.9 ร้านค้า</a>
							<a href="?page=from_master_saletype" id="" >	1.10 ประเภทการขาย</a>
							<a href="?page=from_new" id="" >				1.11 ข่าว</a>
							<a href="?page=from_promotion" id="" >			1.12 โปรโมชั่น/ส่วนลด/แถม </a>
							<a href="?page=from_target" id="" >				1.13 เป้ายอดขาย </a>
							<a href="?page=from_plan" id="" >				1.14 สร้างแผน</a>
							<a href="?page=from_Survey" id="" >				1.15 สร้าง From Survey</a>
					</div>
				</div>
				</div>
			</li>
			<? } ?>
			</li>
			<li><a class="top-heading" href="?page=stockBalanceAdmin">stock</a><!---?page=stockTotal--->
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
							
							<a href="?page=stockBalanceAdmin" id="" >					stock ในคลัง</a>
							<a href="?page=stoc_salekBalanceAdmin" id="" >				stock ท้ายรถ</a>
							
							</div>
				</div>
				</div>
			</li>
			<li><a class="top-heading" href="?page=from_plan">สร้างแผน</a></li>
			<li><a class="top-heading" href="?page=from_Inplan2">วางแผน/เดือน</a></li>
			
			<li class="no-sub"><a class="top-heading" href="?page=from_cust">ข้อมูลร้านค้า</a></li>
			<li class="no-sub"><a class="top-heading" href="?page=from_Quotation">ใบเสนอขาย</a></li>
			<li class="no-sub"><a class="top-heading" href="?page=from_CreditNote">ยกเลิกบิล</a></li>
			<li><a class="top-heading" href="#">บัญชี</a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   
							<a href="?page=StoctCard">1. รายงานสินค้าคงเหลือ</a>
							<a href="?page=DetailProductSales">2. รายงานสรุปบิลรายวัน </a>
							<a href="?page=fromTax">3. รายงานภาษีขาย </a>
							<a  href="?page=form_dailysales2">4.รายงานสรุปยอดขายรายวัน(การเงิน)</a>
							<a  href="?page=form_dailysales2ALLdc">5.รายงานสรุปยอดขายรายวัน(รวมศูนย์)</a>
							<a  href="?page=form_ReportCN">6.รายงานยกเลิกบิลCN</a>
					</div>
				</div>
				</div>
			</li>
			<li class="no-sub"><a class="top-heading" href="dsr">ReportDSR</a></li>
			
			 <? } ?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<? 
							$sqlDC="select a.dc_groupname,a.dc_groupid
							from st_user_group_dc a  left join st_user u
								on u.dc_groupid =a.dc_groupid
								where u.User_id= '$USER_id'"; 
							//echo $sqlOp;
							$sqlDC=sqlsrv_query($con,$sqlDC);
							$sqlDC=sqlsrv_fetch_array($sqlDC);
							
							$sqlLoc="select a.locationname,a.locationno
								from st_warehouse_location a  left join st_user u
								on u.warehouse_locationNo =a.locationno
								where u.User_id= '$USER_id'"; 
							//echo $sqlOp;
							$sqlLoc=sqlsrv_query($con,$sqlLoc);
							$sqlLoc=sqlsrv_fetch_array($sqlLoc);
							
							?>
		<li><a class="top-heading" href="#/logout" id="logout">Logout<? echo " -> ".$_SESSION["NAME"];?></a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   <a href="?page=Privacy_settings" id="Privacy_settings" >			Privacy settings</a>
						   <a href="" id="" >DC:<? echo $sqlDC['dc_groupname'];?></a>
						    <a href="" id="" >คลัง:<? echo $sqlLoc['locationname'];?></a>
							<a href="" id="" >สิทธิ:<? echo $sqlRole['RoleName_Linename'];?></a>
							
							
					</div>
				</div>
				</div>
		</li>
		
	  
    </ul>
</nav>
          