<?php

    require APPPATH.'libraries/REST_Controller.php';

    class Student extends REST_Controller{

        public function __construct(){
            parent::__construct();
            // load db
            $this->load->database();
            // load model
            $this->load->model(array('api/student_model'));
        }

        /*
            INSERT: POST REQUEST TYPE
            UPDATE: PUT REQUEST TYPE
            DELETE: DELETE REQUEST TYPE
            LIST: GET REQUEST TYPE
        */

        // INSERT <url>/index.php/student
        public function index_post(){
            // insert data method
            // echo 'This is post method';
            $data = json_decode(file_get_contents('php://input'));

            $name = isset($data->name) ? $data->name : '';
            $email = isset($data->email) ? $data->email : '';
            $mobile = isset($data->mobile) ? $data->mobile : '';
            $course = isset($data->course) ? $data->course : '';

            if(!empty(name) && !empty($email) && !empty($mobile) && !empty($course)){
                // All values are available
                $student = array(
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'course' => $course
                );

                if($this->student_model->insert_student($student)){
                    $this->response(array(
                        'status' => 1,
                        'message' => 'Student has been created'
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        'status' => 0,
                        'message' => 'Failed to create student'
                    ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }else{
                // We have some empty field
                $this->response(array(
                    'status' => 0,
                    'message' => 'All fields are needed'
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }

        // UPDATE <url>/index.php/student
        public function index_put(){
            // update data method
            echo 'This is put method';
        }

        // DELETE <url>/index.php/student
        public function index_delete(){
            // delete data methdod
            echo 'This is delete method';
        }

        // GET <url>/index.php/student
        public function index_get(){
            // list data method
            // echo 'This is get method';

            $students = $this->student_model->get_students();

            if(count($students) > 0){
                $this->response(array(
                    'status' => 1,
                    'message' => 'Students found',
                    'data' => $students
                ), REST_Controller::HTTP_OK);
            }else{
                $this->response(array(
                    'status' => 0,
                    'message' => 'No students found',
                    'data' => $students
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }

    }

?>