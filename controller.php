<?php
    require('model.php');
    require('view.php');

    class Gradebook_controller
    {
        private $model;
        private $views;

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
                case 'gradeFormAdd':
                    print $this->views->gradeFormAddView($this->data, $this->message);
                    break;
                case 'gradeFormEdit':
                    print $this->views->gradeFormEditView($this->data, $this->message);
                    break;
                case 'studentForm':
                    print $this->views->studentFormView($this->data, $this->message);
                    break;
                case 'addStudentForm':
                    print $this->views->addStudentView();
                    break;
                default: // 'gradesList'
                    $grades = $this->model->viewGrades();
                    $students = $this->model->viewStudents();
                    print $this->views->gradesListView($students, $grades, $this->message);
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
                $this->view = 'gradeFormAdd';
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
                $this->view = 'gradeFormEdit';
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
                $this->view = 'gradesList';
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
            } else {
            }
        }

        private function verifyLogin()
        {
            if (!$this->model->getStatus()) {
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
