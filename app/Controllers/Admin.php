<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\PeminjamModel;
use App\Models\PinjamModel;

class Admin extends BaseController
{

    public function index()
    {
        $brgModel = new BarangModel();
        $pmjModel = new PeminjamModel();
        $pinjamModel = new PinjamModel();
        $data = [
            'brg' => $brgModel->countAll(),
            'akun' => $pmjModel->countAll(),
            'peminjaman' => $pinjamModel->countAll(),
            'pengembalian' => $pinjamModel->pengembalianShowAll(),
            'judul' => "Dashboard",
        ];

        return view('admin/dashboard', $data);
    }

    //Data Barang//

    public function barang()
    {
        $a = new BarangModel();
        $data = [
            // 'dataBrg' => $a->findAll(),
            'dataBrg' => $a->paginate(5, 'brg_pages'),
            'pager' => $a->pager,
            'judul' => "Data Barang",

        ];
        return view('admin/barang', $data);
    }

    public function brg_tambah()
    {
        session();
        $data = ['verror_msg' => \Config\Services::validation()];
        return view('admin/barang/brg_tambah', $data);
    }

    public function brg_simpan()
    {
        $aturan = $this->validate([
            'kode_barang' => [
                'label'    => 'Kode Barang',
                'rules'    => 'required|is_unique[barang.kode_barang]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah dimasukan'
                ]
            ],
            'nama_barang' => [
                'label'    => 'Nama barang',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$aturan) {
            return redirect()->to('/admin/brg_tambah')->withInput();
        }
        $a = new BarangModel();
        $a->insert([
            'kode_barang' => $this->request->getVar('kode_barang'),
            'nama_barang' => $this->request->getVar('nama_barang'),
            'merk' => $this->request->getVar('merk'),
            'jenis' => $this->request->getVar('jenis'),
            'unit' => $this->request->getVar('unit')
        ]);

        return redirect()->to('../admin/barang');
    }

    public function brg_hapus($id)
    {
        $a = new BarangModel();
        $a->delete($id);
        return redirect()->to('../admin/barang');
    }

    public function brg_edit($id)
    {
        session();
        $data = ['verror_msg' => \Config\Services::validation()];
        $a = new BarangModel();
        $data['brg'][] = $a->find($id);
        return view('admin/barang/brg_edit', $data);
    }

    public function brg_proses_edit($id)
    {

        $aturan = $this->validate([
            'kode_barang' => [
                'label' => 'Kode Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$aturan) {
            return redirect()->to('/admin/brg_edit/' . $id)->withInput();
        }

        $a = new BarangModel();
        $a->update($id, [
            'nama_barang' => $this->request->getVar('nama_barang'),
            'merk' => $this->request->getVar('merk'),
            'jenis' => $this->request->getVar('jenis'),
            'unit' => $this->request->getVar('unit')
        ]);

        return redirect()->to('../admin/barang');
    }

    //////////////////////////////////

    //Data Peminjam//

    public function peminjam()
    {
        $a = new PeminjamModel();
        $data = [
            'dataPeminjam' => $a->findAll(),
            'judul' => "Data Peminjam"
        ];
        return view('admin/peminjam', $data);
    }

    public function pmj_tambah()
    {
        session();
        $data = ['verror_msg' => \Config\Services::validation()];
        return view('admin/peminjam/peminjam_tambah', $data);
    }

    public function pmj_simpan()
    {
        $aturan = $this->validate([
            'name' => [
                'label'    => 'Nama Peminjam',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'email' => [
                'label'    => 'Email',
                'rules'    => 'required|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah dimasukan',
                ]
            ],
            'username' => [
                'label'    => 'Username',
                'rules'    => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah dimasukan',
                ]
            ],
            'password' => [
                'label'    => 'password',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$aturan) {
            return redirect()->to('/admin/pmj_tambah')->withInput();
        }

        $a = new PeminjamModel();
        $password = $this->request->getVar('password');
        $a->insert([
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'password_hash' =>  password_hash(
                base64_encode(
                    hash('sha384', $password, true)
                ),
                PASSWORD_DEFAULT
            )

        ]);

        return redirect()->to('../admin/peminjam');
    }

    public function pmj_hapus($id)
    {
        $a = new PeminjamModel();
        $a->delete($id);
        return redirect()->to('../admin/peminjam');
    }

    public function pmj_edit($id)
    {
        session();
        $data = ['verror_msg' => \Config\Services::validation()];
        $a = new PeminjamModel();
        $data['peminjam'][] = $a->find($id);
        return view('admin/peminjam/peminjam_edit', $data);
    }

    public function pmj_proses_edit($id)
    {
        $aturan = $this->validate([
            'name' => [
                'label'    => 'Nama Peminjam',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'email' => [
                'label'    => 'Email',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'username' => [
                'label'    => 'Username',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'password' => [
                'label'    => 'password',
                'rules'    => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);

        if (!$aturan) {
            return redirect()->to('/admin/pmj_edit/' . $id)->withInput();
        }

        $a = new PeminjamModel();
        $password = $this->request->getVar('password');
        $a->update($id, [
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
            'username' => $this->request->getVar('username'),
            'password_hash' =>  password_hash(
                base64_encode(
                    hash('sha384', $password, true)
                ),
                PASSWORD_DEFAULT
            )

        ]);

        return redirect()->to('../admin/peminjam');
    }

    //////////////////////////////////

    //Data peminjaman//

    public function pinjam()
    {
        $a = new PinjamModel();
        $data = [
            'dataTransaksi' => $a->showAll(),
            // 'dataTransaksi' => $a->peminjaman(),
            'dataPmj' => $a->peminjaman(),
            'judul' => "Data peminjaman"
        ];
        return view('admin/pinjam', $data);
    }

    public function pinjam_tambah()
    {
        session();
        $brg = new BarangModel();
        $data = [
            'verror_msg' => \Config\Services::validation(),
            'dataBrg' => $brg->findAll()
        ];
        return view('admin/pinjam/pinjam_tambah', $data);
    }

    public function pinjam_ok($id)
    {
        $pinjam = new PinjamModel();
        $barang = new BarangModel();

        $kode_barang = $this->request->getVar('kode_barang');
        $checkBrg = $barang->where('kode_barang', $kode_barang)
            ->findAll();
        $stock = $checkBrg[0]['unit'];

        $pinjam->update($id, [
            'status' => '1',
            'approved' => '1',
            'tgl_approved' => date('Y-m-d'),
        ]);

        // $barang->update($kode_barang, [
        //     'unit' => $stock - 1
        // ]);

        return redirect()->to('../admin/pinjam');
    }

    public function pinjam_tolak($id)
    {
        $pinjam = new PinjamModel();
        $barang = new BarangModel();

        $jml = $this->request->getVar('jml');
        $id_pinjam = $this->request->getVar('id_pinjam');
        $kode_barang = $this->request->getVar('kode_barang');

        $checkJml = $pinjam->where('id_peminjaman', $id_pinjam)
            ->findAll();
        $jml = $checkJml[0]['jumlah'];

        $checkBrg = $barang->where('kode_barang', $kode_barang)
            ->findAll();
        $unit = $checkBrg[0]['unit'];

        // dd($checkJml);

        $barang->update($kode_barang, [
            'unit' => $unit + $jml
        ]);

        $pinjam->update($id, [
            'status' => '3',
            'approved' => '0',
            'tgl_approved' => date('Y-m-d'),
        ]);

        return redirect()->to('../admin/pinjam');
    }
}