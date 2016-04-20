<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**  
    WISIO - Wisata Online Indonesia 
    Author WISIO Team
**/

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_artikel');
        $this->load->model('model_user');
        $this->load->library('form_validation');
    }
    
    //  Menampilkan halaman utama
	public function index()
    {
        $session = $this->session->has_userdata('username');
        if($session) {
            
            //  Menampilkan informasi akun dan artikel
            $id_akun = $this->session->id_akun;
            
            //  Mengambil data user berdasarkan id_akun
            $user = $this->model_user->ambil_data_user($id_akun);
            
            //  'sudah diseleksi' artikel dengan status sudah diseleksi oleh admin
            //  'belum diseleksi' artikel dengan status belum diseleksi oleh admin
            $artikel = $this->model_artikel->ambil_artikel('sudah diseleksi');
            
            //  Menyimpan data user dan artikel ke dalam array
            //  untuk ditampilkan melalui view
            $data = array(
                'user'      => $user->result(),
                'artikel'   => $artikel
            );
            
            //  Mengarahkan user ke halaman Home
            $title['title'] = "Home";
            $this->load->view('header', $title);
            $this->load->view('view_home', $data);
            
        } else {
            
            //  Hanya menampilkan artikel
            $artikel = $this->model_artikel->ambil_artikel('sudah diseleksi');
            
            $data = array('artikel'   => $artikel);
            
            //  Mengarahkan user ke halaman Home
            $title['title'] = "Home";
            $this->load->view('header', $title);
            $this->load->view('view_home', $data);
        }
    }
    
    //  Menampilkan halaman login
    public function login()
    {
        //  Memeriksa apakah user sudah memiliki data session
        $session = $this->session->has_userdata('username');
        
        if ($session) {
            
            //  Jika user telah login maka akan diarahkan
            //  ke halaman home
            redirect('home');
            
        } else {
            
            //  Menampilkan halaman login
            $title['title'] = "Login";
            $this->load->view('header', $title);
            $this->load->view('view_login');
        
        }
    }
    
    //  Menampilkan halaman daftar
    public function daftar()
    {
        $title['title'] = "Daftar";
        $this->load->view('header', $title);
        $this->load->view('view_daftar');
    }
    
    //  Menampilkan halaman artikel tertentu dan sudah diseleksi
    public function artikel($id_artikel)
    {
        //$status = "sudah diseleksi";
        
        //  Mengambil artikel berdasarkan id_artikel
        $ambil_artikel = $this->model_artikel->ambil_artikel_id($id_artikel);
        
        //  Mengambil komentar berdasarkan id_artikel
        $ambil_komentar = $this->model_artikel->ambil_komentar_artikel($id_artikel);
        
        //  Memeriksa session data dari user
        if ($this->session->has_userdata('username')) {
            
            //  Mengambil id_akun dari session data
            $id_akun = $this->session->userdata('id_akun');
            
            //  Mengambil data dari user berdasarkan id_akun
            $user = $this->model_user->ambil_data_user($id_akun);
            
            //  Memasukkan data user, artikel dan komentar kedalam array
            //  untuk dikirimkan ke view
            $data = array(
                'user'      => $user->result(),
                'artikel'   => $ambil_artikel,
                'komentar'  => $ambil_komentar
            );
            
            //  Memanggil view_artikel
            $title['title'] = "Artikel";
            $this->load->view('header', $title);
            $this->load->view('view_artikel', $data);   
            
        } else {
            //  Memasukkan hanya data artikel dan komentar untuk user Guest
            $data = array(
                'artikel'   => $ambil_artikel,
                'komentar'  => $ambil_komentar
            );
            
            //  Memanggil view_artikel
            $title['title'] = "Artikel";
            $this->load->view('header', $title);
            $this->load->view('view_artikel', $data); 
            
        }
    }
    
    //  Melakukan autentikasi login
    public function auth()
    {
        
        $user = $this->input->post('username');
        $pass = md5($this->input->post('password'));
        
        //  Melakukan pengecekan data user didalam database
        $result = $this->model_user->check_user_pass($user, $pass);
        
        if ($result) {
            
            //  Mengambil id_user
            $id_user = $this->model_user->ambil_id($user);
            //  Mengambil data user
            $user    = $this->model_user->ambil_data_user($id_user->row()->id_akun);
            
            $session = array(
                'id_akun'   => (int)$user->row()->id_akun,
                'username'  => $user,
                'tipe_akun' => $user->row()->tipe_akun
            );
            
            //  Menyimpan data user ke dalam session
            $this->session->set_userdata($session);
            
            //  Mengarahkan user ke halaman home
            redirect('home');
            
        } else {
            
            $title['title'] = "Login";
            $msg['error']   = "Username dan password salah!";
            $this->load->view('header', $title);
            $this->load->view('view_login', $msg);
            
        }
    }
    
    //  Melakukan validasi pendaftaran
    public function validasi()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim');
        $this->form_validation->set_rules('username', 'Username', 'trim');
        $this->form_validation->set_rules('password', 'Password', 'trim|md5');
        $this->form_validation->set_rules('re-password', 'Konfirmasi Password', 'trim|matches[password]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email');
        
        $result = $this->model_user->check_username($this->input->post('username'));
        
        if ($this->form_validation->run() == TRUE & $result == TRUE) {
            
            $data = array(
                'nama'      => $this->input->post('nama'),
                'username'  => $this->input->post('username'),
                'password'  => md5($this->input->post('password')),
                'email'     => $this->input->post('email')
            );
            
            $this->model_user->simpan_data($data);
            
            redirect('home/login');
            
        } else {
            
            $title['title'] = "Daftar";
            $this->load->view('header', $title);
            $this->load->view('view_daftar');
            
        }
            
    }
    
    //  Menghapus session dari user
    public function logout()
    {
        //  Memeriksa apakah user mempunyai session
        if ($this->session->has_userdata('username')) {
            
            //  Statement jika hasilnya adalah TRUE
            $data = array('id_akun', 'username');
            
            //  Menghapus session milik user (user telah logout)
            $this->session->unset_userdata($data);
            
            //  Mengarahkan user ke halaman home
            redirect('home');
            
        } else {
            
            //  Statement jika user tidak memiliki session
            //  User akan diarahkan ke halaman login
            redirect('home/login');
            
        }
    }
    
    //  Menambahkan komentar
    public function tambah_komentar($id_artikel)
    {
        //  Sebelum user melakukan komentar, akan dilakukan pengecekan
        //  session pada user. Jika user memiliki session (sudah login)
        //  maka komentar akan disimpan sebagai milik member
        //  Jika tidak memiliki session (belum login/guest user)
        //  maka komentar akan disimpan sebagai milik guest
        if ($this->session->has_userdata('username')) {
            $id_akun = $this->session->userdata('id_akun');
        } else {
            $id_akun = 6;
        }
        
        $data = array(
            'tanggal_komentar'  => date("Y/m/d"),
            'isi_komentar'      => $this->input->post('isi-komentar'),
            'id_artikel'        => $id_artikel,
            'id_akun'           => $id_akun
        );
        
        $this->model_artikel->tambah_komentar($data);
        $url = "home/artikel/". $id_artikel ."";
        redirect($url, 'refresh');
        
    }
    
    //  Memanggil halaman edit komentar
    public function edit_komentar($id_artikel, $id_komentar)
    {
        
        $data['komentar'] = $this->model_artikel->ambil_komentar($id_komentar);
        $title['title'] = "Edit Komentar";
        $this->load->view('header', $title);
        $this->load->view('view_edit_komentar', $data);
    }
    
    //  Mengedit komentar
    public function update_komentar($id_artikel, $id_komentar)
    {
        $isi_komentar = $this->input->post('isi-komentar');
        $this->model_artikel->update_komentar($id_komentar, $isi_komentar);
        
        $url = "home/artikel/".$id_artikel;
        
        redirect($url);
    }
    
    //  Menghapus komentar *TIDAK DIPAKAI*
    //  user hanya bisa menghapus komentarnya sendiri
    public function hapus_komentar($id_artikel, $id_komentar)
    {
        $this->model_artikel->hapus_komentar($id_komentar);
        $url = "home/artikel/".$id_artikel;
        redirect($url);
    }
    
    //  Mencari kata kunci
    public function cari_kata_kunci()
    {
        $keyword = $this->input->get('q');
        
        //  Mencari artikel didalam database dengan method cari_artikel
        $hasil_cari = $this->model_artikel->cari_artikel($keyword);
        $id_akun = $this->session->userdata('id_akun');    
        
        if ($this->session->userdata('username')) {
        
            $data = array ( 
                'artikel'           => $hasil_cari->result(),
                'jumlah_artikel'    => $hasil_cari->num_rows(),
                'user'              => $this->model_user->ambil_data_user($id_akun));
            
        } else {
            
            $data = array ( 
            'artikel'           => $hasil_cari->result(),
            'jumlah_artikel'    => $hasil_cari->num_rows());
        
        }

        $title['title'] = "Hasil Pencarian";
        $this->load->view('header', $title);
        $this->load->view('view_hasil_pencarian', $data);

    }
    
    public function debug()
    {
        $pass = "avsholeh";
        var_dump(md5($pass));
    }
    
}
