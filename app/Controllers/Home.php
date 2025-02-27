<?php

namespace App\Controllers;

use App\Models\Mhsmodel;
use App\Models\Matkulmodel;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Home extends ResourceController
{
    use ResponseTrait;

    protected $model;
    protected $modelMatkul;
    
    public function __construct() {
        $this->model = new Mhsmodel();
        $this->modelMatkul = new Matkulmodel();
    }

    public function index(){
        ini_set('memory_limit', '512M');

        $queryStart = hrtime(true);
        $list = $this->model->findAll();
        $queryEnd = hrtime(true);
        
        $queryTime = ($queryEnd - $queryStart) / 1e9; //koversi ke detik

        $output['query_time'] = $queryTime;
        $output['data'] = $list;
        return $this->respond($output, 200);
    }

    public function simpansingle()
    {
        $start_time = hrtime(true); // Waktu mulai

        $json_data = $this->request->getJSON(true);

        if (!is_array($json_data) || count($json_data) === 0) {
            return $this->respond(["error" => "Data harus berupa array JSON dengan minimal 1 data"], 400);
        }

        foreach ($json_data as $m) {
            $this->model->insert([
                'nim' => $m['nim'],
                'nama' => $m['nama'],
                'jurusan' => $m['jurusan'],
                'email' => $m['email']
            ]);
        }

        $end_time = hrtime(true); // Waktu selesai
        $query_time = ($end_time - $start_time) / 1e9; // Konversi ke detik

        return $this->respond([
            "message" => "Data berhasil disimpan satu per satu",
            "query_time" => $query_time,
            "total_inserted" => count($json_data)
        ]);
    }

    public function simpankolektif()
    {
        $start_time = hrtime(true); // Waktu mulai

        $json_data = $this->request->getJSON(true); // Ambil data JSON
        
        if (!is_array($json_data) || count($json_data) === 0) {
            return $this->respond(["error" => "Data harus berupa array JSON dengan minimal 1 data"], 400);
        }

        $this->model->insertBatch($json_data);
        
        $end_time = hrtime(true); // Waktu selesai
        $query_time = ($end_time - $start_time) / 1e9; // Konversi ke detik

        return $this->respond([
            "message" => "Data berhasil disimpan",
            "query_time" => $query_time,
            "total_inserted" => count($json_data)
        ]);
    }

    public function getmhsmatkulv1()
    {
        ini_set('memory_limit', '512M');
        
        $queryStart = hrtime(true);
        $mahasiswaList = $this->model->findAll();
        foreach ($mahasiswaList as $mhs) {
            $mhs->matakuliah = $this->modelMatkul->where('keymhs', $mhs->keymhs)->findAll();
        }
        $queryEnd = hrtime(true);
        
         //koversi ke detik
        $queryTime = ($queryEnd - $queryStart) / 1e9;

        $output['query_time'] = $queryTime;
        $output['data'] = $mahasiswaList;
        return $this->respond($output, 200);
    }

    public function getmhsmatkulv2()
    {
        ini_set('memory_limit', '512M');
        
        $queryStart = hrtime(true);
        $list = $this->model->getMahasiswa_Matakuliah();

        foreach ($list as $mhs) {
            $mhs->matakuliah = explode(',', $mhs->matakuliah);
        }
        $queryEnd = hrtime(true);
        
         //koversi ke detik
        $queryTime = ($queryEnd - $queryStart) / 1e9;

        $output['query_time'] = $queryTime;
        $output['data'] = $list;
        return $this->respond($output, 200);
    }
}
