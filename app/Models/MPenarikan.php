<?php

namespace App\Models;

use CodeIgniter\Model;

class MPenarikan extends Model
{
    protected $table            = 'penarikan';
    protected $allowedFields    = [
        'id_nasabah',
        'bank',
        'nomor_rekening',
        'nominal',
        'tanggal_pengajuan',
        'tanggal_diproses',
        'status'
    ];

    // Validation
    protected $validationRules      = [
        'id_nasabah'        => 'required|is_natural_no_zero|greater_than[0]|is_not_unique[nasabah.id]',
        'bank'              => 'required|in_list[BRI,BCA,Mandiri,BNI,BTN,CIMB Niaga]',
        'nomor_rekening'    => 'required|numeric|min_length[10]|max_length[20]',
        'nominal'           => 'required|is_natural_no_zero|greater_than[0]',
        'status'            => 'required|in_list[pending,diterima,ditolak]'
    ];
    protected $validationMessages   = [
        'id_nasabah'        => [
            'required'              => 'Nasabah wajib diisi',
            'is_natural_no_zero'    => 'Nasabah harus berupa angka bulat diatas 0',
            'numeric'               => 'Nasabah harus berupa angka',
            'greater_than'          => 'Nasabah harus lebih dari 0',
            'is_not_unique'         => 'Nasabah tidak ditemukan',
        ],
        'bank'              => [
            'required'              => 'Bank wajib diisi',
            'in_list'               => 'Bank tidak valid',
        ],
        'nomor_rekening'    => [
            'required'              => 'Nomor rekening wajib diisi',
            'numeric'               => 'Nomor rekening harus berupa angka',
            'min_length'            => 'Nomor rekening minimal 10 karakter',
            'max_length'            => 'Nomor rekening maksimal 25 karakter',
        ],
        'nominal'           => [
            'required'              => 'Nominal wajib diisi',
            'is_natural_no_zero'    => 'Nominal harus berupa angka bulat diatas 0',
            'greater_than'          => 'Nominal minimal 0',
        ],
        'status'            => [
            'required'              => 'Status wajib diisi',
            'in_list'               => 'Status tidak valid',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = ['cb_insert_tanggal_pengajuan'];

    public function cb_insert_tanggal_pengajuan(array $data)
    {
        $data['data']['tanggal_pengajuan'] = date('Y-m-d H:i:s');

        return $data;
    }
}
