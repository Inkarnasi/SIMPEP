<?php
namespace App\Models;
use CodeIgniter\Model;

class M_Folder_Per extends Model
{
    protected $table = 'folder_perencanaan';
    protected $primaryKey = 'id_folder_per';
    protected $allowedFields = ['nama_folder_per', 'id_parent', 'pemilik', 'created'];

        public function getDataFolderPer($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_folder_per','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_folder_per','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataFolderPer($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }


    public function updateDataFolderPer($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber()
{
    return $this->db->table('folder_perencanaan')
        ->select('id_folder_per')
        ->orderBy('id_folder_per', 'DESC')
        ->limit(1)
        ->get();
}
}

