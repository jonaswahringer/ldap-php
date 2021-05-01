<h1 style="text-align: center; padding: 20px;">LDAP-Connection</h1><br>
<form method="post" style="text-align: center;">
    <input type="submit" class="btn btn-light btn-md" style="text-align: center;" name="disconnect_ldap" value="Disconnect"/>
    <input type="submit"  class="btn btn-dark btn-md" name="show_users_groups" value="Show AD"/>
    <input type="submit" class="btn btn-dark btn-md" style="text-align: center;" name="change_password" value="Modify Passwords"><br><br>
</form>

<?php
// acts as a router 
    include ("controllers/controller.php");
    include ("controllers/controller_modify.php");
    require_once('include/header.inc.php');

    $controller = new Controller();
    $controller_mod = new Controller_modify();

    if(isset($_POST['show_users_groups'])) {
        $controller->get_data_to_view();
    }

    if(isset($_POST['change_password'])) {
        $controller_mod->get_data_to_view();
    }

    $count = $controller_mod->get_entry_count();
    for($i = 0; $i<$count; $i++) {
        if(isset($_POST['force_user_change_pw'.$i])) {
            $controller_mod->force_user_to_change_pw($i);
            echo '<h3 style="text-align: center;">User has to change password at next login!</h3>';
        }
    }

    for($i = 0; $i<$count; $i++) {
        if(isset($_POST['change_password'.$i])) {
            if(!empty($_POST['new_password'.$i])) {
                $controller_mod->change_password($i,  $_POST['new_password'.$i]);
                echo '<h3 style="text-align: center;">User password changed!</h3>';
            }
        }
    }

    if(isset($_POST['disconnect_ldap'])) {
        $controller->disconnect_ldap();
        $controller_mod->disconnect_ldap();
        echo '<h3 style="text-align: center;">Disconnected</h3>';
    }
?>


<?php
require_once('include/footer.inc.php');
?>