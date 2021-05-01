<?php
    require_once('include/header.inc.php');
    
    class View {
        private $data;
        private $count;

        function __construct($controller_data, $controller_data_count) {
            $this->data = $controller_data;
            $this->count = $controller_data_count;
        }

        public function show_users_and_groups(){
            echo '<form method="post" class="form-control">';
            echo "<table class='table table-light' style='text-align: center;'>";
            for($i=0; $i<$this->count; $i++) {
                echo "<tr>";
                echo "<td>";
                if($this->data[$i]["category"]=="user") {
                    echo '<img src="images/user.png" alt="User" height="25" width="25">';
                }
                else if($this->data[$i]["category"]=="group") {
                    echo '<img src="images/group.png" alt="Group" height="25" width="25">';
                }
                else if($this->data[$i]["category"]=="container") {
                    echo '<img src="images/container.png" alt="Container" height="25" width="25">';
                }
                echo "</td>";
                echo "<td>";
                echo $this->data[$i]["category"];
                echo "</td>";
                echo "<td>";
                echo $this->data[$i]["name"];
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    require_once('include/footer.inc.php');
?>