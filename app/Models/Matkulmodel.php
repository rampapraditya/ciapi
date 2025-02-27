<?php
namespace App\Models;

use CodeIgniter\Model;

class Matkulmodel extends Model {

    protected $table      = 'matakuliah';
    protected $primaryKey = 'idmk';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['idmk', 'keymhs', 'matakuliah'];
    protected $returnType = 'object';

    // Opsional: Gunakan timestamps jika ingin mencatat waktu pembuatan/perubahan
    protected $useTimestamps = false;
}