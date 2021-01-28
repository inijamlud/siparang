<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table    = 'barang';
    protected $primaryKey = 'kode_barang';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields  = ['kode_barang', 'nama_barang', 'merk', 'jenis', 'kondisi', 'unit'];
    protected $useTimestamps  = true;

    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    public function checkStock($id)
    {
        return $this->db->table('barang')
            ->selectSum('unit')
            ->where('kode_barang', $id)
            ->get()->getRow()->unit;
    }

    
}
