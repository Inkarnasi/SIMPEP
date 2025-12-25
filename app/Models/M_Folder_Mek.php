<?php
namespace App\Models;
use CodeIgniter\Model;

class M_Folder_Mek extends Model
{
    protected $table = 'folder_mekanisme';
    protected $primaryKey = 'id_folder_mek';
    protected $allowedFields = ['nama_folder_mek', 'id_parent', 'pemilik', 'created'];

        public function getDataFolderMek($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_folder_mek','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_folder_mek','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataFolderMek($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataFolderMek($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_folder_mek");
        $builder->orderBy("id_folder_mek", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}

