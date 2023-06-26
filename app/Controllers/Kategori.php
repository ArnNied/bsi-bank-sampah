<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kategori extends BaseController
{
    public function index()
    {
        // ambil data dari database pada tabel kategori
        $this->kategori_model->orderBy('nama', 'ASC');
        $kategori_list = $this->kategori_model->findAll();

        $data = [
            'title' => 'List Kategori',
            'kategori_list' => $kategori_list,
        ];

        // tampilkan data ke view
        return view('kategori/index', $data);
    }

    public function tambah()
    {
        if (!($this->user_role == 'admin')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            // tampilkan halaman form untuk menambah data kategori baru

            $data = [
                'title' => 'Tambah Kategori Baru',
            ];

            return view('kategori/tambah', $data);
        } else if ($this->request->is('post')) {
            // ambil data dari form
            $nama = $this->request->getPost('nama');
            $deskripsi = $this->request->getPost('deskripsi');
            $taksiran = $this->request->getPost('taksiran');
            $stok = $this->request->getPost('stok');

            // validasi data
            $this->validateData(
                [
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'taksiran' => $taksiran,
                    'stok' => $stok,
                ],
                $this->kategori_model->getValidationRules(
                    ["only" => ["nama", "deskripsi", "taksiran", "stok"]]
                ),
                $this->kategori_model->getValidationMessages()
            );

            // jika data tidak valid, maka tampilkan error menggunakan flashdata
            // dan redirect ke halaman form kembali
            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }
            // jika data valid, maka simpan data ke database
            $this->kategori_model->insert([
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'taksiran' => $taksiran,
                'stok' => $stok,
            ]);

            if ($errors = $this->kategori_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata('sukses_list', ['kategori' => 'Berhasil menambah kategori baru']);

                return redirect()->to('kategori');
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function ubah(int $id)
    {
        if (!($this->user_role == 'admin')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $kategori = $this->kategori_model->find($id);

        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('get')) {
            // tampilkan halaman form untuk menambah data kategori baru

            $data = [
                'title' => 'Ubah Kategori',
                'kategori' => $kategori,
            ];

            return view('kategori/ubah', $data);
        } else if ($this->request->is('post')) {
            // ambil data dari form
            $nama = $this->request->getPost('nama');
            $deskripsi = $this->request->getPost('deskripsi');
            $taksiran = $this->request->getPost('taksiran');
            $stok = $this->request->getPost('stok');

            // validasi data
            $this->validateData(
                [
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'taksiran' => $taksiran,
                    'stok' => $stok,
                ],
                $this->kategori_model->getValidationRules(
                    ["only" => ["nama", "deskripsi", "taksiran", "stok"]]
                ),
                $this->kategori_model->getValidationMessages()
            );

            // jika data tidak valid, maka tampilkan error menggunakan flashdata
            // dan redirect ke halaman form kembali
            if ($errors = $this->validator->getErrors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            }

            // jika data valid, maka simpan data ke database
            $this->kategori_model->update($kategori['id'], [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'taksiran' => $taksiran,
                'stok' => $stok,
            ]);

            if ($errors = $this->kategori_model->errors()) {
                $this->session->setFlashdata('error_list', $errors);

                return redirect()->back();
            } else {
                $this->session->setFlashdata(
                    'sukses_list',
                    ['kategori' => join(' ', ['Kategori', $kategori['nama'], 'berhasil diubah'])]
                );

                return redirect()->to('kategori');
            }
        } else {
            // jika bukan get atau post, maka tampilkan error 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function hapus(int $id)
    {
        if ($this->user_role != 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // ambil data dari database pada table kategori berdasarkan id
        $kategori = $this->kategori_model->find($id);

        // jika data tidak ditemukan, maka tampilkan error 404
        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // jika data ditemukan, maka hapus data dari database
        $this->kategori_model->delete($id);

        if ($errors = $this->kategori_model->errors()) {
            $this->session->setFlashdata('error_list', $errors);

            return redirect()->back();
        } else {
            // tampilkan pesan sukses menggunakan flashdata
            $this->session->setFlashdata(
                'sukses_list',
                ['kategori' => join(' ', ['Kategori', $kategori['nama'], 'berhasil dihapus'])]
            );

            // redirect ke halaman list
            return redirect()->to('kategori');
        }
    }
}
