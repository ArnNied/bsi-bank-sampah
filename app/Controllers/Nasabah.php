<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Nasabah extends BaseController
{
    function index()
    {
        if (!in_array($this->user_role, ['admin', 'teller'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->nasabah_model->orderBy('nama_lengkap', 'ASC');
        $nasabah_list = $this->nasabah_model->findAll();

        $data = [
            'title' => 'List Nasabah',
            'nasabah_list' => $nasabah_list
        ];

        return view('nasabah/index', $data);
    }

    function tambah()
    {
        if (!in_array($this->user_role, ['admin', 'teller'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Tambah Nasabah Baru'
            ];

            return view('nasabah/tambah', $data);
        } else if ($this->request->is('post')) {
            // ambil data dari form
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $konfirmasi_password = $this->request->getPost('konfirmasi_password');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $alamat = $this->request->getPost('alamat');
            $nomor_telepon = $this->request->getPost('nomor_telepon');
            $email = $this->request->getPost('email');

            // validasi data
            $this->validateData(
                [
                    'username' => $username,
                    'password' => $password,
                    'nama_lengkap' => $nama_lengkap,
                    'alamat' => $alamat,
                    'nomor_telepon' => $nomor_telepon,
                    'email' => $email,
                ],
                $this->nasabah_model->getValidationRules(
                    [
                        'only' => [
                            'username',
                            'password',
                            'nama_lengkap',
                            'alamat',
                            'nomor_telepon',
                            'email',
                        ],
                    ]
                ),
                $this->nasabah_model->getValidationMessages()
            );

            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            if ($password != $konfirmasi_password) {
                $this->session->setFlashdata('error_list', ['password' => 'Konfirmasi password tidak sesuai']);

                return redirect()->back();
            }

            $this->nasabah_model->insert([
                'username' => $username,
                'password' => $password,
                'nama_lengkap' => $nama_lengkap,
                'alamat' => $alamat,
                'nomor_telepon' => $nomor_telepon,
                'email' => $email,
                'saldo' => 0,
                'is_active' => 1,
            ]);

            if ($errors = $this->nasabah_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata('sukses_list', ['nasabah' => 'Berhasil menambah nasabah baru']);

                return redirect()->to('nasabah');
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ubah(int $id)
    {
        if (
            !in_array($this->user_role, ['admin', 'teller'])
            && !($this->user_role == 'nasabah' && $this->logged_in_user['id'] == $id)
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ambil data dari database pada table nasabah berdasarkan id
        $nasabah = $this->nasabah_model->find($id);

        // jika data tidak ditemukan, maka tampilkan error 404
        if (!$nasabah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Ubah Teller',
                'nasabah' => $nasabah,
            ];

            return view('nasabah/ubah', $data);
        } else if ($this->request->is('post')) {
            // PROSES UBAH DATA
            // ambil data dari form
            $username = $this->request->getPost('username');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $alamat = $this->request->getPost('alamat');
            $email = $this->request->getPost('email');
            $nomor_telepon = $this->request->getPost('nomor_telepon');
            $is_active = in_array($this->user_role, ['admin', 'teller']) ? $this->request->getPost('is_active') : $nasabah['is_active'];

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
                $this->nasabah_model->getValidationRules([
                    'only' => [
                        'id',
                        'username',
                        'nama_lengkap',
                        'alamat',
                        'email',
                        'nomor_telepon',
                    ]
                ]),
                $this->nasabah_model->getValidationMessages()
            );

            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            $this->nasabah_model->update($id, [
                'id' => $id,
                'username' => $username,
                'nama_lengkap' => $nama_lengkap,
                'alamat' => $alamat,
                'email' => $email,
                'nomor_telepon' => $nomor_telepon,
                'is_active' => $is_active == 'on' || $is_active ? 1 : 0
            ]);

            if ($errors = $this->nasabah_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata(
                    'sukses_list',
                    ['nasabah' => join(' ', ['Nasabah', $nasabah['nama_lengkap'], 'berhasil diubah'])]
                );

                return redirect()->to('nasabah/ubah/' . $id);
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ganti_password(int $id)
    {
        if (
            !in_array($this->user_role, ['admin', 'nasabah'])
            || !($this->user_role == 'nasabah' && $this->logged_in_user['id'] == $id)
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
            $this->nasabah_model->getValidationRules([
                'only' => [
                    'password',
                ]
            ]),
            $this->nasabah_model->getValidationMessages()
        );

        if ($errors = $this->validator->getErrors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        }

        $nasabah = $this->nasabah_model->find($id);

        if (!$nasabah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        if (!password_verify((string) $password_lama, $nasabah['password'])) {
            $this->session->setFlashdata('error_list', ['password' => 'Password lama salah']);

            return redirect()->back();
        }

        if ($password_baru != $konfirmasi_password_baru) {
            $this->session->setFlashdata('error_list', ['password' => 'Password baru dan konfirmasi password baru tidak sama']);

            return redirect()->back();
        }

        $this->nasabah_model->update($id, [
            'password' => $password_baru,
        ]);

        if ($errors = $this->nasabah_model->errors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        } else {
            $this->session->setFlashdata('sukses_list', ['password' => 'Password berhasil diubah']);

            return redirect()->to('nasabah/ubah/' . $id);
        }
    }

    public function hapus(int $id)
    {
        if (
            !$this->user_role == "admin"
        ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ambil data dari database pada table nasabah berdasarkan id
        $nasabah = $this->nasabah_model->find($id);

        // jika data tidak ditemukan, maka tampilkan error 404
        if (!$nasabah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->nasabah_model->delete($id);

        if ($errors = $this->nasabah_model->errors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        } else {
            $this->session->setFlashdata(
                'sukses_list',
                ['nasabah' => join(' ', ['Nasabah', $nasabah['nama_lengkap'], 'berhasil dihapus'])]
            );

            return redirect()->to('nasabah');
        }
    }
}
