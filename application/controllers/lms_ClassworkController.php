<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lms_ClassworkController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['lms_classworks']);
        $this->is_offline = !isset($_SESSION['online']);
    }

    public function classwork()
    {

        if ($this->is_offline) redirect();
        $student_id = $this->session->student_id;
        $student = $this->class_student->where('student_id', $student_id)->get();

        if (!$student) {
            $this->session->set_flashdata('error', 'Student section not found');
            redirect('attendance');
        }

        $missing = $this->lms_classworks->get_classworks();

        $data = [
            'assessments' => $missing
        ];

        var_dump($data);

        $this->load->view('classwork', $data);
    }
}
