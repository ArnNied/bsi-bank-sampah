<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->logged_in_user) {
            return redirect()->to('');
        }

        if ($this->request->is('get')) {
            // tampilkan halaman login
            $data = [
                'title' => 'Login',
            ];

            return view('auth/login', $data);
        } else if ($this->request->is('post')) {
            // PROSES LOGIN

            // ambil data dari form (username, password)
            $username = $this->request->getPost('username');
            $password = (string) $this->request->getPost('password');
            $role = $this->request->getPost('role');

            // validasi data dengan cara cek masing masing tabel (admin, teller, nasabah)
            // untuk menentukan apakah data tersebut ada di tabel tersebut
            // dan untuk menentukan role dari user tersebut
            // jika data ada di tabel admin, maka role = admin, dst
            $user = '';
            $model = '';

            if ($role == 'admin') {
                $user = $this->admin_model->where('username', $username)->first();
                $model = $this->admin_model;
            } else if ($role == 'teller') {
                $user = $this->teller_model->where('username', $username)->first();
                $model = $this->teller_model;
            } else if ($role == 'nasabah') {
                $user = $this->nasabah_model->where('username', $username)->first();
                $model = $this->nasabah_model;
            } else {
                $this->session->setFlashdata('error_list', ['role' => 'Role tidak ditemukan']);

                return redirect()->back();
            }

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $this->session->set('user', $user);
                    $this->session->set('role', $role);

                    $this->session->setFlashdata('sukses_list', ['login' => 'Anda berhasil login']);

                    $model->update($user['id'], ['terakhir_login' => date('Y-m-d H:i:s')]);

                    return redirect()->to('');
                } else {
                    $this->session->setFlashdata('error_list', ['password' => 'Password salah']);

                    return redirect()->back();
                }
            } else {
                $this->session->setFlashdata('error_list', ['username' => 'Username tidak ditemukan']);

                return redirect()->back();
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function logout()
    {
        // hapus data user dari session
        $this->session->destroy();
        $this->session->setFlashdata('sukses_list', ['logout' => 'Anda berhasil logout']);

        // redirect ke halaman login
        return redirect()->to('');
    }
}
