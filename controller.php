<?php
    require('model.php');
    require('views.php');

    class Gradebook_controller
    {
        private $model;
        private $views;

        private $orderBy = '';
        private $view = '';
        private $action = '';
        private $message = '';
        private $data = array();

        public function __construct()
        {
            $this->model = new Gradebook_model();
            $this->views = new Gradebook_views();

            $this->view = $_GET['view'] ? $_GET['view'] : 'gradesList';
            $this->action = $_POST['action'];
        }

        public function __destruct()
        {
            $this->model = null;
            $this->views = null;
        }

        public function run()
        {
            if ($error = $this->model->getError()) {
                print $views->errorView($error);
                exit;
            }

            // Note: given order of handling and given processOrderBy doesn't require user to be logged in
            //...orderBy can be changed without being logged in
            $this->processOrderBy();

            $this->processLogout();

            switch ($this->action) {
                case 'login':
                    $this->handleLogin();
                    break;
                case 'delete_grade':
                    break;
                case 'edit_grade':
                    break;
                case 'add_grade':
                    break;
                case 'add_assignment':
                    break;
                case 'delete_assignment':
                    break;
                default:
                    $this->verifyLogin();
            }

            switch ($this->view) {
                case 'loginForm':
                    print $this->views->loginFormView($this->data, $this->message);
                    break;
                case 'taskform':
                    print $this->views->taskFormView($this->model->getUser(), $this->data, $this->message);
                    break;
                default: // 'gradebook'
                    list($orderBy, $orderDirection) = $this->model->getOrdering();
                    list($tasks, $error) = $this->model->getTasks();
                    if ($error) {
                        $this->message = $error;
                    }
                    print $this->views->taskListView($this->model->getUser(), $tasks, $orderBy, $orderDirection, $this->message);
            }
        }

        // GRADES ---

        private function handleAddGrade()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->add_grade($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'gradeForm';
                $this->data = $_POST;
            }
        }

        // ASSIGNMENTS ---

        // STUDENT ---

        private function handleAddStudent()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->add_student($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'addStudentForm';
                $this->data = $_POST;
            }
        }

        // LOGIN ---

        private function processLogout()
        {
            if ($_GET['logout']) {
                $this->model->logout();
            }
        }

        private function verifyLogin()
        {
            if (! $this->model->check_login()) {
                $this->view = 'loginForm';
                return false;
            } else {
                return true;
            }
        }

        private function handleLogin()
        {
            $type = $_POST['type'];
            $loginID = $_POST['loginid'];
            $password = $_POST['password'];

            list($success, $message) = $this->model->login($type, $loginID, $password);
            if ($success) {
                $this->view = 'gradebook';
            } else {
                $this->message = $message;
                $this->view = 'loginForm';
                $this->data = $_POST;
            }
        }
    }
