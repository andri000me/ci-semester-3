<?php

class UploadController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('genre');
        if($this->session->userdata('masuk_admin') != TRUE)
        {
            $url = base_url('login');
            redirect($url);
        }
    }
	public function index() 
		{
		$this->load->view('head');
		$this->load->view('isi');
		$this->load->view('bawahan');
		}
	public function home() 
		{
		$this->load->view('admin/home_admin');
		$this->load->view('admin/isi_admin');
		}
	/*public function admin() 
		{
			$this->load->view('admin/home_admin');
			$this->load->view('admin/isi_admin');
		}*/
	
		public function daftar() 
		{
            $data['lagu'] = $this->playlist->joinTable()->result();
            // $data['lagu'] = $this->playlist->joinTable()->result();
            $this->load->view('admin/home_admin');
            $this->load->view('admin/daftarlagu', $data);
        }

        public function daftargenre()
        {
            $data['lagu'] = $this->playlist->ambil_genre()->result();
            // $data['lagu'] = $this->playlist->joinTable()->result();
            $this->load->view('admin/home_admin');
            $this->load->view('admin/daftargenre', $data);
        }

        public function edit_genre($id = null) 
        {
            $where = array(
                'kd_genre' => $id
            );

		    $this->load->view('admin/home_admin');
            $data['genres'] = $this->genre->show_edit_genre($where);
            $this->load->view('edit_genre', $data);
        }
        
        public function edit($id = null) 
        {
            $where = array(
                'kd_lagu' => $id
            );

		    $this->load->view('admin/home_admin');
            $data['lagu'] = $this->playlist->edit_daftar_genre($where, 'lagu')->result();
            $data['uploader'] = $this->playlist->joinTable()->result();
            $data['genres'] = $this->genre->show_genre()->result();
            $data['genre'] = $this->playlist->edit_daftar_genre($where, 'lagu')->result();
            $this->load->view('edit_lagu', $data);
        }

        public function update() 
        {
            $data_lagu = array(
                'upload_path' => './assets/music/', // folder lagu di simpan
                'file_name' => $this->input->post('judul_lagu'),
                'allowed_types' => 'mp3', // ekstensi yang diizinkan
                'overwrite' => true, // replace lagu yang sudah ada
                'max_size' => 20480 // 20MB
            );
            
            $this->load->library('upload', $data_lagu);
    
            $data = array(
                'judul_lagu' => $this->input->post('judul_lagu'),
                'penyanyi' => $this->input->post('penyanyi'),
                'kd_genre' => $this->input->post('kd_genre'),
                'album' => $this->input->post('album'),
                'dirilis' => $this->input->post('dirilis')
            );

            $where = array(
                'kd_lagu' => $this->input->post('kd_lagu')
            );
    
            $this->playlist->update_daftar($where, $data, 'lagu');
            
            if(!$this->upload->do_upload('berkas'))
            {
                // $error = array('error' => $this->upload->display_errors());
                // redirect('admin/dashboard/daftar-lagu');
                redirect('admin/dashboard/daftar-lagu');
            } 
            else
            {
                $msg = $this->session->set_flashdata('sukses', 'Lagu Berhasil Ditambahkan!');
                redirect('admin/dashboard/daftar-lagu');
            }
        }

        public function update_genre() 
        {
            $data = array(
                'upload_path' => './assets/img/home/pop/', // folder lagu di simpan
                'file_name' => $this->input->post('thumbnail'),
                'allowed_types' => 'jpg', // ekstensi yang diizinkan
                'overwrite' => true, // replace lagu yang sudah ada
                'max_size' => 1024 // 1MB
            );
            
            $this->load->library('upload', $data);
    
            $data = array(
                'genre' => $this->input->post('genre'),
                'thumbnail' => $this->input->post('thumbnail') . '.jpg',
                'slug' => $this->input->post('slug')
            );

            $where = array(
                'kd_genre' => $this->input->post('kd_genre')
            );
    
            $this->playlist->update_genre($where, $data, 'genre_music');
            
            if(!$this->upload->do_upload('berkas'))
            {
                // $error = array('error' => $this->upload->display_errors());
                // redirect('admin/dashboard/daftar-lagu');
                redirect('admin/dashboard/daftar-genre');
            } 
            else
            {
                $msg = $this->session->set_flashdata('sukses', 'Genre Berhasil Diupdate!');
                redirect('admin/dashboard/daftar-genre');
            }
        }

        public function hapus($id = null)
        {
            $where = array(
                'kd_lagu' => $id,
                'judul_lagu' => $this->input->post('judul_lagu')
            );
            
            unlink('./assets/music'. '/' . str_replace(' ', '_', $where['judul_lagu']) . '.mp3');
            $this->playlist->hapus_data($where,'lagu');
            redirect('admin/dashboard/daftar-lagu');
        }

        public function hapus_genre($id = null)
        {
            $where = array(
                'kd_genre' => $id,
                'thumbnail' => $this->input->post('thumbnail')
            );
            unlink('./assets/img/home/pop'. '/' . str_replace(' ', '_', $where['thumbnail']));

            $this->playlist->hapus_data($where,'genre_music');
            redirect('admin/dashboard/daftar-genre');
        }

        public function cari() 
        {
            $keyword = $this->input->post('keyword');
            $data['products']=$this->playlist->daftarlagu_cari($keyword);
			$this->load->view('admin/home_admin');
            $this->load->view('daftarlagu-cari',$data);
        }

        public function cari_genre() 
        {
            $keyword = $this->input->post('keyword');
            $data['products']=$this->playlist->daftargenre_cari($keyword);
			$this->load->view('admin/home_admin');
            $this->load->view('daftargenre-cari',$data);
        }
	
    public function admin()
    {
        // die();
		$this->load->view('admin/home_admin');
        $genre['genres'] = $this->genre->show_genre()->result();
        $genre['lagu'] = $this->user->ambil_admin()->result();
        $this->load->view('admin/inputlagu', $genre);
    }

    public function tambahgenre()
    {
        $this->load->view('admin/home_admin');
        $this->load->view('admin/isi_genre');
    }

    public function store()
    {

        
        $data = array(
            'upload_path' => './assets/music/', // folder lagu di simpan
            'file_name' => $this->input->post('judul_lagu'),
            'allowed_types' => 'mp3', // ekstensi yang diizinkan
            'overwrite' => true, // replace lagu yang sudah ada
            'max_size' => 20480 // 20MB
        );
        
        $this->load->library('upload', $data);
        // $kd_admin = $this->input->post('kd_admin');
        
        $todb = array(
            'judul_lagu' => $this->input->post('judul_lagu'),
            'penyanyi' => $this->input->post('penyanyi'),
            'kd_genre' => $this->input->post('kd_genre'),
            'album' => $this->input->post('album'),
            'dirilis' => $this->input->post('dirilis'),
            'kd_admin' => $this->session->userdata('session_id'),
            'tgl_upload' => time()
        );

        // die($todb['kd_admin']);
        
        $this->db->insert('lagu', $todb);
       

        if(!$this->upload->do_upload('berkas'))
        {
            $error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/home_admin');
            $this->load->view('admin/isi_admin', $error);;
        } 
        else
        {
            $msg = $this->session->set_flashdata('sukses', 'Lagu Berhasil Ditambahkan!');
            redirect('admin/dashboard/daftar-lagu');
        }
			

    }

    public function storegenre()
    {
        $data = array(
            'upload_path' => './assets/img/home/pop/', // folder lagu di simpan
            'file_name' => $this->input->post('thumbnail'),
            'allowed_types' => 'jpg', // ekstensi yang diizinkan
            'overwrite' => true, // replace lagu yang sudah ada
            'max_size' => 1024 // 1MB
        );
        
        $this->load->library('upload', $data);
        // die($data['file_name']);
        $todb = array(
            'tgl_buat' => time(),
            'genre' => $this->input->post('genre'),
            'thumbnail' => $data['file_name'] . '.jpg',
            'slug' => $this->input->post('slug')
        );

        $this->db->insert('genre_music', $todb);
       

        if(!$this->upload->do_upload('berkas'))
        {
            $error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/home_admin');
            $this->load->view('admin/isi_genre', $error);;
        } 
        else
        {
            $msg = $this->session->set_flashdata('sukses', 'Lagu Berhasil Ditambahkan!');
            redirect('admin/dashboard/daftar-genre');
        }
			

    }

    public function daftaruser()
    {
        $data['users'] = $this->user->ambil_user()->result();
        // $data['lagu'] = $this->playlist->joinTable()->result();
        $this->load->view('admin/home_admin');
        $this->load->view('admin/daftaruser', $data);
    }

    public function edit_user($id = null) 
    {
        $where = array(
            'kd_user' => $id
        );

	    $this->load->view('admin/home_admin');
        $data['users'] = $this->user->show_edit_user($where);
        $this->load->view('edit_user', $data);
    }

    public function update_user()
	{
        $data = array(
            'nama' => ucwords($this->input->post('nama')),
            'email' => strtolower($this->input->post('email')),
            'password' => md5($this->input->post('password')),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jk' => $this->input->post('jk'),
            'level' => $this->input->post('level'),
            'status' => $this->input->post('status')
        );

        
        $where = array(
            'kd_user' => $this->input->post('kd_user')
        );
        
        // die($where['kd_user']);  

        $this->user->update_user($where, $data, 'users');
        // $this->session->set_userdata('session_nama', $data['nama']);
        $msg = $this->session->set_flashdata('sukses', 'User Berhasil Diupdate!');
        redirect('admin/dashboard/daftar-user');  
    }

    public function cari_user() 
    {
        $keyword = $this->input->post('keyword');
        $data['users']=$this->user->daftaruser_cari($keyword);
		$this->load->view('admin/home_admin');
        $this->load->view('daftaruser-cari',$data);
    }

    public function tambahuser()
    {
        $this->load->view('admin/home_admin');
        $this->load->view('admin/tambah_user');
    }

    public function storeuser()
    {
        // $data = array(
        //     'upload_path' => './assets/img/home/pop/', // folder lagu di simpan
        //     'file_name' => $this->input->post('thumbnail'),
        //     'allowed_types' => 'jpg', // ekstensi yang diizinkan
        //     'overwrite' => true, // replace lagu yang sudah ada
        //     'max_size' => 1024 // 1MB
        // );
        
        // $this->load->library('upload', $data);

        $todb = array(
            'nama' => ucwords($this->input->post('nama')),
            'password' => md5($this->input->post('password')),
            'email' => strtolower($this->input->post('email')),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jk' => $this->input->post('jk'),
            'level' => $this->input->post('level'),
            'status' => $this->input->post('status')
        );

        $this->db->insert('users', $todb);
        redirect('admin/dashboard/daftar-user');  

       

        // if(!$this->upload->do_upload('berkas'))
        // {
        //     $error = array('error' => $this->upload->display_errors());
		// 	$this->load->view('admin/home_admin');
        //     $this->load->view('admin/isi_genre', $error);;
        // } 
        // else
        // {
        //     $msg = $this->session->set_flashdata('sukses', 'Lagu Berhasil Ditambahkan!');
        //     redirect('admin/dashboard/daftar-genre');
        // }
    }

    public function hapus_user($id = null)
    {
        $where = array(
            'kd_user' => $id
        );
        
        // unlink('./assets/img/home/pop'. '/' . str_replace(' ', '_', $where['thumbnail']));

        $this->user->hapus_data($where,'users');
        redirect('admin/dashboard/daftar-user');
    }

    public function deleteUser()
    {
        $kd_user = $this->input->post('kd_user');
        $this->user->deleteData($kd_user);
        redirect('admin/dashboard/daftar-user');
    }

    public function daftaradmin()
    {
        $data['users'] = $this->user->ambil_admin()->result();
        // $data['lagu'] = $this->playlist->joinTable()->result();
        $this->load->view('admin/home_admin');
        $this->load->view('admin/daftaradmin', $data);
    }

    public function edit_admin($id = null) 
    {
        $where = array(
            'kd_admin' => $id
        );

	    $this->load->view('admin/home_admin');
        $data['users'] = $this->user->show_edit_admin($where);
        $this->load->view('edit_admin', $data);
    }

    public function update_admin()
	{
        $data = array(
            'nama' => 'a_' . ucwords($this->input->post('nama')),
            'password' => md5($this->input->post('password')),
            'email' => strtolower($this->input->post('email')),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jk' => $this->input->post('jk'),
            'level' => $this->input->post('permission'),
        );

        
        $where = array(
            'kd_admin' => $this->input->post('kd_admin')
        );
        
        // die($where['kd_user']);  

        $this->user->update_user($where, $data, 'admin');
        // $this->session->set_userdata('session_nama', $data['nama']);
        $msg = $this->session->set_flashdata('sukses', 'User Berhasil Diupdate!');
        redirect('admin/dashboard/daftar-admin');  
    }

    public function cari_admin() 
    {
        $keyword = $this->input->post('keyword');
        $data['users']=$this->user->daftaradmin_cari($keyword);
		$this->load->view('admin/home_admin');
        $this->load->view('daftaradmin-cari',$data);
    }

    public function tambahadmin()
    {
        $this->load->view('admin/home_admin');
        $this->load->view('admin/tambah_admin');
    }

    public function storeadmin()
    {
        // $data = array(
        //     'upload_path' => './assets/img/home/pop/', // folder lagu di simpan
        //     'file_name' => $this->input->post('thumbnail'),
        //     'allowed_types' => 'jpg', // ekstensi yang diizinkan
        //     'overwrite' => true, // replace lagu yang sudah ada
        //     'max_size' => 1024 // 1MB
        // );
        
        // $this->load->library('upload', $data);

        $todb = array(
            'nama' => 'a_' . ucwords($this->input->post('nama')),
            'password' => md5($this->input->post('password')),
            'email' => strtolower($this->input->post('email')),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jk' => $this->input->post('jk'),
            'level' => $this->input->post('permission'),
        );

        $this->db->insert('admin', $todb);
        redirect('admin/dashboard/daftar-admin');  

       

        // if(!$this->upload->do_upload('berkas'))
        // {
        //     $error = array('error' => $this->upload->display_errors());
		// 	$this->load->view('admin/home_admin');
        //     $this->load->view('admin/isi_genre', $error);;
        // } 
        // else
        // {
        //     $msg = $this->session->set_flashdata('sukses', 'Lagu Berhasil Ditambahkan!');
        //     redirect('admin/dashboard/daftar-genre');
        // }
    }

    public function hapus_admin($id = null)
    {
        $where = array(
            'kd_admin' => $id
        );
        
        // unlink('./assets/img/home/pop'. '/' . str_replace(' ', '_', $where['thumbnail']));

        

        $this->user->hapus_data($where,'admin');
        redirect('admin/dashboard/daftar-admin');
    }
}
