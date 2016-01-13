<?//------------------------------------------------------------------web นี้สร้างโดย Numphung(น้ำผึ้ง) ปี2557
	session_start();  //เปิดseeion	
	set_time_limit(0);//เป็นการกำหนดให้ server run ได้ ตราบนานเท่านาน
	include("includes/config.php"); //connect database db.carabao.com
	ini_set('session.gc_maxlifetime', 3600); //การกำหนดค่า Session Timeout
?>
<nav id="ddmenu">
    
    <ul>
		<li class="no-sub"><a class="top-heading" href="http://saleapp.carabao.co.th/?page=fromOriginal">Home</a></li>
        <li class="no-sub"><a class="top-heading" href="?page=fromReportAve">รายงานสรุปยอดขายเฉลี่ย</a></li>
		<li class="no-sub"><a class="top-heading" href="?page=fromReportMTD">MTDสรุปยอดขายประจำวัน</a></li>
        <li class="no-sub"><a class="top-heading" href="?page=fromReportByUser">สรุปยอดขายประจำวัน</a></li>
		<li><a class="top-heading" href="#/logout" id="logout">Logout<? echo " -> ".$_SESSION["NAME"];?></a>
				<i class="caret"></i>           
				<div class="dropdown mayRight">
				<div class="dd-inner">
					<div class="column">
						   
							<a href="?page=Privacy_settings" id="Privacy_settings" >			Privacy settings</a>
					</div>
				</div>
				</div>
		</li>
		
	  
    </ul>
</nav>
          