<?php

    require APPPATH.'libraries/REST_Controller.php';

    class Student extends REST_Controller{

        public function __construct(){
            parent::__construct();
            // load db
            $this->load->database();
            // load model
            $this->load->model(array('api/student_model'));
            $this->load->library(array('form_validation'));
            $this->load->helper('security');
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

            // print_r($this->input->post()); die;

            // Collecting form data inputs
            $name = $this->security->xss_clean($this->input->post('name'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $course = $this->security->xss_clean($this->input->post('course'));

            // Form validation for inputs
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            $this->form_validation->set_rules('course', 'Course', 'required');

            // Checking form submission have any error or not
            if($this->form_validation->run() === FALSE){
                // We get some erros
                $this->response(array(
                    'status' => 0,
                    'message' => 'All fields are needed'
                ), REST_Controller::HTTP_NOT_FOUND);
            }else{
                if(!empty($name) && !empty($email) && !empty($mobile) && !empty($course)){
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

            /*$data = json_decode(file_get_contents('php://input'));

            $name = isset($data->name) ? $data->name : '';
            $email = isset($data->email) ? $data->email : '';
            $mobile = isset($data->mobile) ? $data->mobile : '';
            $course = isset($data->course) ? $data->course : '';*/
        }

        // UPDATE <url>/index.php/student
        public function index_put(){
            // update data method
            $data = json_decode(file_get_contents('php://input'));

            if(isset($data->id) && isset($data->name) && isset($data->email) && isset($data->mobile) && isset($data->course)){
                $student_id = $data->id;
                $student_info = array(
                    'name' => $data->name,
                    'email' => $data->email,
                    'mobile' => $data->mobile,
                    'course' => $data->course
                );
                if($this->student_model->update_student($student_id, $student_info)){
                    $this->response(array(
                        'status' => 1,
                        'message' => 'Student data updated successfully'
                    ), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array(
                        'status' => 0,
                        'message' => 'Failed to update student data'
                    ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }else{
                $this->response(array(
                    'status' => 0,
                    'message' => 'All fields are needed'
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }

        // DELETE <url>/index.php/student
        public function index_delete(){
            // delete data methdod
            $data = json_decode(file_get_contents('php://input'));
            $student_id = $this->security->xss_clean($data->student_id);

            if($this->student_model->delete_student($student_id)){
                // return true
                $this->response(array(
                    'status' => 1,
                    'message' => 'Student has been deleted'
                ), REST_Controller::HTTP_OK);
            }else{
                // return false
                $this->response(array(
                    'status' => 0,
                    'message' => 'Failed to delete student'
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }

        // GET <url>/index.php/student
        public function index_get(){
            // list data method

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