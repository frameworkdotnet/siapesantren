<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {
		

	public function __construct(){
        parent::__construct();
        $this->load->model('Model_admin');
        $this->load->model('Model_toko');

    }
    public function dashboard($content="",$key=NULL){
		if($key!=NULL && $key=="xxx!@#xxx"){
		$data=$content;
		$this->load->view('index_toko',$data);
		}else{
			redirect("not-found");
		}
	}
	public function index()
	{
		$data['title']="Dashboard | Admin";
		$data['title2']="Dashboard";
		$data['subtitle2']="";
		$data['breadcumbparenticon']="fa fa-dashboard";
		$data['breadcrumb']=array("Dashboard"=>"");
		$data['logo']="Toko Online";	
		$data['content']=$this->load->view("page_toko/home",$data,true);
		$this->dashboard($data,"xxx!@#xxx");

	}
}