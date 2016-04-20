<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**  
    WISIO - Wisata Online Indonesia 
    Author WISIO Team
**/

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_artikel');
        $this->load->model('model_user');
        $this->load->library('form_validation');
        
        //  Memeriksa session user, jika tidak ada maka
        //  user dikirim kehalaman login
        if (!$this->session->has_userdata('username')) {
            redirect('home/login', 'refresh');
        }
    }
    
    public function index()
    {
        redirect('home', 'refresh');
    }
    
    public function buat_artikel()
    {
        $title['title'] = "Buat Artikel";
        $this->load->view('header', $title);
        $this->load->view('view_buat_artikel');
    }

    public function informasi_akun()
    {
        $id_akun = $this->session->userdata('id_akun');
        $data = array(
            'user'    => $this->model_user->ambil_data_user($id_akun),
            'artikel' => $this->model_artikel->ambil_artikel_user($id_akun),
        );
        $title['title'] = "Informasi Akun";
        $this->load->view('header', $title);
        $this->load->view('view_informasi_akun', $data);
    }
    
    public function edit_artikel($id_artikel)
    {
        $data['artikel'] = $this->model_artikel->ambil_artikel_id($id_artikel);
        $title['title'] = "Edit Artikel";
        $this->load->view('header', $title);
        $this->load->view('view_edit_artikel', $data);
    }

    public function revisi_artikel($id_artikel)
    {
        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('isi-artikel', 'Isi Artikel', 'trim');
        $data = array(
            'id_artikel'    => $id_artikel,
            'judul'         => $this->input->post('judul'),
            'isi_artikel'   => $this->input->post('isi-artikel')
        );
        $this->model_artikel->update_artikel($data);
        
        redirect('user/informasi_akun');
    }
    
    public function post_artikel()
    {
        if ($this->session->userdata('tipe_akun') == "Admin") {
            $seleksi = "sudah diseleksi";
        } else {
            $seleksi = "belum diseleksi";
        }
        $data = array(
            'judul'         => $this->input->post('judul'),
            'isi_artikel'   => $this->input->post('isi-artikel'),
            'tanggal'       => date("Y/m/d"),
            'status'        => $seleksi,
            'id_akun'       => $this->session->userdata('id_akun')
        );
        
        //  Menambahkan artikel dengan menggunakan method tambah_artikel
        //  pada model_artikel
        $this->model_artikel->tambah_artikel($data);
        
        redirect('user/informasi_akun', 'refresh');
    }
    
    //  Menghapus artikel beserta komentar yang ada didalam artikel tersebut
    public function hapus_artikel($id_artikel)
    {
        $this->model_artikel->hapus_komentar_artikel($id_artikel);
        $this->model_artikel->hapus_artikel($id_artikel);
        redirect('user/informasi_akun', 'refresh');
    }
    
    //  Menghapus akun
    public function hapus_akun()
    {
        $id_akun = $this->session->userdata('id_akun');
        
        //  Memeriksa komentar user, jika ada maka akan dihapus
        $komentar = $this->model_artikel->ambil_komentar_user($id_akun);
        if ($komentar->num_rows() > 0) {
            $this->model_artikel->hapus_komentar_user($id_akun);
        }
        
        //  Memeriksa artikel user, jika ada maka akan dihapus
        $artikel = $this->model_artikel->ambil_artikel_user($id_akun);
        if ($artikel->num_rows() > 0) {
            //  Menghapus semua komentar dari setiap artikel
            foreach($artikel->result() as $row_artikel) {
                $id_artikel = $row_artikel->id_artikel;
                $this->model_artikel->hapus_komentar_artikel($id_artikel);
            }
            //  Menghapus artikel user dengan method hapus_artikel_user
            //  pada model_artikel
            $this->model_artikel->hapus_artikel_user($id_akun);
        }
        
        //  Hapus akun user
        $this->model_user->hapus_data_user($id_akun);
        //  Menghapus session milik user, sehingga user berada dalam
        //  keadaan logout atau keluar dari sistem
        redirect('home/logout');
    }
    
    //  Menampilkan halaman edit akun
    public function edit_akun()
    {
        //  Mengambil dan menyimpan data user ke dalam array
        $id_akun = $this->session->userdata('id_akun');
        $data['user'] = $this->model_user->ambil_data_user($id_akun);
        
        //  Memanggil view_edit_akun serta mengirimkan data user
        //  kedalam view tersebut untuk ditampilkan ke user
        $title['title'] = "Edit Akun";
        $this->load->view('header', $title);
        $this->load->view('view_edit_akun', $data);
    }
    
    //  Menyimpan perubahan ketika user melakukan edit pada akun
    public function simpan_perubahan()
    {
        //  Melakukan validasi terlebih dahulu sebelum data tersebut
        //  benar-benar aman untuk dimasukkan kedalam database
        $this->form_validation->set_rules('nama', 'Nama', 'trim');
        $this->form_validation->set_rules('username', 'Username', 'trim');
        $this->form_validation->set_rules('pwd-lama', 'Password Lama', 'trim');
        $this->form_validation->set_rules('pwd-baru', 'Password Baru', 'trim');
        
        //  Memeriksa status validasi, jika TRUE atau aman maka akan
        //  dilakukan update terhadap data user tersebut
        if ($this->form_validation->run() == TRUE) {
            
            //  Memeriksa password user, jika user memilih untuk
            //  mengganti password maka variable $password akan diisi
            //  dengan password baru. Jika tidak maka varible $password
            //  akan diisi dengan password yang lama 
            /*if ($this->input->post('pwd-baru') == "") {
                $password = md5($this->input->post('pwd-lama'));
            } else {
                $password = md5($this->input->post('pwd-baru'));
            }*/
            
            //  Menyimpan data dalam bentuk array kemudian data ini
            //  akan diolah oleh model
            $data = array(
                'nama'      => $this->input->post('nama'),
                'password'  => md5($this->input->post('pwd-baru')),
                'email'     => $this->input->post('email'),
                'id_akun'   => $this->session->userdata('id_akun')
            );
            
            //  Melakukan update data dengan method update_data_user 
            $this->model_user->update_data_user($data);
            //  Mengarahkan user kehalaman informasi akun setelah
            //  proses update data berhasil dieksekusi
            redirect('user/informasi_akun', 'refresh');
            
        } else {
            
            //  Masukan atau inputan user yang tidak lolos tahap validasi
            //  akan diarahkan kembali ke halaman edit akun
            redirect('user/edit_akun', 'refresh');
            
        }
    }
    
    /** FITUR KHUSUS UNTUK AKUN USER DENGAN TIPE ADMIN  **/
    /** Fitur ini hanya bisa diakses oleh Admin         **/
    
    //  Menampilkan halaman artikel yang harus diseleksi oleh admin
    public function seleksi()
    {
        //  Memeriksa tipe akun user, hal ini dilakukan karena hanya
        //  admin saja yang boleh mengakses halaman seleksi artikel ini
        if ($this->session->userdata('tipe_akun') == "Admin") {
            
            $id_akun = $this->session->userdata('id_akun');
            
            //  Menyimpan data user dan artikel yang belum diseleksi
            //  kedalam array untuk ditampilkan ke halaman seleksi artikel
            $data = array(
                'artikel'   => $this->model_artikel->ambil_artikel("belum diseleksi"),
                'user'      => $this->model_user->ambil_data_user($id_akun)
            );
            
            $title['title'] = "Seleksi Artikel";
            $this->load->view('header', $title);
            $this->load->view('view_seleksi_artikel', $data);
            
        } else {
            //  User dengan tipe_akun selain Admin akan di redirect ke halaman home    
            redirect('home', 'refresh');
        
        }
    }
    
    //  Menampilkan halaman edit artikel seleksi
    public function artikel_seleksi($id_artikel)
    {
        //  Memeriksa tipe akun user, hal ini dilakukan karena hanya
        //  admin saja yang boleh mengakses halaman ini
        if ($this->session->userdata('tipe_akun') == "Admin") {
            
            $data['artikel'] = $this->model_artikel->ambil_artikel_id($id_artikel);
            $title['title'] = "Edit Artikel";
            $this->load->view('header', $title);
            $this->load->view('view_edit_artikel_seleksi', $data);
            
        } else {
            //  User dengan tipe_akun selain Admin akan di redirect ke halaman home 
            redirect('home', 'refresh');
            
        }
        
    }
    
    /*
    PSEUDOCODE : POST_ARTIKEL_SELEKSI()
    
    IF (TIPE AKUN USER == ADMIN) THEN
        UPDATE STATUS ARTIKEL MENJADI SUDAH DISELEKSI
        MENGARAHKAN USER KE HALAMAN SELEKSI
    ELSE
        MENGARAHKAN USER KE HALAMAN HOME
    ENDIF
    
    */
    
    
    //  Menerbitkan artikel yang telah lolos tahap seleksi
    public function post_artikel_seleksi($id_artikel)
    {
        //  Memeriksa data session sebelum mengeksekusi statement dari  post_artikel_seleksi
        if ($this->session->userdata('tipe_akun') == "Admin") {
            
            //  Mengupdate status artikel dari 'belum diseleksi' menjadi 'sudah diseleksi'
            $this->model_artikel->update_status_artikel($id_artikel);
            //  Mengarahkan kembali Admin ke halaman seleksi artikel
            redirect('user/seleksi');
            
        } else {
            
            //  User dengan tipe_akun selain Admin akan di redirect ke halaman home
            redirect('home', 'refresh');
        }
    }

}