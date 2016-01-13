<?SESSION_START();
	//print $_SERVER['REQUEST_URI'];
?>
<style type="text/css">

div#menu {

}

</style>

<div id="menu" >
    <ul class="menu"  >
	
        <li><a href="#/Re1" id="Re1" class="parent"><span>Logout</span></a>
            <div><ul>
            </ul></div>
        </li>

        <li><a href="#Re2" id="Re2" class="parent"><span>อัพโหลด</span></a>
            <div><ul>
                <li><a href="#/report2" id="report2" class="parent"><span>อัพโหลดไฟล์ VDO</span></a>
                   
                </li>	
            </ul></div>
        </li>
		
		<li><a href="#Re3" id="Re3" class="parent"><span>ดาวน์โหลด</span></a>
            <div><ul>
                <li><a href="#/report3" id="report3" class="parent"><span>2.1 ดาวน์โหลดไฟล์ marketing</span></a></li>	
               <li><a href="#/report4" id="report4" class="parent"><span>2.2 ดาวน์โหลดไฟล์ Sale</span></a></li>


		   </ul></div>
        </li>
		

		
		
		<?if($_SESSION["_USER_LEVEL"]=="2"){?>
		<li><a href="#Re4" id="Re4" class="parent"><span>รายงาน</span></a>
            <div><ul>
                <li><a href="#/report5" id="report5" class="parent"><span>3.1 รายงานสรุป ผู้ที่โหลดไฟล์</span></a></li>	
		   </ul></div>
        </li>
		
		<li><a href="#Re5" id="Re5" class="parent"><span>Admin</span></a>
            <div><ul>
                <li><a href="#/report6" id="report6" class="parent"><span>4.1 สิทธิ์ผู้ใช้งาน</span></a></li>
				<li><a href="#/report7" id="report7" class="parent"><span>4.2 ไฟล์อัพโหลด marketing</span></a></li>				
		   </ul></div>
        </li>
		<?}?>
      
    </ul>
</div>


<?//-------------------------------------------------?>
