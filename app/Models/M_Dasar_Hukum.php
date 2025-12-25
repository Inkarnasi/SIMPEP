<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Dasar_Hukum extends Model
{
    protected $table = 'tbl_dasar_hukum';

    protected $primaryKey = 'id_hukum';

    protected $allowedFields = ['nama_hukum', 'pemilik', 'created','link'];
    public function getDatahukum($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_hukum','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_hukum','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDatahukum($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDatahukum($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_hukum");
        $builder->orderBy("id_hukum", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
?>