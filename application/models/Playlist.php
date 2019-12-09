<?php

class Playlist extends CI_Model
{
    function ambil_lagu() 
    {
        return $this->db->get('lagu');
    }

    public function joinTable() 
    {
        $this->db->select('lagu.*, genre_music.kd_genre, genre_music.genre');
        $this->db->join('genre_music', 'lagu.kd_genre = genre_music.kd_genre');
        $this->db->from('lagu');
        $query = $this->db->get();
        return $query;
    }

    public function edit_daftar($where, $table) 
    {
        
        return $this->db->get_where($table, $where);
    }

    // public function edit_daftar($where, $table) 
    // {
    //     $this->db->select('lagu.*, genre_music.kd_genre, genre_music.genre');
    //     $this->db->join('genre_music', 'lagu.kd_genre = genre_music.kd_genre');
    //     $this->db->from('lagu');
    //     $this->db->where($where);
    //     return $this->db->get();
    // }

    public function edit_daftar_genre($where, $table) 
    {
        $this->db->select('lagu.*, genre_music.kd_genre, genre_music.genre');
        $this->db->join('genre_music', 'lagu.kd_genre = genre_music.kd_genre');
        $this->db->from('lagu');
        $this->db->where($where);
        return $this->db->get();
    }
    

    public function update_daftar($where, $data, $table) 
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function hapus_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

    function genre_pop_indo() 
    {
        $this->db->select('*');
        $this->db->from('lagu');
        $this->db->where('kd_genre', 1);
        return $this->db->get()->result();
    }

    function genre_dangdut() 
    {
        $this->db->select('*');
        $this->db->from('lagu');
        $this->db->where('kd_genre', 2);
        return $this->db->get()->result();
    }

    public function get_product_keyword($keyword){
        $this->db->select('*');
        $this->db->from('lagu');
        $this->db->like('judul_lagu',$keyword);
        $this->db->or_like('penyanyi',$keyword);
        return $this->db->get()->result();
    }

    public function daftarlagu_cari($keyword){
        $this->db->select('*');
        $this->db->from('lagu');
        $this->db->like('judul_lagu',$keyword);
        $this->db->or_like('penyanyi',$keyword);
        $this->db->or_like('album',$keyword);
        return $this->db->get()->result();
    }
}