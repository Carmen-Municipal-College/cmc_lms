<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthenticationController extends CI_Controller
{
    public function login()
    {
        $post = $this->input->post();
        $user = $this->accounts->with_student()->get(['username' => $post['username']]);

        if (!$user) {
            // No account found, redirect to registration with username prefilled if available
            $this->session->set_flashdata('register_username', $post['username']);
            redirect('register_account');
        }

        $section = $this->class_student->get(['student_id' => $user->student_id]);

        if ($user->password == $post['password']) {
            $session_data = [
                'account_id' => $user->account_id,
                'student_id' => $user->student_id,
                'student_no' => $user->student->student_no,
                'lastname' => $user->student->lastname,
                'firstname' => $user->student->firstname,
                'course' => $user->student->course,
                'current_year' => $user->student->current_year,
                'section' => $section->section,
                'role' => $user->role,
                'online' => true,
                'exam_term' => false,
                'exam_review' => false
            ];

            $this->session->set_userdata($session_data);
            redirect('attendance');
        } else {
            $this->session->set_flashdata('error', 'Login Error');
            redirect();
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }

    public function register_account()
    {
        // Load class list from class table for dropdown
        $classes = $this->db->get('classes')->result();
        $data['classes'] = $classes;
        $data['register_username'] = $this->session->flashdata('register_username');
        $this->load->view('register_account', $data);
    }

    public function save_account_registration()
    {
        $input = $this->input->post();

        // Validate input
        if (
            empty($input['username']) ||
            empty($input['password']) ||
            empty($input['confirm_password']) ||
            empty($input['class_id']) ||
            empty($input['student_id'])
        ) {
            $this->session->set_flashdata('error', 'All fields are required.');
            redirect('register_account');
        }

        if ($input['password'] !== $input['confirm_password']) {
            $this->session->set_flashdata('error', 'Passwords do not match.');
            redirect('register_account');
        }

        // Check if username exists
        $exists = $this->accounts->get(['username' => $input['username']]);
        $student_id = $this->accounts->get(['student_id' => $input['student_id']]);
        if ($exists || $student_id) {
            $this->session->set_flashdata('error', 'Username already taken.');
            redirect('register_account');
        }

        // Insert into accounts
        $this->db->insert('accounts', [
            'username' => $input['username'],
            'password' => $input['password'], // Consider hashing in production
            'student_id' => $input['student_id'],
            'role' => 'student'
        ]);
        $account_id = $this->db->insert_id();

        // Insert into class_student
        $this->db->insert('class_student', [
            'student_id' => $input['student_id'],
            'class_id' => $input['class_id']
        ]);

        $this->session->set_flashdata('success', 'Account registered. Please login.');
        redirect();
    }
}
