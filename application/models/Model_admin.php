<?php
class Model_admin extends CI_Model {

    public function get_id_barang_uniq()
    {
            for(;;){
                $id_barang=random_string('alnum', 8);
                $this->db->where("id_barang",$id_barang);
                $query=$this->db->get("barang");
                if($query->num_rows()==0){
                    break;     
                }
            }  
            return $id_barang;
    }
    
    public function get_stok($id_member=NULL){
        if($id_member!=NULL){$this->db->where("id_member",$id_member);}
        $query=$this->db->get("barang");
        return $query;
    }
    public function get_ta_aktiv(){
        $this->db->where("status","Aktif");
        $data=$this->db->get("tahunajaran");
        $data=$data->row();
        if(isset($data)){
            return $data;
        }else{
            return false;
        }   
    }
    public function get_penawaran($id=NULL){
        if($id!=NULL){$this->db->where("id",$id);}
        $query=$this->db->get("penawaran");
        return $query;
    }
    public function get_mapel(){
        $this->db->select("*,b.id as id_mapel");
        $this->db->from("penawaran a");
        $this->db->join("mapel b","a.id=b.id_penawaran");
        $query=$this->db->get();
        return $query;
    }
    public function get_kategori_nilai($idmapel){
        $this->db->select("*,a.id as kategori_id");
        $this->db->from("kategori_nilai a");
        $this->db->join("mapel b","a.id_mapel=b.id");
        $this->db->where("a.id_mapel",$idmapel);
        $query=$this->db->get();
        return $query;
    }
    public function get_ta($id=NULL){
        if($id!=NULL){$this->db->where("id",$id);}
        $query=$this->db->get("tahunajaran");
        return $query;
    }
    public function send_email($to_email,$subjek,$msg){
                $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.gmail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'bantuan@psi.dinus.ac.id', // change it to yours
                        'smtp_pass' => 'tanyapakifan', // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                        );
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from('bantuan@psi.dinus.ac.id','DINUS KARIR CENTER'); // change it to yours
                $this->email->to($to_email);// change it to yours
                $this->email->reply_to("bantuan@psi.dinus.ac.id");
                $this->email->subject($subjek);
                $this->email->message($msg);
                 if($this->email->send())
                 {
                    return true;    
                 }
                 else
                 {
                    return false;
                 }
    }
    public function santri_exist_by_id($id_barang){
        $this->db->where("nis",$id_barang);
        $query=$this->db->get("data_santri");
        if($query->num_rows()>0){
            return false;     
        }else{
            return true;
        }
    }
    public function get_santri($nis=NULL,$start=NULL,$limit=NULL,$setlimit=FALSE){
        if($nis!=NULL){
            $nis=$this->db->escape_str($nis);
            $this->db->where("nis",$nis);
            $query=$this->db->get("data_santri");
        }else{
            if($setlimit){
                $query=$this->db->get("data_santri",$start,$limit);
            }else{
                $query=$this->db->get("data_santri");    
            }
            
        }
        return $query;
    }
    public function get_prov($id_provinsi=NULL){
        if($id_provinsi!=NULL){
            $this->db->where("id",$id_provinsi);
        }
        $query=$this->db->get("provinces");
        return $query;
    }
    public function get_kabkot($id_provinsi=NULL,$self=FALSE){
        if($id_provinsi!=NULL){
            if($self){
                $this->db->where("id",$id_provinsi);
            }else{
                $this->db->where("province_id",$id_provinsi);    
            }
        }else{
            $this->db->where("province_id",NULL);
        }
        $query=$this->db->get("regencies");
        return $query;
    }
    public function get_kec($id_kabkot=NULL,$self=FALSE){
        if($id_kabkot!=NULL){
            if($self){
                $this->db->where("id",$id_kabkot);
            }else{
                $this->db->where("regency_id",$id_kabkot);    
            }
        }else{
            $this->db->where("regency_id",NULL);
        }
        $query=$this->db->get("districts");
        return $query;
    }
    public function get_desa($id_kec=NULL,$self=FALSE){
        if($id_kec!=NULL){
            if($self){
                $this->db->where("id",$id_kec);
            }else{
                $this->db->where("district_id",$id_kec);    
            }
        }else{
            $this->db->where("district_id",NULL);
        }
        $query=$this->db->get("villages");
        return $query;
    }
    public function get_toko_by_member($id_member){
        $this->db->where("id_member",$id_member);
        $query=$this->db->get("toko");
        return $query;
    }
    public function get_toko_by_id($id_toko){
        $this->db->where("id_toko",$id_toko);
        $query=$this->db->get("toko");
        return $query;
    }
    public function get_member_by_id($id_member){
        $this->db->where("id_member",$id_member);
        $query=$this->db->get("member");
        return $query;
    }
    public function get_kategori_ajax($kategori=NULL){
        $this->db->select("id,kategori as text");
        $this->db->from("kategori");
        $this->db->where('kategori like ',$kategori."%");
        $this->db->limit(15);
        $query=$this->db->get();
        return $query;
    }
    public function get_kategori_by_coma_separator($coma){
        $coma=explode(",",$coma);
        $this->db->where_in("id",$coma);
        $data=$this->db->get("kategori");
        return $data;
    }
}
?>