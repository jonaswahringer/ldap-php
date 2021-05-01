<?php
    require_once('include/header.inc.php');
    include_once("models/model_modify.php");
    include("views/view_modify.php");

    class Controller_modify {
        private $model;
        private $view;
        private $model_data;
        private $users;
        private $dn;
        private $ds;
        
        function __construct() {
            $this->model = new Model_modify();
            $this->model_data = $this->model->get_entries(); 
            $this->users = $this->model->get_users(); 
            $this->dn = $this->model->get_dn(); 
            $this->ds = $this->model->get_ds();
        }

        public function force_user_to_change_pw($index) {           
            $name = $this->users[$index]["name"];            
            $modified_dn = "cn=" . $name . "," . $this->dn;
            $this->model->force_user_to_change_pw($index, $name);            
        }

        /*
        public function change_username($index, $new_name) {
            $name = $this->users[$index]["name"];  
            $modified_dn = "cn=" . $name . "," . $this->dn;
            $new_modified_dn = "cn=" . $new_name;
        
            ldap_rename($this->ds, $modified_dn, $new_name, $this->dn, true);
            echo "succesful";
        }
        */

        public function change_password($index, $new_password) {
            $name = $this->users[$index]["name"];  
            $this->model->change_user_password($name, $new_password);
        }

        public function get_data_to_view() {
            $users = $this->users;
            $view = new View_modify($users);
            $view->show_users();
        }

        public function get_entry_count() {
            return count($this->users);
        }

        public function disconnect_ldap() {
            $this->model->cut_connection();
        }
    }
?>