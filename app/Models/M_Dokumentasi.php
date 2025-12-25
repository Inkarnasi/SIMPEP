<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Dokumentasi extends Model
{
    protected $table = 'tbl_dokumentasi';
    protected $primaryKey = 'id_kegiatan';
    protected $allowedFields = ['id_kegiatan', 'nama_kegiatan', 'keterangan','ekstensi', 'tanggal_kegiatan', 'thumbnail', 'created'];

 
    public function getDataDokumentasi($where = false)
    {   
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('nama_kegiatan','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('nama_kegiatan','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataDokumentasi($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataDokumentasi($data, $where)
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
?>