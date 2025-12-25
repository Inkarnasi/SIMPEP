<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Mekanisme extends Model
{
    protected $table = 'tbl_mekanisme';

    protected $primaryKey = 'id_mekanisme';

    protected $allowedFields = ['nama_file', 'id_folder_mek', 'pemilik', 'created','link'];
 
    public function getDataMekanisme($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_file','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_file','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataMekanisme($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataMekanisme($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_mekanisme");
        $builder->orderBy("id_mekanisme", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
?>