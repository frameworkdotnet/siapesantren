<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
		

	public function __construct(){
        parent::__construct();
        $this->load->model('Model_login');
    }
	public function index()
	{
		$this->load->view("login");
	}
	public function register(){
		$this->load->view("register");
	}
	function sign_in(){
		if(sizeof($this->input->post())>0){
			$username=$this->db->escape_str($this->input->post("username"));
			$password=$this->db->escape_str($this->input->post("password"));
			$gen_pass=sha1($password);
			$result=$this->Model_login->login($username,$username,$gen_pass);
			if($result->num_rows()==1){
					
			}
		}else{
			show_404();
		}
	}
	function sign_up(){
		if(sizeof($this->input->post())>0){
			$email=$this->input->post("email");
			$username=explode("@",$email);
			$username=$username[0];
			$password=$this->db->escape_str($this->input->post("password"));
			$fullname=$this->db->escape_str($this->input->post("fullname"));
			$gen_pass=sha1($password);
			$result=$this->Model_login->cek_email_exist($email);
			if($result->num_rows()>0){
				$this->session->set_flashdata("response",array("status"=>false,"msg"=>"Email sudah digunakan"));
				redirect("login/register");
			}else{
				$id_member=$this->Model_login->get_id_member_uniq();
				$this->db->insert("member",array(
						"id_member"=>$id_member,
						"email"=>$email	
				));
				if($this->db->affected_rows()>0){
					$t_email['nama']=$fullname;
					$t_email['username']=$username;
					$t_email['password']=$password;
					$t_email['link']=base_url()."validasi/".$username."/".$this->urlenkripsi->encode_url($id_member);
					
					$this->load->model('Model_admin');
					$msg=$this->load->view("template_email/template_email",$t_email);
	        		$sendemail=$this->Model_admin->send_email($email,"AKTIVASI AKUN TOKO ONLINE",$msg);
					if($sendemail){
						$status['status']=true;
						$this->load->view("template_email/template_validasi",$status);
					}else{
						$status['status']=false;
						$this->load->view("template_email/template_validasi",$status);
					}
				}else{
					$this->session->set_flashdata("response",array("status"=>false,"msg"=>"Gagal mendaftar, Silahkan ulangi kembali"));
					redirect("login/register");
				}
			}
		}else{
			show_404();
		}
	}
	function validasi_member($id_member){
		$id_member=$this->urlenkripsi->encode_url($id_member);
		
	}
}