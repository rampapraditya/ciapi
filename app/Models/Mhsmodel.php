<?php
namespace App\Models;

use CodeIgniter\Model;

class Mhsmodel extends Model {

    protected $table      = 'mahasiswa';
    protected $primaryKey = 'keymhs';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama', 'nim', 'email', 'jurusan'];
    protected $returnType = 'object';

    // Opsional: Gunakan timestamps jika ingin mencatat waktu pembuatan/perubahan
    protected $useTimestamps = false;

    public function getMahasiswa_Matakuliah()
    {
        return $this->db->table('mahasiswa')
            ->select('mahasiswa.nim, mahasiswa.nama, GROUP_CONCAT(matakuliah.matakuliah) as matakuliah')
            ->join('matakuliah', 'matakuliah.keymhs = mahasiswa.keymhs', 'inner')
            ->groupBy('mahasiswa.nim')
            ->get()
            ->getResult();
    }
}