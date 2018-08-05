<?php

ob_start();
require_once("../../includes/initialize.php");


if(!$session->is_logged_in()){ redirect_to("login.php");}
?>

<?php include_layout_template('admin_header.php'); ?>
<h2>Users</h2>
<?php

if(isset($_GET['status'])){
    if($_GET['status'] == 'update'){
        echo output_message('User details updated');
    }
    if($_GET['status'] == 'create'){
        echo output_message('New user created');
    }
    if($_GET['status'] == 'delete'){
        echo output_message('User account deleted');
    }
}

?>
<a href="newuser.php">Create New User</a>
<br /><br />
<table border='1px' cellpadding='10px' cellspacing='10px'>
    <tr>
        <th>Username</th><th>Name</th><th>Phone</th><th>Level</th><th>Action</th>
    </tr>
    <?php
        $user_set = User::find_all();
        //print_r($user_set);
        foreach ($user_set as $user_object){
            echo "<tr>";
            echo "<td>".$user_object->username."</td>";
            echo "<td>".$user_object->name."</td>";
            echo "<td>".$user_object->phone."</td>";
            echo "<td>".$user_object->level."</td>";
            echo "<td><a href='updateuser.php?id=".$user_object->id."'>update</a> | <a href='deleteuser.php?id=".$user_object->id."'>delete</a></td>";
            echo "</tr>";
            
        }
    ?>
</table>

<?php include_layout_template('admin_footer.php');
ob_end_flush();
?>