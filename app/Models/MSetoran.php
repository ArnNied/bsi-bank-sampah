<?php

namespace App\Models;

use CodeIgniter\Model;

class MSetoran extends Model
{
    protected $table            = 'setoran';
    protected $allowedFields    = [
        'id_nasabah',
        'id_teller',
        'kategori_sampah',
        'taksiran',
        'berat',
        'nominal',
        'tanggal_setor',
    ];

    // Validation
    protected $validationRules      = [
        'id_nasabah'        => 'required|is_natural_no_zero|greater_than[0]|is_not_unique[nasabah.id]',
        'id_teller'         => 'required|is_natural_no_zero|greater_than[0]|is_not_unique[teller.id]',
        'kategori_sampah'   => 'required|min_length[1]|max_length[255]',
        'taksiran'          => 'required|is_natural_no_zero|greater_than[0]',
        'berat'             => 'required|greater_than[0]',
        'nominal'           => 'required|greater_than[0]',
    ];
    protected $validationMessages   = [
        'id_nasabah'        => [
            'required'              => 'Nasabah wajib diisi',
            'is_natural_no_zero'    => 'Nasabah harus berupa angka bulat diatas 0',
            'greater_than'          => 'Nasabah harus lebih dari 0',
            'is_not_unique'         => 'Nasabah tidak ditemukan',
        ],
        'id_teller'         => [
            'required'              => 'Teller wajib diisi',
            'is_natural_no_zero'    => 'Teller harus berupa angka bulat diatas 0',
            'greater_than'          => 'Teller harus lebih dari 0',
            'is_not_unique'         => 'Teller tidak ditemukan',
        ],
        'kategori_sampah'   => [
            'required'              => 'Kategori sampah wajib diisi',
            'min_length'            => 'Kategori sampah minimal 1 karakter',
            'max_length'            => 'Kategori sampah maksimal 255 karakter',
        ],
        'taksiran'          => [
            'required'              => 'Taksiran wajib diisi',
            'is_natural_no_zero'    => 'Taksiran harus berupa angka',
            'greater_than'          => 'Taksiran minimal 0',
        ],
        'berat'             => [
            'required'              => 'Berat wajib diisi',
            'greater_than'          => 'Berat minimal 0',
        ],
        'nominal'           => [
            'required'              => 'Nominal wajib diisi',
            'greater_than'          => 'Nominal minimal 0',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = ['cb_insert_tanggal_setor', 'cb_bulat_kebawah_nominal'];
    protected $beforeUpdate   = ['cb_bulat_kebawah_nominal'];

    public function cb_insert_tanggal_setor(array $data)
    {
        $data['data']['tanggal_setor'] = date('Y-m-d H:i:s');

        return $data;
    }

    public function cb_bulat_kebawah_nominal(array $data)
    {
        if (isset($data['data']['nominal'])) {
            $data['data']['nominal'] = floor($data['data']['nominal']);
        }

        return $data;
    }
}
