<?php
    require_once('include/header.inc.php');
    
    class View_modify {
        private $data;
        private $dn;

        function __construct($controller_data) {
            $this->data = $controller_data;
        }

        public function show_users(){
            echo '<form method="post" class="form-control">';
            echo "<table class='table table-light' style='text-align: center;'>";
            for($i=0; $i<count($this->data); $i++) { 
                echo "<tr>";
                echo "<td>";
                echo '<img src="images/user.png" alt="Container" height="25" width="25">';
                echo "</td>";
                echo "<td>";
                echo $this->data[$i]["category"];
                echo "</td>";
                echo "<td>";
                echo $this->data[$i]["name"];
                echo "</td>";
                echo "<td />";
                echo "<td>";
                echo '<input type="submit" class="btn btn-secondary btn-sm" name="force_user_change_pw'.$i.'" value="Force Password Change"><br><br>';
                echo "</td>";
                echo "<td>";
                echo '<input type="submit" class="btn btn-dark btn-sm" name="change_password'.$i.'"value="Change Password"><br><br>';
                echo '<input type="text" class="form-control form-control-sm" placeholder="new password" name="new_password'.$i.'" size="15">';
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo '</form>';
        }              
    }

    require_once('include/footer.inc.php');
?>