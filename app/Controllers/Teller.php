<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Teller extends BaseController
{
    public function index()
    {
        if ($this->user_role != "admin") {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->teller_model->orderBy('nama_lengkap', 'ASC');
        $teller_list = $this->teller_model->findAll();

        $data = [
            'title' => 'List Teller',
            'teller_list' => $teller_list
        ];

        return view('teller/index', $data);
    }

    public function tambah()
    {
        if ($this->user_role != "admin") {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Tambah Teller Baru',
            ];
            // tampilkan halaman form untuk menambah data teller baru
            return view('teller/tambah', $data);
        } else if ($this->request->is('post')) {
            // PROSES TAMBAH DATA
            // ambil data dari form
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $konfirmasi_password = $this->request->getPost('konfirmasi_password');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');
            $nomor_telepon = $this->request->getPost('nomor_telepon');

            $this->validateData(
                [
                    'username' => $username,
                    'password' => $password,
                    'nama_lengkap' => $nama_lengkap,
                    'alamat' => $alamat,
                    'email' => $email,
                    'nomor_telepon' => $nomor_telepon,
                ],
                $this->teller_model->getValidationRules([
                    'only' => [
                        'username',
                        'password',
                        'nama_lengkap',
                        'alamat',
                        'email',
                        'nomor_telepon',
                    ]
                ]),
                $this->teller_model->getValidationMessages()
            );

            // jika data tidak valid, maka tampilkan error menggunakan flashdata
            // dan redirect ke halaman form kembali
            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            // validasi data
            if ($password != $konfirmasi_password) {
                $this->session->setFlashdata([
                    'error_list' => ['password' => 'Password dan konfirmasi password tidak sama']
                ]);
                return redirect()->back();
            }

            // jika data valid, maka simpan data ke database
            $this->teller_model->insert([
                'username' => $username,
                'password' => $password,
                'nama_lengkap' => $nama_lengkap,
                'alamat' => $alamat,
                'email' => $email,
                'nomor_telepon' => $nomor_telepon,
                'is_active' => 1,
            ]);

            if ($errors = $this->teller_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata('sukses_list', ['pesan' => 'Teller berhasil ditambah']);

                return redirect()->to('teller');
            }

            // redirect ke halaman list
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ubah(int $id)
    {
        // Jika role bukan admin dan bukan teller yang bersangkutan, maka
        // tampilkan halaman error 403 (404)
        if (
            !($this->user_role == 'admin'
                || ($this->user_role == 'teller' && $this->logged_in_user['id'] == $id)
            )
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ambil data dari database pada table teller berdasarkan id
        $teller = $this->teller_model->find($id);

        // jika data tidak ditemukan, maka tampilkan error 404
        if (!$teller) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Ubah Teller',
                'teller' => $teller,
            ];

            return view('teller/ubah', $data);
        } else if ($this->request->is('post')) {
            // PROSES UBAH DATA
            // ambil data dari form
            $username = $this->request->getPost('username');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');
            $nomor_telepon = $this->request->getPost('nomor_telepon');
            $is_active = $this->user_role == 'admin' ? $this->request->getPost('is_active') : $teller['is_active'];

            // validasi data
            $this->validateData(
                [
                    'id' => $id,
                    'username' => $username,
                    'nama_lengkap' => $nama_lengkap,
                    'alamat' => $alamat,
                    'email' => $email,
                    'nomor_telepon' => $nomor_telepon,
                ],
                $this->teller_model->getValidationRules([
                    'only' => [
                        'id',
                        'username',
                        'nama_lengkap',
                        'alamat',
                        'email',
                        'nomor_telepon',
                    ]
                ]),
                $this->teller_model->getValidationMessages()
            );

            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            $this->teller_model->update($id, [
                'id' => $id,
                'username' => $username,
                'nama_lengkap' => $nama_lengkap,
                'alamat' => $alamat,
                'email' => $email,
                'nomor_telepon' => $nomor_telepon,
                'is_active' => $is_active == 'on' || $is_active ? 1 : 0,
            ]);

            if ($errors = $this->teller_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata(
                    'sukses_list',
                    ['teller' => join(' ', ['Teller', $teller['nama_lengkap'], 'berhasil diubah'])]
                );

                return redirect()->to('teller/ubah/' . $id);
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ganti_password(int $id)
    {
        if (
            !($this->user_role == 'admin'
                || ($this->user_role == 'teller' && $this->logged_in_user['id'] == $id)
            )
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');
        $konfirmasi_password_baru = $this->request->getPost('konfirmasi_password_baru');

        $this->validateData(
            [
                'password' => $password_baru,
            ],
            $this->teller_model->getValidationRules([
                'only' => [
                    'password',
                ]
            ]),
            $this->teller_model->getValidationMessages()
        );

        if ($errors = $this->validator->getErrors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        }

        $teller = $this->teller_model->find($id);

        if (!$teller) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!password_verify((string) $password_lama, $teller['password'])) {
            $this->session->setFlashdata('error_list', ['password' => 'Password lama salah']);

            return redirect()->back();
        }

        if ($password_baru != $konfirmasi_password_baru) {
            $this->session->setFlashdata('error_list', ['password' => 'Password baru dan konfirmasi password baru tidak sama']);

            return redirect()->back();
        }


        $this->teller_model->update($id, [
            'password' => $password_baru,
        ]);

        if ($errors = $this->teller_model->errors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        } else {
            $this->session->setFlashdata('sukses_list', ['password' => 'Password berhasil diubah']);

            return redirect()->to('teller/ubah/' . $id);
        }
    }

    public function hapus(int $id)
    {
        // Jika role bukan admin dan bukan teller yang bersangkutan, maka
        // tampilkan halaman error 403 (404)
        if (
            !$this->user_role == 'admin'
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ambil data dari database pada table teller berdasarkan id
        $teller = $this->teller_model->find($id);

        // jika data tidak ditemukan, maka tampilkan error 404
        if (!$teller) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->teller_model->delete($id);

        if ($errors = $this->teller_model->errors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        } else {
            $this->session->setFlashdata(
                'sukses_list',
                ['teller' => join(' ', ['Teller', $teller['nama_lengkap'], 'berhasil dihapus'])]
            );

            return redirect()->to('teller');
        }
    }
}
