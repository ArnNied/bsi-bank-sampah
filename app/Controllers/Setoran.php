<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Setoran extends BaseController
{
    public function index()
    {
        if (!$this->user_role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // tampilan halaman list setoran
        // jika role admin, maka tampilkan semua data setoran
        // jika role teller atau user, maka tampilkan data setoran yang memiliki id teller atau user tersebut

        $this->setoran_model->select('setoran.*, teller.nama_lengkap as teller_nama_lengkap, nasabah.nama_lengkap as nasabah_nama_lengkap');

        $this->setoran_model->join('teller', 'teller.id = setoran.id_teller', 'left');
        $this->setoran_model->join('nasabah', 'nasabah.id = setoran.id_nasabah', 'left');

        $this->setoran_model->orderBy('tanggal_setor', 'DESC');

        if ($this->user_role == 'nasabah') {
            $setoran_list = $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        } else if ($this->user_role == 'teller') {
            $setoran_list = $this->setoran_model->where('id_teller', $this->logged_in_user['id']);
        }

        $setoran_list = $this->setoran_model->findAll();

        $data = [
            'title' => 'List Setoran',
            'setoran_list' => $setoran_list,
        ];

        return view('setoran/index', $data);
    }

    public function tambah()
    {
        if (!in_array($this->user_role, ['teller', 'admin'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            $this->nasabah_model->orderBy('nama_lengkap', 'ASC');
            $nasabah_list = $this->nasabah_model->where('is_active', 1)->findAll();

            $this->teller_model->orderBy('nama_lengkap', 'ASC');
            $teller_list = $this->teller_model->where('is_active', 1)->findAll();

            $this->kategori_model->orderBy('nama', 'ASC');
            $kategori_sampah_list = $this->kategori_model->findAll();

            $data = [
                'title' => 'Tambah Setoran Baru',
                'nasabah_list' => $nasabah_list,
                'teller_list' => $teller_list,
                'kategori_sampah_list' => $kategori_sampah_list,
            ];

            // tampilkan halaman form untuk menambah data setoran baru
            return view('setoran/tambah', $data);
        } else if ($this->request->is('post')) {
            // Pengambilan data dari form
            $id_nasabah = $this->request->getPost('id_nasabah');
            $id_teller = $this->request->getPost('id_teller');
            $id_kategori_sampah = $this->request->getPost('id_kategori_sampah');
            $berat = $this->request->getPost('berat');

            $this->validateData(
                [
                    'id_nasabah' => $id_nasabah,
                    'id_teller' => $id_teller,
                    'berat' => $berat,
                ],
                $this->setoran_model->getValidationRules(
                    [
                        'only' => ['id_nasabah', 'id_teller', 'berat']
                    ]
                ),
                $this->setoran_model->getValidationMessages()
            );

            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            // Telah terjadi manipulasi form
            if ($this->user_role == 'teller' && $id_teller != $this->logged_in_user['id']) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $nasabah = $this->nasabah_model->find($id_nasabah);

            // Jika nasabah tidak ditemukan, maka tampilkan error 404
            if (!$nasabah || $nasabah['is_active'] == 0) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $teller = $this->teller_model->find($id_teller);

            // Jika teller tidak ditemukan, maka tampilkan error 404
            if (!$teller || $teller['is_active'] == 0) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            // Pengambilan data kategori sampah
            $kategori_sampah = $this->kategori_model->find($id_kategori_sampah);

            if (!$kategori_sampah) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            // Penghitungan nominal
            $nominal = floor($berat * $kategori_sampah['taksiran']);

            $this->db->transBegin();

            $this->setoran_model->insert([
                'id_nasabah' => $id_nasabah,
                'id_teller' => $id_teller,
                'kategori_sampah' => $kategori_sampah['nama'],
                'taksiran' => $kategori_sampah['taksiran'],
                'berat' => $berat,
                'nominal' => $nominal,
            ]);

            $this->kategori_model->update($id_kategori_sampah, [
                'stok' => $kategori_sampah['stok'] + $berat,
            ]);

            $this->nasabah_model->update($id_nasabah, [
                'saldo' => $nasabah['saldo'] + $nominal,
            ]);

            $penarikan_errors = $this->setoran_model->errors();
            $kategori_errors = $this->kategori_model->errors();
            $nasabah_errors = $this->nasabah_model->errors();

            if ($penarikan_errors || $kategori_errors || $nasabah_errors || $this->db->transStatus() === FALSE) {
                $this->db->transRollback();

                $this->session->setFlashdata('error_list', array_merge($penarikan_errors, $kategori_errors, $nasabah_errors));

                return redirect()->back();
            } else {
                $this->db->transCommit();

                $this->session->setFlashdata('sukses_list', ['pesan' => 'Setoran berhasil ditambahkan']);

                return redirect()->to('setoran');
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
                'Teller',
                'Kategori Sampah',
                'Berat',
                'Taksiran (kg)',
                'Total',
                'Tanggal Setor',
            ];

            $db_kolom = [
                'id',
                'teller_nama_lengkap',
                'kategori_sampah',
                'berat',
                'taksiran',
                'nominal',
                'tanggal_setor',
            ];
        } else {
            $kolom = [
                'ID',
                'Nasabah',
                'Teller',
                'Kategori Sampah',
                'Berat',
                'Taksiran (kg)',
                'Total',
                'Tanggal Setor',
            ];

            $db_kolom = [
                'id',
                'nasabah_nama_lengkap',
                'teller_nama_lengkap',
                'kategori_sampah',
                'berat',
                'taksiran',
                'nominal',
                'tanggal_setor',
            ];
        }

        if ($this->user_role == 'nasabah') {
            $this->setoran_model->select('setoran.*, teller.nama_lengkap as teller_nama_lengkap');
            $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        } else {
            $this->setoran_model->select('setoran.*, teller.nama_lengkap as teller_nama_lengkap, nasabah.nama_lengkap as nasabah_nama_lengkap');
            $this->setoran_model->join('nasabah', 'nasabah.id = setoran.id_nasabah', 'left');
        }

        $this->setoran_model->join('teller', 'teller.id = setoran.id_teller', 'left');
        $this->setoran_model->orderBy('tanggal_setor', 'ASC');

        $setoran_list = $this->setoran_model->findAll();

        $data = [
            'title' => 'List Setoran',
            'kolom' => $kolom,
            'db_kolom' => $db_kolom,
            'format' => $format,
            'data' => $setoran_list,
        ];

        return view('layout/export', $data);
    }
}
