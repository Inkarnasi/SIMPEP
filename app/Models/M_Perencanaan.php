<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Perencanaan extends Model
{
    protected $table = 'tbl_perencanaan';

    protected $primaryKey = 'id_perencanaan';

    protected $allowedFields = ['nama_file', 'id_folder_per', 'pemilik', 'created','link'];
 
    public function getDataPerencanaan($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_filec','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_file','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataPerencanaan($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataPerencanaan($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_perencanaan");
        $builder->orderBy("id_perencanaan", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
?>