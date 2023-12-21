<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
    public function index()
    {
        if ($this->user_role == 'admin') {
            return $this->dashboard_admin();
        } else if ($this->user_role == 'teller') {
            return $this->dashboard_teller();
        } else if ($this->user_role == 'nasabah') {
            return $this->dashboard_nasabah();
        } else {
            return $this->dashboard_umum();
        }
    }

    public function dashboard_umum()
    {
        // Tampilan dashboard umum
        $this->kategori_model->orderBy('terakhir_diperbarui', 'DESC');
        $kategori_list = $this->kategori_model->findAll();

        $data = [
            'title' => 'Dashboard Umum',
            'kategori_list' => $kategori_list,
        ];

        return view('dashboard/umum', $data);
    }

    public function dashboard_nasabah()
    {
        // Tampilan dashboard nasabah

        // Ambil data setoran yang dilakukan oleh nasabah tersebut
        $this->setoran_model->select('setoran.*, teller.nama_lengkap as teller_nama_lengkap');
        $this->setoran_model->join('teller', 'teller.id = setoran.id_teller');
        $this->setoran_model->orderBy('tanggal_setor', 'DESC');
        $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        $setoran_list = $this->setoran_model->findAll(5);

        // Ambil data penarikan yang dilakukan oleh nasabah tersebut
        $this->penarikan_model->select('penarikan.*');
        $this->penarikan_model->orderBy('tanggal_penarikan', 'DESC');
        $this->penarikan_model->where('id_nasabah', $this->logged_in_user['id']);
        $penarikan_list = $this->penarikan_model->findAll(5);

        $this->kategori_model->orderBy('terakhir_diperbarui', 'DESC');
        $kategori_list = $this->kategori_model->findAll(10);

        // Membuat statistik pendapatan, setoran, dan berat sampah yang disetor
        $statistik = [];

        $satu_bulan_yang_lalu = Time::now()->subMonths(1);

        $statistik['saldo'] = $this->logged_in_user['saldo'];

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        $statistik['pendapatan'] = $this->setoran_model->selectSum('nominal')->first()['nominal'] ?? 0;

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        $statistik['setoran'] = $this->setoran_model->countAllResults();

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $this->setoran_model->where('id_nasabah', $this->logged_in_user['id']);
        $statistik['berat'] = number_format($this->setoran_model->selectSum('berat')->first()['berat'] ?? 0, 2);

        $data = [
            'title' => 'Dashboard Nasabah',
            'statistik' => $statistik,
            'setoran_list' => $setoran_list,
            'penarikan_list' => $penarikan_list,
            'kategori_list' => $kategori_list,
        ];

        return view('dashboard/nasabah', $data);
    }

    public function dashboard_teller()
    {
        // Tampilan dashboard teller

        // Ambil data nasabah yang terdaftar, urutkan berdasarkan tanggal daftar
        $this->nasabah_model->orderBy('tanggal_daftar', 'DESC');
        $nasabah_list = $this->nasabah_model->findAll(5);

        // Ambil data setoran yang dilakukan oleh teller tersebut
        $this->setoran_model->select('setoran.*, nasabah.nama_lengkap as nasabah_nama_lengkap');
        $this->setoran_model->join('nasabah', 'nasabah.id = setoran.id_nasabah');
        $this->setoran_model->orderBy('tanggal_setor', 'DESC');
        $this->setoran_model->where('id_teller', $this->logged_in_user['id']);
        $setoran_list = $this->setoran_model->findAll(5);

        // Ambil data penarikan
        $this->penarikan_model->select('penarikan.*, nasabah.nama_lengkap as nasabah_nama_lengkap');
        $this->penarikan_model->join('nasabah', 'nasabah.id = penarikan.id_nasabah');
        $this->penarikan_model->orderBy('tanggal_penarikan', 'DESC');
        $penarikan_list = $this->penarikan_model->findAll(5);

        $this->kategori_model->orderBy('terakhir_diperbarui', 'DESC');
        $kategori_list = $this->kategori_model->findAll(10);

        $statistik = [];

        $satu_bulan_yang_lalu = Time::now()->subMonths(1);

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $this->setoran_model->where('id_teller', $this->logged_in_user['id']);
        $statistik['setoran'] = $this->setoran_model->countAllResults();

        $data = [
            'title' => 'Dashboard Teller',
            'statistik' => $statistik,
            'kategori_list' => $kategori_list,
            'nasabah_list' => $nasabah_list,
            'setoran_list' => $setoran_list,
            'penarikan_list' => $penarikan_list,
        ];

        return view('dashboard/teller', $data);
    }

    public function dashboard_admin()
    {
        $this->nasabah_model->orderBy('tanggal_daftar', 'DESC');
        $nasabah_list = $this->nasabah_model->findAll(5);

        $this->teller_model->orderBy('tanggal_daftar', 'DESC');
        $teller_list = $this->teller_model->findAll(5);

        $this->setoran_model->select('setoran.*, teller.nama_lengkap as teller_nama_lengkap, nasabah.nama_lengkap as nasabah_nama_lengkap');
        $this->setoran_model->join('teller', 'teller.id = setoran.id_teller');
        $this->setoran_model->join('nasabah', 'nasabah.id = setoran.id_nasabah');
        $this->setoran_model->orderBy('tanggal_setor', 'DESC');
        $setoran_list = $this->setoran_model->findAll(5);

        $this->penarikan_model->select('penarikan.*, nasabah.nama_lengkap as nasabah_nama_lengkap');
        $this->penarikan_model->join('nasabah', 'nasabah.id = penarikan.id_nasabah');
        $this->penarikan_model->orderBy('tanggal_penarikan', 'DESC');
        $penarikan_list = $this->penarikan_model->findAll(5);

        $kategori_list = $this->kategori_model->findAll(10);

        $statistik = [];

        $satu_bulan_yang_lalu = Time::now()->subMonths(1);

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $statistik['setoran'] = $this->setoran_model->countAllResults();

        $this->penarikan_model->where('tanggal_penarikan >=', $satu_bulan_yang_lalu);
        $statistik['penarikan'] = $this->penarikan_model->countAllResults();

        $this->nasabah_model->where('tanggal_daftar >=', $satu_bulan_yang_lalu);
        $statistik['nasabah_baru'] = $this->nasabah_model->countAllResults();

        $this->setoran_model->where('tanggal_setor >=', $satu_bulan_yang_lalu);
        $statistik['berat'] = number_format($this->setoran_model->selectSum('berat')->first()['berat'] ?? 0, 2);

        $data = [
            'title' => 'Dashboard Admin',
            'statistik' => $statistik,
            'nasabah_list' => $nasabah_list,
            'teller_list' => $teller_list,
            'setoran_list' => $setoran_list,
            'penarikan_list' => $penarikan_list,
            'kategori_list' => $kategori_list,
        ];

        return view('dashboard/admin', $data);
    }
}
