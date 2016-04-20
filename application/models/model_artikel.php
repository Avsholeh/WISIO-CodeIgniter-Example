<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
 *
 *  Author @avsholeh
 * 
 **/
class Model_Artikel extends CI_Model {
    
    /* 
        Menambahkan artikel

        @param  (array) $data 
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function tambah_artikel($data)
    {
        $sql = "INSERT INTO artikel
                (judul, isi_artikel, tanggal, status, akun_id_akun)
                VALUE
                ('". $data['judul'] ."', '". $data['isi_artikel'] ."', 
                '". $data['tanggal'] ."', '". $data['status'] ."', 
                ". $data['id_akun'] .")";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Melakukan UPDATE artikel

        @param  (array) $data
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function update_artikel($data)
    {
        $sql = "UPDATE artikel
                SET judul           = '". $data['judul'] ."',
                    isi_artikel     = '". $data['isi_artikel'] ."',
                    status          = 'belum diseleksi'
                WHERE id_artikel = ". $data['id_artikel'] ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Mengambil artikel berdasarkan id_artikel
        
        @param  (int) $id_artikel
        @return semua data artikel
    */
    public function ambil_artikel_id($id_artikel)
    {
         $sql = "SELECT * FROM (SELECT ar.*, ak.nama 
                FROM artikel ar
                LEFT JOIN akun ak
                ON ar.akun_id_akun = ak.id_akun) aa
                WHERE id_artikel = '". $id_artikel ."'";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    
    /* 
        Mengambil semua artikel berdasarkan status seleksi
        
        @param  (string) $status
        @return semua data artikel
    */
    public function ambil_artikel($status)
    {
        $sql = "SELECT * FROM (SELECT ar.*, ak.nama 
                FROM artikel ar
                LEFT JOIN akun ak
                ON ar.akun_id_akun = ak.id_akun) aa
                WHERE status = '". $status ."'";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /* 
        Mengambil artikel tertentu berdasarkan id_artikel dan status
        
        @param  (int)$id_artikel, (string) $status
        @return semua artikel berdasarkan id_artikel dan status
    */
    public function ambil_artikel_status($id_artikel, $status)
    {
        $artikel_id = (int) $id_artikel;
        
        $sql = "SELECT * FROM (SELECT ar.*, ak.nama 
                FROM artikel ar
                LEFT JOIN akun ak
                ON ar.akun_id_akun = ak.id_akun) aa
                WHERE status = '". $status ."' AND
                id_artikel = ". $artikel_id ."";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /* 
        Mengambil semua artikel dari seorang user
        
        @param  (int) $id_akun
        @return semua artikel
    */
    public function ambil_artikel_user($id_akun)
    {
        $sql = "SELECT * FROM artikel 
                WHERE akun_id_akun = ". $id_akun ."
                ORDER BY tanggal DESC";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Melakukan update status artikel menjadi 'sudah diseleksi' pada kolom status
        
        @param  (int) $id_artikel
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function update_status_artikel($id_artikel)
    {
        $sql = "UPDATE artikel
                SET status = 'sudah diseleksi'                       
                WHERE id_artikel = ". $id_artikel ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Mencari artikel yang sesuai dengan kata kunci yang dimasukkan user
        
        @param  (string) $string
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function cari_artikel($keyword)
    {
        $sql = "SELECT * FROM artikel 
                WHERE status = 'sudah diseleksi' AND
                judul LIKE '%". $keyword ."%' OR isi_artikel LIKE '%". $keyword ."%'";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Mengambil komentar berdasarkan id_komentar
        
        @param  (int) $id_komentar
        @return data komentar dari table komentar
    */
    public function ambil_komentar($id_komentar)
    {
        $sql = "SELECT * FROM komentar
                WHERE id_komentar = ". $id_komentar ."";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /* 
        Mengambil komentar dari sebuah artikel
        
        @param  (int) $id_artikel
        @return data komentar dari table komentar
    */
    public function ambil_komentar_artikel($id_artikel)
    {
        $sql = "SELECT * FROM (SELECT k.*, a.nama, a.id_akun FROM komentar k
                LEFT JOIN akun a
                ON k.akun_id_akun = a.id_akun) ak
                WHERE ak.artikel_id_artikel = ". $id_artikel ."
                ORDER BY tanggal_komentar DESC";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    /* 
        Mengambil komentar berdasarkan id_akun
        
        @param  (int) $id_akun
        @return data komentar dari table komentar
    */
    public function ambil_komentar_user($id_akun)
    {
        $sql = "SELECT * FROM komentar WHERE akun_id_akun = ". $id_akun ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Menghapus artikel tertentu
        
        @param  (int) $id_artikel
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function hapus_artikel($id_artikel)
    {
        $sql = "DELETE FROM artikel
                WHERE id_artikel = ". $id_artikel ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Menghapus semua artikel milik user
        
        @param  (int) $id_akun
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function hapus_artikel_user($id_akun)
    {
        
        $sql = "DELETE FROM artikel
                WHERE akun_id_akun = ". $id_akun ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Menghapus komentar tertentu
        
        @param  (int) $id_komentar
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function hapus_komentar($id_komentar)
    {
        $sql = "DELETE FROM komentar
                WHERE id_komentar = ". $id_komentar ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    /*     
        Menghapus semua komentar user
    
        @param  (int) $id_akun
    
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function hapus_komentar_user($id_akun)
    {
        $sql = "DELETE FROM komentar
                WHERE akun_id_akun = ". $id_akun ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Menghapus semua komentar yang berada didalam sebuah artikel
    
        @param  (int) $id_artikel
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function hapus_komentar_artikel($id_artikel)
    {
        $sql = "DELETE FROM komentar 
                WHERE artikel_id_artikel = ". $id_artikel ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /*  
        Melakukan UPDATE komentar tertentu
    
        @param  (int) $id_komentar 
                (string) $isi_komentar
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function update_komentar($id_komentar, $isi_komentar)
    {
        $sql = "UPDATE komentar
                SET isi_komentar = '". $isi_komentar ."'
                WHERE id_komentar = ". $id_komentar ."";
        
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    /* 
        Menambahkan komentar pada artikel yang terkait 
        
        @param  (int) $id_artikel
                (string) $isi_komentar
        @return hasil dari query
                true, jika proses berhasil
                false, jika proses gagal
    */
    public function tambah_komentar($data)
    {
        $sql = "INSERT INTO komentar 
                (tanggal_komentar, isi_komentar, artikel_id_artikel, akun_id_akun)
                VALUE ('". $data['tanggal_komentar'] ."'
                , '". $data['isi_komentar'] ."',
                ". $data['id_artikel'] .", ". $data['id_akun'] .")";
     
        $query = $this->db->query($sql);
        
        return $query;
    }
}