<?php
class Model_login extends CI_Model {

    function login($username,$sebagai,$password){
        $query=$this->db->query("select *,a.id as user_id,b.id as id_santri 
                                        from user a 
                                        join data_santri b 
                                on a.nis=b.nis 
                                where a.nis = ? and a.password = ? and a.sebagai = ?
                            ",array($username,$password,$sebagai));
        return $query;
    }
    function cek_email_exist($email){
        $this->db->where("email",$email);
        $data=$this->db->get("member");
        return $data;
    }
    function get_id_member_uniq()
    {
            for(;;){
                $id_member=random_string('alnum', 8);
                $this->db->where("id_member",$id_member);
                $query=$this->db->get("member");
                if($query->num_rows()==0){
                    break;     
                }
            }  
            return $id_barang;
    }
}
?>