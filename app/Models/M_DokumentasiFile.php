<?php

namespace App\Models;

use CodeIgniter\Model;

class M_DokumentasiFile extends Model
{
    protected $table = 'tbl_dokumentasi_file';
    protected $primaryKey = 'id_file';
    protected $allowedFields = ['id_kegiatan', 'file_url', 'ekstensi', 'created'];
    protected $useAutoIncrement = false;

        public function getDataDokumentasiFile($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('created','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('created','DESC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataDokumentasiFile($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataDokumentasiFile($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_kegiatan");
        $builder->orderBy("id_kegiatan", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
