<?php
namespace App\Models;
use CodeIgniter\Model;

class M_Folder_Mon extends Model
{
    protected $table = 'folder_monitoring';
    protected $primaryKey = 'id_folder_mon';
    protected $allowedFields = ['nama_folder_mon', 'id_parent', 'pemilik', 'created'];

        public function getDataFolderMon($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_folder_mon','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_folder_mon','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataFolderMon($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataFolderMon($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_folder_mon");
        $builder->orderBy("id_folder_mon", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}

