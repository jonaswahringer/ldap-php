<?php
    require_once('include/header.inc.php');
    include_once("models/model.php");
    include("views/view.php");

    class Controller {
        private $model;
        private $view;
        private $users_and_groups;
        private $dn;

       function __construct() {
            $this->model = new Model();
            $this->users_and_groups = $this->model->get_users_and_groups(); 
        }

        public function get_data_to_view() {
            $view = new View($this->users_and_groups, count($this->users_and_groups));
            $view->show_users_and_groups();
        }
        public function disconnect_ldap() {
            $this->model->cut_connection();
        }        
    }

    require_once('include/footer.inc.php');
?>