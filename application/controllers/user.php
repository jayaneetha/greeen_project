<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author thejan rajapakshe <coder [dot] clix [at] gmail [dot] com
 */
class User extends CI_Controller
{

    public function index()
    {
        session_start();
        $this->load->library('session');
        if ($this->session->userdata('logged_in') == FALSE) {
            $this->load->view('login');
        } else {
            redirect('user/dashboard', 'refresh');
        }
    }

    public function dashboard()
    {
        session_start();
        $this->load->library('session');
        if ($this->session->userdata('logged_in') == FALSE) {
            $this->load->view('login');
        } else {
            $gcid = $this->session->userdata('id');
            $this->load->model('users');
            $userDetails = $this->users->get_user_details($gcid);
            $this->load->view('dashboard', array(
                'user' => $userDetails,
            ));
        }
    }

    public function dashboard_bin()
    {
        session_start();
        $this->load->library('session');
        if ($this->session->userdata('logged_in') == FALSE) {
            $this->load->view('login');
        } else {
            $gcid = $this->session->userdata('id');
            $this->load->model('users');
            $userDetails = $this->users->get_user_details($gcid);
            $this->load->view('dashboard_bin', array(
                'user' => $userDetails,
            ));
        }
    }

    public function register_collector()
    {
        if ($this->input->post('firstName')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('firstName', 'First Name', 'required');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('organization', 'Organization', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('passwordConfirm', 'Password Confirm', 'required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('user/register');
            } else {
                $firstName = $this->input->post('firstName');
                $lastName = $this->input->post('lastName');
                $username = $this->input->post('username');
                $organization = $this->input->post('organization');
                $city = $this->input->post('city');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $types = $this->input->post('types');

                $this->load->library('encrypt');

                $password = md5($this->input->post('organization'));

                $collector = array(
                    'fname' => $firstName,
                    'lname' => $lastName,
                    'username' => $username,
                    'organization' => $organization,
                    'city' => $city,
                    'password' => $password,
                    'lat' => $latitude,
                    'lng' => $longitude
                );

                $this->load->model('users');

                $collectorID = $this->users->register_collector($collector);

                $collector_types = array();

                foreach ($types as $value) {
                    $array = array(
                        'collector_id' => $collectorID,
                        'type_id' => $value
                    );
                    array_push($collector_types, $array);
                }
                $this->users->insert_collector_types($collector_types);
                $this->load->view('login');
            }
        } else {
            $this->load->model('users');
            $types = $this->users->get_collectable_types();
            $this->load->view('user/register', array('types' => $types));
        }

    }


    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->model('users');
        $userID = $this->users->get_user_id($username);

        $user = $this->users->get_user_details($userID);

        if ($user->password == md5($password)) {
            $this->session->set_userdata(array('id' => $user->gcid, 'logged_in' => TRUE));
            redirect('user', 'refresh');
        } else {
            $this->load->view('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('user', 'refresh');
    }

    private function manage($id = NULL, $user = NULL)
    {
        if ($id != NULL) {
            $this->load->model('users');
            $user = $this->users->get_user_details($id);
        }
        $data = array(
            'gcid' => $user->gcid,
            'fname' => $user->fname,
            'lname' => $user->lname,
            'city' => $user->city,
            'number' => $user->number,
            'type' => $user->type
        );

        $waste = $this->users->get_collectable_waste($user->gcid);
        $data['waste'] = $waste;
        $this->load->view('user/manage', $data);
    }

    public function get_waste_locations()
    {
        $type = $this->input->get('type');
        $gcid = $this->input->get('gcid');

        $this->load->model('users');
        $type_id = 0;
        switch ($type) {
            case 'paper':
                $type_id = 1;
                break;
            case 'glass':
                $type_id = 2;
                break;
            case 'plastic':
                $type_id = 3;
                break;
            case 'metal':
                $type_id = 4;
                break;
            case 'ewaste':
                $type_id = 5;
                break;
            default:
                $type_id = 0;
        }
        $waste_locations = $this->users->get_waste_locations($type_id, $gcid);
        echo json_encode($waste_locations);
    }

    public function get_bin_locations()
    {
        $type = $this->input->get('type');
        $gcid = $this->input->get('gcid');
        $this->load->model('users');
        $type_id = 0;
        switch ($type) {
            case 'paper':
                $type_id = 1;
                break;
            case 'glass':
                $type_id = 2;
                break;
            case 'plastic':
                $type_id = 3;
                break;
            case 'metal':
                $type_id = 4;
                break;
            case 'ewaste':
                $type_id = 5;
                break;
            default:
                $type_id = 0;
        }
        $bin_locations = $this->users->get_bin_locations($type_id, $gcid);
        echo json_encode($bin_locations);
    }

    public function enterPIN()
    {
        $id = $this->input->post("id");
        $PIN = $this->input->post("PIN");
        $this->load->model('users');
        if ($PIN == $this->users->get_PIN($id)) {
            $this->users->set_item_collected($id);
        }
        redirect('user/dashboard', 'refresh');

    }

    public function insert_dummy(){
        $this->load->model('users');
        $this->users->insert();
        redirect('user','refresh');
    }

}
