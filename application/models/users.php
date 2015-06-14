<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_details($gcid)
    {
        $this->db->from('gbcollector');
        $this->db->where('gcid', $gcid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return FALSE;
        }
    }

    public function get_user_id($username)
    {
        $this->db->select('gcid');
        $this->db->from('gbcollector');
        $this->db->where('username', $username);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result()[0]->gcid;
        } else {
            return FALSE;
        }
    }

    public function get_collectable_waste($gcid)
    {
        $this->db->from('individual');
        $this->db->where('assigned', $gcid);
        return $this->db->get();
    }

    public function get_collectable_types()
    {
        $this->db->from('collectables');
        return $this->db->get();
    }

    public function register_collector($data)
    {
        $this->db->insert('gbcollector', $data);
        return $this->db->insert_id();
    }

    public function insert_collector_types($data)
    {
        $this->db->insert_batch('collector_types', $data);
    }

    public function get_waste_locations($type_id, $gcid)
    {
        $this->db->select('individual.id, individual.gtype, individual.assigned, individual.collected, sessions.longitude, sessions.latitude, sessions.created_at, collectables.type');
        $this->db->from('individual');
        $this->db->join('sessions', 'individual.sessionId = sessions.sessionsid', 'inner');
        $this->db->join('collectables', 'individual.gtype = collectables.id', 'inner');
        $this->db->where('individual.assigned', $gcid);
        $this->db->where('individual.collected', 0);
        if ($type_id != 0) {
            $this->db->where('individual.gtype', $type_id);
        }
        return $this->db->get()->result();
    }

    public function get_bin_locations($type_id, $gcid)
    {
        $this->db->select('bin_tb.idbin_tb, bin_tb.bin_id, bin_tb.created_at, bin_tb.gcid, bin_tb.lat, bin_tb.lng, bin_tb.collected, collectables.type');
        $this->db->from('bin_tb');
        $this->db->join('collectables', 'bin_tb.type = collectables.id', 'inner');
        $this->db->where('gcid', $gcid);
        $this->db->where('bin_tb.collected', 0);
        if ($type_id != 0) {
            $this->db->where('bin_tb.type', $type_id);
        }
        return $this->db->get()->result();
    }

    public function get_PIN($id)
    {
        $this->db->select('pin');
        $this->db->from('individual');
        $this->db->where('id', $id);
        return $this->db->get()->result()[0]->pin;
    }

    public function set_item_collected($id)
    {
        $this->db->where('id', $id);
        $this->db->update('individual', array('collected' => 1));
    }

    public function insert_session($lng, $lat, $gcid)
    {
        $sessionid = rand(100, 900);

        $data = array(
            'sessionsid' => $sessionid,
            'tel' => '0767848343',
            'menu' => 1,
            'longitude' => $lng,
            'latitude' => $lat,
        );
        $this->db->insert('sessions', $data);
        return $sessionid;
    }

    public function insert($type, $sessionid)
    {
        $pin = rand(1000, 9999);
        $data = array(
            'gtype'=>$type,
            'assigned'=>2,
            'sessionId'=>$sessionid,
            'pin'=>$pin,
            'sms'=>0
        );
        $this->db->insert('individual',$data);
    }

}