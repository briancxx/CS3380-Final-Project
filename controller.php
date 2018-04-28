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

            $this->processOrderBy();

            $this->processLogout();

            switch ($this->action) {
                case 'login':
                    $this->handleLogin();
                    break;
                case 'delete_grade':
                    $this->handleRemoveGrade();
                    break;
                case 'edit_grade':
                    $this->handleEditGrade();
                    break;
                case 'add_grade':
                    $this->handleAddGrade();
                    break;
                case 'add_student':
                    $this->handleAddStudent();
                    break;
                default:
                    $this->verifyLogin();
            }

            switch ($this->view) {
                case 'loginForm':
                    print $this->views->loginFormView($this->data, $this->message);
                    break;
                case 'gradeForm':
                    print $this->views->gradeFormView($this->data, $this->message);
                    break;
                case 'studentForm':
                    print $this->views->studentFormView($this->data, $this->message);
                    break;
                default: // 'gradesList'
                    print $this->views->gradesListView($this->message);
            }
        }

        // GRADES ---

        // create grade
        private function handleAddGrade()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->addGrade($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'gradeForm';
                $this->data = $_POST;
            }
        }

        // update grade
        private function handleEditGrade()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->editGrade($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'gradeForm';
                $this->data = $_POST;
            }
        }

        // delete grade
        private function handleRemoveGrade()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->removeGrade($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'gradeForm';
                $this->data = $_POST;
            }
        }

        // STUDENT ---

        // create student
        private function handleAddStudent()
        {
            if (!$this->verifyLogin()) {
                return;
            }

            if ($_POST['cancel']) {
                $this->view = 'gradesList';
                return;
            }

            $error = $this->model->addStudent($_POST);
            if ($error) {
                $this->message = $error;
                $this->view = 'studentForm';
                $this->data = $_POST;
            }
        }

        // TEACHER ---

        // LOGIN ---

        private function processLogout()
        {
            if ($_GET['logout']) {
                $this->model->logout();
            }
        }

        private function verifyLogin()
        {
            if (! $this->model->getStatus()) {
                $this->view = 'loginForm';
                return false;
            } else {
                return true;
            }
        }

        private function handleLogin()
        {
            list($success, $message) = $this->model->check_login($_POST);
            if ($success) {
                $this->view = 'gradesList';
            } else {
                $this->message = $message;
                $this->view = 'loginForm';
                $this->data = $_POST;
            }
        }
    }
