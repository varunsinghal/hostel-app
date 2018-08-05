<?php
       ob_start();
       require_once("../../includes/initialize.php");
       if(!$session->is_logged_in()){ redirect_to("login.php"); }
       include_layout_template('admin_header.php');
?>
<style>
table
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
td, th
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
th
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
 tr.alt td
{
color:#000000;
background-color:#EAF2D3;
}
</style>
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script>
  $(document).ready(function(e){
       $("select").each(function () {
     var va =$(this).attr('value');
     var ch=$(this).attr('id');
     var str= ch.split('us');
     if(va=='custom'){
     $('#state'+str[1]).show();
     }
     else
     $('#state'+str[1]).hide();
     });

     $("select").change(function () {
     var value =$(this).attr('value');
     var ch=$(this).attr('id');
     $(".update").each(function(){
     var eck=$(this).attr('name');
     var str= ch.split('us');
     if(str[1]==eck) {
     $(this).removeAttr('disabled');
     }
     if(value=='custom'){
     $('#state'+str[1]).show();
     }
     else
     $('#state'+str[1]).hide();
     });

   });

   $('textarea').keydown(function(){
     var ch=$(this).attr('id');
     $(".update").each(function(){
     var eck=$(this).attr('name');
     var str= ch.split('sg');
     if(str[1]==eck) {
     $(this).removeAttr('disabled');
     }
     });
   });
   
    $('textarea').keydown(function(){
     var ch=$(this).attr('id');
     $(".update").each(function(){
     var eck=$(this).attr('name');
     var str= ch.split('te');
     if(str[1]==eck) {
     $(this).removeAttr('disabled');
     }
     });
   });

    $(".update").click(function(){
     $(this).prop('disabled',true);
    var check=$(this).attr('name');
     var tstat=$('#status'+check).val();
    var tmsg=$('#msg'+check).val();
    var tstate=$('#state'+check).val();
    var datastring="tid="+check+"&tstat="+tstat+"&tmsg="+tmsg+"&tstate="+tstate;
    $.ajax({
				type: "POST",
				data: datastring,
				url: "tokenupdate.php",
				success: function(result){
                                 $(".update").attr('disabled');
                                }
});
    });

return false;
  });
  function myFunction(){
    alert("slee");
  }
</script>
 <br><br><br>
<table width="100%">
<tr><th>Token No.</th><th>Token ID.</th><th>Token Details</th><th>Token Status</th><th>Message.</th><th>Update changes</th></tr>
<?php

$query=mysql_query("select * from token order by t_no desc");

while($t=mysql_fetch_array($query)){ 
  $s=explode('-',$t['t_status']);
  if(!isset($s[1]))
  $s[1]="";
  echo '<tr><td>'.$t['t_no'].'</td><td>'.$t['t_id'].'</td><td>'.$t['t_ip'].'</td><td><select id="status'.$t['t_id'].'">
  <option value="waiting"';
  if($t['t_status']=='waiting') echo 'selected';
  echo '>waiting</option>
  <option value="recieved"';
  if($t['t_status']=='recieved') echo 'selected';
  echo '>recieved</option>  <option value="completed"';
  if($t['t_status']=='completed') echo 'selected';
  echo '>completed</option>  <option value="custom"';
  if($t['t_status']!='waiting' and $t['t_status']!='completed' and $t['t_status']!='recieved') echo 'selected';
  echo '>custom</option>
  </select>
  <br><textarea cols="30" rows="3" id="state'.$t['t_id'].'">'.$s[1].'</textarea>';
  echo'
  </td><td><textarea cols="37" rows="5" id="msg'.$t['t_id'].'">'.$t['t_msg'].'</textarea>
  </td><td><button class="update" name="'.$t['t_id'].'" disabled>Update</button></td></tr>';
}
?>
</table>
 <div id="result"></div>
<?php include_layout_template('footer.php');
if(isset($database)) { $database->close_connection(); }
ob_end_flush();

?>