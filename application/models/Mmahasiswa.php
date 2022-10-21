<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmahasiswa extends CI_Model
{

    // bbuat fungsi "get_data"
    function get_data()
    {
        // Menyamarkan field database phpmyadmin
        $this->db->select("id AS id_mhs,
        npm AS npm_mhs,
        nama AS nama_mhs,
        telepon AS telepon_mhs,
        jurusan AS jurusan_mhs");

        // ambil data dari table tb_mahasiswa
        $this->db->from("tb_mahasiswa");
        $this->db->order_by("npm");

        // menyimpan query kedalam variabel query
        $query = $this->db->get()->result();

        return $query;
    }
    // method hapus data
    function hapus_data($token)
    {
        // cek apakah npm tersedia atau tidak
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        $this->db->where("to base64(npm) = '$token'");
        $query = $this->db->get()->result();
        // jika npm ditemukan
        if (count($query) == 1) {
            // hapus data
            // $this->db->where("npm = '$token'");
            $this->db->where("to base64(npm) = ", $token);
            $this->db->delete("tb_mahasiswa");
            $hasil = 1;
        }
        // jika npm tidak ditemukan
        else {
            $hasil = 0;
        }

        // kirim nilai hasil ke controller Mahasiswa
        return $hasil;
    }
}
