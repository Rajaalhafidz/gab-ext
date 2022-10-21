<?php
defined('BASEPATH') or exit('No direct script access allowed');

// panggil file "Server.php"
require APPPATH . "/libraries/Server.php";
class Mahasiswa extends Server
{
    // buat service GET
    function service_get()
    {
        // panggil model "Mmahasiswa"
        $this->load->model("Mmahasiswa", "mdl", TRUE);
        // panggil method "get_data"
        $hasil = $this->mdl->get_data();
        // panggil respon dan menampilkan data dalam format JSON
        $this->response(array("mahasiswa" => $hasil), 200);
        // Memanggil data tidak menggunakan object json
        // $this->response($hasil, 200);
    }

    // buat service DELETE
    function service_delete()
    {
        // panggil model mahasiswa
        $this->load->model("Mmahasiswa", "mdl", TRUE);
        // ambil data parameter npm sebagai dasar penghapusan data
        $token = $this->delete("npm");
        // panggil method hapus_data
        $hasil = $this->mdl->hapus_data(base64_encode($token));
        // jika data mahasiswa berhasil dihapus
        if ($hasil == 1) {
            // tampilkan jika data berhasil dihapus dan ditampilkan dalam format JSON
            $this->response(array("status" => "Data berhasil dihapus"), 200);
        }
        // jika data mahasiswa gagal dihapus
        else {
            // tampilkan jika data gagal dihapus dan di tampilkan dalam format JSON
            $this->response(array("status" => "Data gagal dihapus"), 200);
        }
    }

    // buat service POST
    function service_post()
    {
        // panggil model mahasiswa
        $this->load->model("Mmahasiswa", "mdl", TRUE);
        $data = array(
            "npm" => $this->post("npm"),
            "nama" => $this->post("nama"),
            "telepon" => $this->post("telepon"),
            "jurusan" => $this->post("jurusan"),
            //$data["npm"] = $this-> post("npm");
            //$data["nama"] = $this-> post("nama");
        );


        //panggil method "simpan data"
        $hasil = $this->mdl->get_data($data["npm"], $data["nama"], $data["telepon"], $data["jurusan"]);
        //jika data mahasiswa tidak ditemukan
        if ($hasil == 0) {
            // tampilkan jika data berhasil dihapus dan ditampilkan dalam format JSON
            $this->response(array("status" => "Data berhasil dihapus"), 200);
        } else {
            $hasil = 0;
        }
        //kirim nilai $hasil ke "controller" Mahasiswa
        return $hasil;
    }
    function get_data($npm, $nama, $telepone, $jurusan)
    {
        // cek apakah npm tersedia atau tidak
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        $this->db->where("npm = '$npm'");
        $query = $this->db->get()->result();
        // jika npm tidak ditemukan
        if (count($query) == 0) {
            $data = array(
                "npm" => $npm,
                "nama" => $nama,
                "telepon" => $telepone,
                "jurusan" => $jurusan,
            );
            $this->db->insert("tb_mahasiswa", $data);
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        return $hasil;
    }

    // buat service PUT
    function service_put()
    {
    }
}
