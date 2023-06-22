<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Teller extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // cek role di session
        // jika role tidak sama dengan teller atau admin, maka
        // tampilkan halaman error 403 (404)
        // if ($this->user_role != 'teller' && $this->user_role != 'admin') {
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
    }

    public function index()
    {
        if ($this->user_role != "admin") {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $teller_list = $this->teller_model->findAll();
        $this->teller_model->join('user', 'user.id = teller.id_user');

        $data = [
            'title' => 'Daftar Teller',
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
                'title' => 'Ubah Teller',
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
            $email = $this->request->getPost('email');
            $nomor_telepon = $this->request->getPost('nomor_telepon');

            $this->validateData(
                [
                    'username' => $username,
                    'password' => $password,
                    'nama_lengkap' => $nama_lengkap,
                    'email' => $email,
                    'nomor_telepon' => $nomor_telepon,
                ],
                $this->teller_model->getValidationRules([
                    'only' => [
                        'username',
                        'password',
                        'nama_lengkap',
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

        if ($this->request->is('get')) {
            // ambil data dari database pada table teller berdasarkan id
            $teller = $this->teller_model->find($id);

            // jika data tidak ditemukan, maka tampilkan error 404
            if (!$teller) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

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
            $email = $this->request->getPost('email');
            $nomor_telepon = $this->request->getPost('nomor_telepon');

            // validasi data
            $this->validateData(
                [
                    'username' => $username,
                    'nama_lengkap' => $nama_lengkap,
                    'email' => $email,
                    'nomor_telepon' => $nomor_telepon,
                ],
                $this->teller_model->getValidationRules([
                    'only' => [
                        'username',
                        'nama_lengkap',
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

            $teller = $this->teller_model->find($id);

            if (!$teller) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $this->teller_model->update($id, [
                'username' => $username,
                'nama_lengkap' => $nama_lengkap,
                'email' => $email,
                'nomor_telepon' => $nomor_telepon,
            ]);

            if ($errors = $this->teller_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata(
                    'sukses_list',
                    ['teller' => join(' ', ['Teller', $teller['nama_lengkap'], 'berhasil diubah'])]
                );

                return redirect()->to('teller');
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ganti_password(int $id)
    {
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

        if ($password_baru != $konfirmasi_password_baru) {
            $this->session->setFlashdata('error_list', ['password' => 'Password baru dan konfirmasi password baru tidak sama']);

            return redirect()->back();
        }

        if (!password_verify((string) $password_lama, $teller['password'])) {
            $this->session->setFlashdata('error_list', ['password' => 'Password lama salah']);

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

            return redirect()->to('teller');
        }
    }

    public function hapus(int $id)
    {
        // Jika role bukan admin, maka
        // tampilkan halaman error 403 (404)
        if ($this->user_role != 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // PROSES HAPUS DATA
        // ambil data dari database pada table teller berdasarkan id

        // jika data tidak ditemukan, maka tampilkan error 404

        // jika data ditemukan, maka hapus data dari database

        // tampilkan pesan sukses menggunakan flashdata

        // redirect ke halaman list
    }
}
