//--> พิมพ์เฉพาะตัวเลข
function NumberOnly()
{ 
		if (event.keyCode < 45 || event.keyCode > 57){
			event.returnValue = false; 
		}
}


//***--> Window  Open  , Pop up
function fullscreen(url) {
	  w = screen.availWidth-10;
	  h = screen.availHeight-20;
	  features = "width="+w+",height="+h;
	  features += ",left=0,top=0,screenX=0,screenY=0,menubar=0,resizable=1,scrollbars=1,status=1,titlebar=1,toolbar=0";
	
window.open(url, "", features);
		
}

function fullscreen2(url) {
	  w = screen.availWidth-10;
	  h = screen.availHeight-20;
	  features = "width="+w+",height="+h;
	  features += ",left=0,top=0,screenX=0,screenY=0,menubar=1,resizable=1,scrollbars=1,status=1,titlebar=1,toolbar=0";
	
window.open(url, "", features);
		
}


function fullscreen_menu(url) {
	  w = screen.availWidth-10;
	  h = screen.availHeight-20;
	  features = "width="+w+",height="+h;
	  features += ",left=0,top=0,screenX=0,screenY=0,menubar=1,resizable=1,scrollbars=1,status=1,titlebar=1,toolbar=1";					
  window.open(url, "", features);						
}

 function openwincenter(url,winname,x,y){
	var sx = screen.width;
	var sy = screen.height;
	var wx = (sx/2) - (x /2);
	var wy = (sy/2) - (y/2) - 50;
	winname = window.open(url,winname,"width=" + x + ",height=" + y +",menubar=0,resizable=0,scrollbars=1,status=0,titlebar=1,toolbar=0,left=" + wx + ",top=" + wy);
	winname.focus();
}

//***-->

// Function Check Interger
function chkNumber(number){
	if(isNaN(number)){
		alert('กรอกข้อมูลเป็นตัวเลขเท่านั้น');
		return false;
	}
}

function displayNum(value , dec){
	var num=new NumberFormat(value);
	num.setCommas(true);
	num.setPlaces( dec );
	
	return num.toFormatted();		
}

//----  ฟังก์ชั่นสำหรับตัด , ออก ----
function splits(value){
	var ArrStr = value.split(",");
	var result='';
	
	for(var i=0 ; i < ArrStr.length ; i++){
		result = result.concat(ArrStr[i]);
	}	
	
	return result;
}

//--> ตรวจสอบเลขบัตรประชาชน
function check_digit_id_card(id_card) {
	var multi_num = 13;
	var str_digit = 0;
	var result = 0;
	
	if(id_card.length != 13) {
		return false;
	} 
	
	while(multi_num != 1) {
		if(id_card.charAt(str_digit) == Number.NaN) {
			return false;
		}
	
		result = result + id_card.charAt(str_digit)*multi_num;
		multi_num = multi_num - 1;
		str_digit = str_digit + 1; 
	}

	result = result % 11;
	if(result == 0) result = 10;

	result = 11 - result;

	if(result == 10) result = 0;

	if(result == id_card.charAt(12)) {
		return true;
	} else {
		return false;
	}
} 

//--> ฟังก์ชัน validate email
function IsEMail(email)
{
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (filter.test(email)) 
		return true;
	else
		return false;
}