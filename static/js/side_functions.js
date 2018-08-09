function showUser(str)
       {
	      document.getElementById("txtHint").innerHTML="<center><img src='{{ url_for('static', filename='ajax-loader_b.gif') }}' height=24 /></center>";
	      if (str==""){
		     document.getElementById("txtHint").innerHTML="";
		     return;
	      }
       	      if (window.XMLHttpRequest){
		     // code for IE7+, Firefox, Chrome, Opera, Safari
		     xmlhttp=new XMLHttpRequest();
              }
	      else {
		     // code for IE6, IE5
		     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	      }
	      xmlhttp.onreadystatechange=function()
	      {
		     if (xmlhttp.readyState==4 && xmlhttp.status==200)
		     {
			    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		     }
	      }
	      xmlhttp.open("GET","display_filter.php?q="+str,true);
	      xmlhttp.send();
       }
// function to a delete student entry
function delStudent(stuid) {
	var r = confirm("Are you sure you want to delete the details of this student from database?");
	if (r == true) {
		document.getElementById(stuid).innerHTML = "<tr><td colspan=7><center><img src='../images/ajax-loader_b.gif' height=24 /></center></td></tr>'";
		if (stuid == "") {
			document.getElementById(stuid).innerHTML = "error";
			return;
		}
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(stuid).innerHTML = xmlhttp.responseText;
				document.getElementById(stuid + 'a').innerHTML = "";
			}
		}
		xmlhttp.open("POST", "delete_student.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("q=" + stuid);
	}
}
// function deleting student entry ends


// function to get available hostels according to gender
function getAlotData(stuid) {
	document.getElementById(stuid + 'b').innerHTML = "<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	if (stuid == "") {
		document.getElementById(stuid + 'b').innerHTML = "error";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "get_rooms_available.php?id=" + stuid, true);
	xmlhttp.send();
}
// function to get available hostels ends


// function to get available room in that hostel
function getAlotRooms(stuid, hos) {
	document.getElementById(stuid + 'b').innerHTML = "<center><img src='../images/ajax-loader_b.gif' height=24 /></center>'";
	if (stuid == "") {
		document.getElementById(stuid + 'b').innerHTML = "error";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "get_rooms_available.php?id=" + stuid + "&hos=" + hos, true);
	xmlhttp.send();
}
// function to get available room ends



// function to allot room to a student
function finalAllotRoom(stuid, hos, room_no) {
	document.getElementById(stuid + 'b').innerHTML = "<center><img src='{{ url_for('static', filename='ajax-loader_b.gif') }}' height=24 /></center>'";
	if (stuid == "") {
		document.getElementById(stuid + 'b').innerHTML = "error";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST", "allot_final_ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("form_no=" + stuid + "&room_no=" + room_no + "&hostel=" + hos);
}
// function to allot room ends


// function to cancel allotment
function delAllotment(stuid) {
	var r = confirm("Are you sure you want to cancel the allotment of this student?");
	if (r == true) {
		document.getElementById(stuid + 'b').innerHTML = "<tr><td colspan=7><center><img src='{{ url_for('static', filename='ajax-loader_b.gif') }}' height=24 /></center></td></tr>'";
		if (stuid == "") {
			document.getElementById(stuid + 'b').innerHTML = "error";
			return;
		}
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST", "cancel_allot_ajax.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("form_no=" + stuid);
	}
}
// function to cancel allotment ends



// function to submit remark ends


// function to pop out a custom window
function popitup(url) {
	newwindow = window.open(url, 'name', 'scrollbars=yes,height=500,width=800');
	if (window.focus) {
		newwindow.focus()
	}
	return false;
}
// function to pop out a windoe ens


// function to capture values and export to excel
function export_excel_link()
{
	var categ = document.getElementById('filter-category').innerHTML;
	var bcks = document.getElementById('filter-backs').innerHTML;
	var yradmn = document.getElementById('filter-yr-admn').innerHTML;
	var sex = document.getElementById('filter-gender').innerHTML;
	var crse = document.getElementById('filter-course').innerHTML;
	var alltd = document.getElementById('filter-allotted').innerHTML;
	var vrifd = document.getElementById('filter-verified').innerHTML;
	var ordr = document.getElementById('filter-order').innerHTML;
        var tprg = document.getElementById('filter-typeofreg').innerHTML;

	window.location = "export_from_filter.php?category=" + categ + "&backs=" + bcks + "&gender=" + sex + "&course=" + crse + "&yr_admission=" + yradmn + "&allotted=" + alltd + "&verified=" + vrifd + "&order=" + ordr + "&type_reg=" + tprg;
}
// function to capture values and export to excel ends
 

function requestBackList(node, case_query) {
	showFilteredData(case_query, node.parentNode.getElementsByTagName('input')[0].value);
}


// function to update hostel roll number
function updatehrollno(stuid) {
	var rollno_rec = document.getElementById(stuid + 'rollinput').value;
	document.getElementById(stuid + 'b').innerHTML = "<center><img src='{{ url_for('static', filename='ajax-loader_b.gif') }}' height=24 /></center>";
	if (stuid == "") {
		document.getElementById(stuid + 'b').innerHTML = "error";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST", "updatehrollno_ajax.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("form_no=" + stuid + "&rollno_rec=" + rollno_rec);
}
// function to update hostel roll number ends


// function to update all roll numbers on keyup
function changeRollNoSubmit() {
	var rollformat = document.getElementById("rollformatyear").value+'/'+document.getElementById("rollformattext").value+'/';
	var rollfields = document.getElementsByTagName("input");
	var rollcount = 001;
	for(i=0; i<rollfields.length; ++i){
		if(rollfields[i].id.substring(0,9) == "rollinput"){
			if(rollcount < 10)
			{
				rollfields[i].value = rollformat+'00'+rollcount;
				++rollcount;
			}
			else if((rollcount > 9) && (rollcount < 100))
			{
				rollfields[i].value = rollformat+'0'+rollcount;
				++rollcount;
			}
			else if((rollcount > 99) && (rollcount < 1000))
			{
				rollfields[i].value = rollformat+rollcount;
				++rollcount;
			}
		}
	}
}
// function to update all roll numbers on keyup ends


// function to submit hostel roll number
function submitallhrollno() {
	var r = confirm("Are you sure you want to submit roll numbers all to database?");
	if (r == true) {
	var rollfields = document.getElementsByTagName("input");
	var stuid = 0;
	for(i=0; i<rollfields.length; ++i){
		if(rollfields[i].id.substring(0,9) == "rollinput"){
			stuid = rollfields[i].id.substring('rollinput'.length);
			var rollno_rec = document.getElementById('rollinput' + stuid).value;
			if (stuid == "") {
				document.getElementById(stuid + 'b').innerHTML = "error";
				return;
			}
			if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else { // code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(stuid + 'b').innerHTML = xmlhttp.responseText;
				}
				else { console.log(xmlhttp.readyState); }
			}
			xmlhttp.open("POST", "updatehrollno_ajax.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("form_no=" + stuid + "&rollno_rec=" + rollno_rec);
		}
	}
	}
}
// function to submit hostel roll number ends

