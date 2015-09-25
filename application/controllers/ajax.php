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

    public function insert()
    {
        $lng = $this->input->post('lng');
        $lat = $this->input->post('lat');
        $gcid = $this->input->post('gcid');
        $type = $this->input->post('type');

        $this->load->model('users');
        $sessionid = $this->users->insert_session($lng, $lat, $gcid);
        $this->users->insert($type, $sessionid);
        redirect('user', 'refresh');
    }

    public function phone_dropped()
    {
        $phone_number = $this->input->post('phone_number');
        $phone_number_exists = $this->users->phone_number_exists($phone_number);

        $user_id = null;

        if (!$phone_number_exists) {
            $user_id = $this->users->add_phone_number($phone_number);
        } else {
            $user_id = $this->users->get_id_from_phone_number($phone_number);
        }

        $this->users->add_item($user_id, 1, 1);
        echo 'Success';
    }

    public function add_recycle_from_phone()
    {
        $phone_number = $this->input->post('phone_number');
        $phone_number_exists = $this->users->phone_number_exists($phone_number);

        $user_id = null;

        if (!$phone_number_exists) {
            $user_id = $this->users->add_phone_number($phone_number);
        } else {
            $user_id = $this->users->get_id_from_phone_number($phone_number);
        }

        $type = $this->input->post('e_type');
        $collector = $this->input->post('collector');
        $this->users->add_item($user_id, $type, $collector);
        echo 'Success';
    }


}