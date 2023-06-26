<?php

namespace App\Models;

use CodeIgniter\Model;

class MKategori extends Model
{
    protected $table            = 'kategori';
    protected $allowedFields    = [
        'nama',
        'deskripsi',
        'taksiran',
        'stok',
        'terakhir_diperbarui'
    ];

    protected $validationRules      = [
        'nama'          => 'required|min_length[1]|max_length[255]',
        'deskripsi'     => 'permit_empty|max_length[2000]',
        'taksiran'      => 'required|numeric|greater_than_equal_to[0]',
        'stok'          => 'required|numeric|greater_than_equal_to[0]',
    ];
    protected $validationMessages   = [
        'nama'          => [
            'required'      => 'Nama kategori wajib diisi',
            'min_length'    => 'Nama kategori minimal 1 karakter',
            'max_length'    => 'Nama kategori maksimal 255 karakter',
        ],
        'deskripsi'     => [
            'max_length'    => 'Deskripsi maksimal 2000 karakter',
        ],
        'taksiran'      => [
            'required'              => 'Taksiran wajib diisi',
            'numeric'               => 'Taksiran harus berupa angka',
            'greater_than_equal_to' => 'Taksiran minimal 0',
        ],
        'stok'          => [
            'required'              => 'Stok wajib diisi',
            'numeric'               => 'Stok harus berupa angka',
            'greater_than_equal_to' => 'Stok minimal 0',
        ],
    ];

    // Callbacks
    protected $beforeInsert = ['cb_insert_terakhir_diperbarui'];
    protected $beforeUpdate = ['cb_insert_terakhir_diperbarui_update'];

    public function cb_insert_terakhir_diperbarui(array $data)
    {
        $data['data']['terakhir_diperbarui'] = date('Y-m-d H:i:s');

        return $data;
    }

    // hanya update terakhir_diperbarui jika taksiran berubah
    public function cb_insert_terakhir_diperbarui_update(array $data)
    {
        if (isset($data['data']['taksiran'])) {
            $data['data']['terakhir_diperbarui'] = date('Y-m-d H:i:s');
        }

        return $data;
    }
}
