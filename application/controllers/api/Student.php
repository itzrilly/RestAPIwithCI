<?php

    require APPPATH.'libraries/REST_Controller.php';

    class Student extends REST_Controller{

        /*
            INSERT: POST REQUEST TYPE
            UPDATE: PUT REQUEST TYPE
            DELETE: DELETE REQUEST TYPE
            LIST: GET REQUEST TYPE
        */

        // INSERT <url>/index.php/student
        public function index_post(){
            // insert data method
            echo 'This is post method';
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
            echo 'This is get method';
        }

    }

?>