<?php
class Model_login extends CI_Model {

    function login($username1,$username2,$password){
        $query=$this->db->query("select * 
                                        from user_member a 
                                        join member b 
                                on a.id_member=b.id_member 
                                where (a.username = ? or b.email = ?) and a.password = ?
                            ");
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