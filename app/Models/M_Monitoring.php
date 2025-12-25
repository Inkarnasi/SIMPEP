<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Monitoring extends Model
{
    protected $table = 'tbl_monitoring_pelaporan';

    protected $primaryKey = 'id_monitoring';

    protected $allowedFields = ['nama_file', 'id_folder_mon', 'pemilik', 'created','link'];
 
    public function getDataMonitoring($where = false)
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
    
    public function saveDataMonitoring($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataMonitoring($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_monitoring");
        $builder->orderBy("id_monitoring", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
?>