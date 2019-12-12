<?php

class User extends CI_Model
{
    function ambil_user() 
    {
        return $this->db->get('users');
    }

    function show_edit_user($where) 
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    public function update_user($where, $data, $table) 
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function daftaruser_cari($keyword){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->like('nama',$keyword);
        $this->db->or_like('kd_user',$keyword);
        return $this->db->get()->result();
    }

    public function hapus_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

}