<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
 *
 *  Author @avsholeh
 * 
 **/

class Model_User extends CI_Model {
    
    /* 
        Mengambil Id_akun user berdasarkan usernamenya
        
        $param  (string) $username
        @return id_akun, jika data user ada didalam database
                null, jika data user tidak terdapat didalam database
    */
    public function ambil_id($username)
    {
        
        $sql = "SELECT id_akun FROM akun 
                WHERE username = '". $username ."' LIMIT 1";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 1) {
            return $query;
        } else {
            return null;    
        }
    }
    
    /* 
        Memasukkan data user (KHUSUS MEMBER)
        
        @param  (array) $data
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function simpan_data($data)
    {
        
        $nama       = $data['nama'];
        $username   = $data['username'];
        $password   = $data['password'];
        $email      = $data['email'];
        $tipe_akun  = $data['tipe_akun'];
        
        $sql = "INSERT INTO akun
                (nama, username, password, email, tipe_akun)
                VALUE
                ('". $nama ."', '". $username ."', '". $password ."',
                '". $email ."', 'Member')";
        
        $query = $this->db->query($sql);
        return $query;
        
    }
    
    /* 
        Mengambil salah satu data user tertentu berdasarkan id
        
        @param (int) $id_akun
        @return semua data user yang sesuai dengan id
    */
    public function ambil_data_user($id_akun)
    {
        
        $sql = "SELECT * FROM akun 
                WHERE id_akun = ". $id_akun ." LIMIT 1";
        
        $query = $this->db->query($sql);
        return $query;
        
    }
    
    /* 
        Menghapus semua data user tertentu termasuk artikel yang dimilikinya
        
        @param  (int) $id_akun
        @return hasil dari query
                 true, jika proses berhasil
                 false, jika proses gagal 
    */
    public function hapus_data_user($id_akun)
    {
                
        $sql = "DELETE FROM akun
                WHERE id_akun = ". $id_akun .";";
        
        $query = $this->db->query($sql);
        return $query;
        
    }
    
    /* 
        Memeriksa ketersediaan username
        
        @param  (string) $username
        @return hasil dari query
                true, jika username belum tersedia
                false, jika username telah tersedia
    */
    public function check_username($username)
    {
        
        $sql = "SELECT username FROM akun WHERE username = '". $username ."'";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /* 
        Memeriksa username dan password
        
        @param  (string) $user, $pass
        @return hasil dari query
                true, jika username dan password sama
                false, jika username dan password berbeda 
    */
    public function check_user_pass($user, $pass)
    {
        
        $sql = "SELECT username, password 
                FROM akun 
                WHERE username = '". $user ."' AND
                password = '". $pass ."'";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /* 
        Melakukan UPDATE data user tertentu
        
        @param  (array) $data
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal 
    */
    public function update_data_user($data)
    {
        
        $sql = "UPDATE akun
                SET nama        = '". $data['nama']      ."',
                    password    = '". $data['password']  ."',
                    email       = '". $data['email']     ."'
                WHERE id_akun   = ". $data['id_akun']   .";";
        
        $query = $this->db->query($sql);
        return $query;
        
    }
}