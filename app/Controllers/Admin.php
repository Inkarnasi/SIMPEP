<?php

namespace App\Controllers;

//bawah model database
use App\Models\M_Admin;




class Admin extends BaseController
{
    protected $helpers = ['form'];
    #awal cek login
    public function Login()
    {
        echo view('Backend/Main/login');
    }
    public function autentikasi()
    {
        $modelAdmin = new M_Admin;


        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
        if ($cekUsername === 0) {

            return redirect()->to(base_url('/admin/login'))->with('hasil', 'Gagal');

        } else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username])->getRowArray();

            $verifikasi_password = password_verify($password, $dataUser['password_admin']);

            if (!$verifikasi_password) {
                return redirect()->to(base_url('/admin/login'))->with('hasil', 'Gagal');
            } else {
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                ];
                session()->set($dataSession);
                return redirect()->to(base_url('/admin/login'))->with('hasil', 'Berhasil');
            }
        }
    }
    #akhir cek login
    public function daftar()
    {
        echo view('Backend/Main/daftar_baru');
    }

    public function simpan_daftar()
    {

        $modelAdmin = new M_admin;

        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $pw = $this->request->getPost('pw');
        $password_admin_hashed = password_hash($pw, PASSWORD_DEFAULT);
        $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username])->getnumRows();
        if ($dataUser > 0) {
            return redirect()->to(base_url('/admin/daftar'))->with('hasil', 'gagal_admin');
        } else {
            $hasil = $modelAdmin->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "ADM001";
            } else {
                $kode = $hasil['id_admin'];
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id = "ADM" . sprintf("%03s", $noUrut);

            }
            $dataSimpan = [
                'id_admin' => $id,
                'nama_admin' => $nama,
                'username_admin' => $username,
                'password_admin' => $password_admin_hashed,
                'is_delete_admin' => '0',
                'created_at' => date('Y-m-d-H:i:s'),
                'update_at' => date('Y-m-d-H:i:s')
            ];

            $modelAdmin->saveDataAdmin($dataSimpan);
            return redirect()->to(base_url('/admin/daftar'))->with('hasil', 'Berhasil');


        }

    }
    public function Setting()
    {

        $modelAdmin = new M_Admin; //inisiasi model admin
        $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0'])->getResultArray();
        $kirim['data_user'] = $dataUser;

        $uri = service('uri');

        $pages = $uri->getsegment(2);

        $kirim['asal'] = $pages;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $kirim);
        echo view('Backend/Master_Admin/setting');
        echo view('Backend/Template/fuuter');

    }

    public function Tambah_Admin()
    {
        session()->remove('error_list');
        $modelAdmin = new M_admin; //inisiasi model admin

        $uri = service('uri');

        $pages = $uri->getsegment(2);

        $kirim['asal'] = $pages;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $kirim);
        echo view('Backend/Master_Admin/input_admin');
        echo view('Backend/Template/fuuter');

    }
    public function Logout()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "") {
            return redirect()->to(base_url('/admin/login'));
        } else {
            session()->remove('ses_id');
            session()->remove('ses_user');
            session()->remove('ses_level');
            return redirect()->to(base_url('/admin/login'));

        }


    }
    public function hapus_data_admin()
    {

        $modelAdmin = new M_Admin; // inisiasi

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataSimpan = [
            'is_delete_admin' => "1",
            'update_at' => date('Y-m-d H:i:s')
        ];
        $modelAdmin->updateDataAdmin($dataSimpan, ['sha1(id_admin)' => $idHapus]);
        return redirect()->to(base_url('/admin/setting'))->with('hasil', 'hapus_admin');


    }

    public function Form()
    {
        $uri = service('uri');

        $pages = $uri->getsegment(2);

        $kirim['asal'] = $pages;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $kirim);
        echo view('Backend/Main/form');
        echo view('Backend/Template/fuuter');

    }
}
