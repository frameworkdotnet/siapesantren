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
    public function barang_exist_by_id($id_barang){
        $this->db->where("id_barang",$id_barang);
        $query=$this->db->get("barang");
        if($query->num_rows()>0){
            return $query;     
        }else{
            return false;
        }
    }
    public function get_prov($id_provinsi=NULL){
        if($id_provinsi!=NULL){
            $this->db->where("id",$id_provinsi);
        }
        $query=$this->db->get("loc_prov");
        return $query;
    }
    public function get_kabkot($id_provinsi=NULL,$self=FALSE){
        if($id_provinsi!=NULL){
            if($self){
                $this->db->where("id",$id_provinsi);
            }else{
                $this->db->where("id_provinsi",$id_provinsi);    
            }
        }
        $query=$this->db->get("loc_kabkot");
        return $query;
    }
    public function get_kec($id_kabkot=NULL,$self=FALSE){
        if($id_kabkot!=NULL){
            if($self){
                $this->db->where("id",$id_kabkot);
            }else{
                $this->db->where("id_kabkot",$id_kabkot);    
            }
        }
        $query=$this->db->get("loc_kec");
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