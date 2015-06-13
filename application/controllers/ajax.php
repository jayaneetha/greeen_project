<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/13/15
 * Time: 8:11 PM
 */
class Ajax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('users');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user_details = $this->users->get_user_details($this->users->get_user_id($username));
        if ($password == $user_details->password) {
            $user_details->login = 'success';
            echo json_encode($user_details);
        } else {
            echo json_encode(array('login' => 'failed'));
        }
    }

    public function dashboard()
    {
        $gcid = $this->input->post('gcid');
        echo json_encode($this->users->get_waste_locations(0, $gcid));
    }

    public function enter_pin()
    {
        $id = $this->input->post("id");
        $PIN = $this->input->post("pin");
        if ($PIN == $this->users->get_PIN($id)) {
            $this->users->set_item_collected($id);
            echo json_encode(array('operation' => 'success'));
        } else {
            echo json_encode(array('operation' => 'wrong_pin'));
        }
    }
}