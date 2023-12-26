<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Initial extends Migration
{
    public function up()
    {
        // Table Admin
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'terakhir_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admin');

        // Table Teller
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nomor_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_daftar' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'terakhir_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('teller');

        // Table Nasabah
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nomor_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'saldo' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal_daftar' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'terakhir_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('nasabah');

        // Table Kategori
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'taksiran' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'stok' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'terakhir_diperbarui' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori');

        // Table Setoran
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_nasabah' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_teller' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'kategori_sampah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'taksiran' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'berat' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'nominal' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal_setor' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_nasabah', 'nasabah', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('id_teller', 'teller', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('setoran');

        // Table Penarikan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_nasabah' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'bank' => [
                'type' => 'ENUM',
                'constraint' => ['BRI', 'BCA', 'Mandiri', 'BNI', 'BTN', 'CIMB Niaga'],
            ],
            'nomor_rekening' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nominal' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_diproses' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'diterima', 'ditolak'],
                'default' => 'pending',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_nasabah', 'nasabah', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('penarikan');
    }

    public function down()
    {
        //
    }
}
