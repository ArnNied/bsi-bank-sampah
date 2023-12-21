<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Penarikan extends BaseController
{
    public function index()
    {
        if (!$this->user_role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // tampilan halaman list penarikan
        // jika role admin, maka tampilkan semua data penarikan
        // jika role teller atau user, maka tampilkan data penarikan yang memiliki id teller atau user tersebut

        // ambil data dari database pada tabel penarikan

        // tampilkan data ke view

        $this->penarikan_model->select('penarikan.*, nasabah.nama_lengkap as nasabah_nama_lengkap');
        $this->penarikan_model->join('nasabah', 'nasabah.id = penarikan.id_nasabah', 'left');
        $this->penarikan_model->orderBy('tanggal_penarikan', 'DESC');

        if ($this->user_role == 'nasabah') {
            $penarikan_list = $this->penarikan_model->where('id_nasabah', $this->logged_in_user['id']);
        }

        $penarikan_list = $this->penarikan_model->findAll();

        $data = [
            'title' => 'List Setoran',
            'penarikan_list' => $penarikan_list,
        ];

        return view('penarikan/index', $data);
    }

    public function tambah()
    {
        if (!in_array($this->user_role, ['nasabah'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $bank_list = ['BRI', 'BCA', 'Mandiri', 'BNI', 'BTN', 'CIMB Niaga'];

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Tambah Penarikan Baru',
                'bank_list' => $bank_list,
            ];

            // tampilkan halaman form untuk menambah data penarikan baru
            return view('penarikan/tambah', $data);
        } else if ($this->request->is('post')) {
            // PROSES TAMBAH DATA

            // Pengambilan data dari form
            $id_nasabah = $this->logged_in_user['id'];
            $bank = $this->request->getPost('bank');
            $nomor_rekening = $this->request->getPost('nomor_rekening');
            $nominal = (int) $this->request->getPost('nominal');

            // validasi data
            $this->validateData(
                [
                    'bank' => $bank,
                    'nomor_rekening' => $nomor_rekening,
                    'nominal' => $nominal,
                ],
                $this->setoran_model->getValidationRules(
                    [
                        'only' => ['bank', 'nomor_rekening', 'nominal']
                    ]
                ),
                $this->setoran_model->getValidationMessages()
            );

            // jika data tidak valid, maka tampilkan error menggunakan flashdata
            // dan redirect ke halaman form kembali
            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            $nasabah = $this->nasabah_model->find($id_nasabah);

            // Jika nasabah tidak ditemukan, maka tampilkan error 404
            if (!$nasabah || $nasabah['is_active'] == 0) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            if ($nasabah['saldo'] < $nominal) {
                // simpan pesan error ke flashdata
                $this->session->setFlashdata('error_list', ['nominal' => 'Saldo tidak cukup']);

                return redirect()->back();
            } else if ($nominal < 10000) {
                // simpan pesan error ke flashdata
                $this->session->setFlashdata('error_list', ['nominal' => 'Nominal minimal Rp 10.000']);

                return redirect()->back();
            }


            // jika data valid, maka simpan data ke database
            $this->db->transBegin();

            $this->penarikan_model->insert([
                'id_nasabah' => $id_nasabah,
                'bank' => $bank,
                'nomor_rekening' => $nomor_rekening,
                'nominal' => $nominal,
            ]);

            $this->nasabah_model->update($id_nasabah, [
                'saldo' => $nasabah['saldo'] - $nominal,
            ]);

            $penarikan_errors = $this->penarikan_model->errors();
            $nasabah_errors = $this->nasabah_model->errors();


            if ($penarikan_errors || $nasabah_errors || $this->db->transStatus() === FALSE) {
                $this->db->transRollback();

                $this->session->setFlashdata('error_list', array_merge($penarikan_errors, $nasabah_errors));

                return redirect()->back();
            } else {
                // tampilkan pesan sukses menggunakan flashdata

                // redirect ke halaman list penarikan
                $this->db->transCommit();

                // update session user saldo
                $logged_in_user = $this->session->get('user');
                $logged_in_user['saldo'] -= $nominal;

                $this->session->set('user', $logged_in_user);

                // simpan pesan sukses ke flashdata
                $this->session->setFlashdata('sukses_list', ['penarikan' => "Saldo anda sekarang " . $logged_in_user['saldo']]);

                return redirect()->to('penarikan');
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function export(string $format)
    {
        if (!$this->logged_in_user || !in_array($format, ['pdf', 'excel'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->user_role == 'nasabah') {
            $kolom = [
                'ID',
                'Bank',
                'Nomor Rekening',
                'Nominal',
                'Tanggal Penarikan',
            ];

            $db_kolom = [
                'id',
                'bank',
                'nomor_rekening',
                'nominal',
                'tanggal_penarikan',
            ];
        } else {
            $kolom = [
                'ID',
                'Nama Nasabah',
                'Bank',
                'Nomor Rekening',
                'Nominal',
                'Tanggal Penarikan',
            ];

            $db_kolom = [
                'id',
                'nasabah_nama_lengkap',
                'bank',
                'nomor_rekening',
                'nominal',
                'tanggal_penarikan',
            ];
        }

        if ($this->user_role == 'nasabah') {
            $this->penarikan_model->where('id_nasabah', $this->logged_in_user['id']);
        } else {
            $this->penarikan_model->select('penarikan.*, nasabah.nama_lengkap as nasabah_nama_lengkap');
            $this->penarikan_model->join('nasabah', 'nasabah.id = penarikan.id_nasabah', 'left');
        }
        $this->penarikan_model->orderBy('tanggal_penarikan', 'ASC');

        $penarikan_list = $this->penarikan_model->findAll();

        $data = [
            'title' => 'List Penarikan',
            'kolom' => $kolom,
            'db_kolom' => $db_kolom,
            'format' => $format,
            'data' => $penarikan_list,
        ];

        return view('layout/export', $data);
    }
}
