<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller..
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
                parent::__construct();
                if($this->session->userdata("login")!=true&&$this->session->userdata("id_santri")==NULL&&$this->session->userdata("nis")==NULL){
                	redirect("login");
                }else{
                	$this->load->model('Model_admin');
                }
                
    }
	public function dashboard($content="",$key=NULL){
		if($key!=NULL && $key=="xxx!@#xxx"){
		$data=$content;
		$this->load->view('index_admin',$data);
		}else{
			redirect("not-found");
		}
	}
	function get_loc(){
		echo file_get_contents("https://geoip-db.com/json/");
		
	}
	public function index()
	{
		$data['title']="Dashboard | Admin";
		$data['title2']="Dashboard";
		$data['subtitle2']="";
		$data['breadcumbparenticon']="fa fa-dashboard";
		$data['breadcrumb']=array("Dashboard"=>"");
		$data['logo']="Toko Online";	
		$data['content']=$this->load->view("page_admin/dashboard",$data,true);
		$this->dashboard($data,"xxx!@#xxx");

	}
	public function profile(){
		$data['title']="Profile | Admin";
		$data['logo']="Admin Pesantren";
		$data['minlogo']="SIA";
		$data['title2']="Profile";
		$data['subtitle2']=$this->session->userdata('username');
		$data['breadcumbparenticon']="fa fa-th";
		$data['breadcrumb']=array("Profile"=>"admin/profile");

		$member=$this->Model_admin->get_member_by_id($this->session->userdata("id_member"));
		$data['member']=$member;
		$toko=$this->Model_admin->get_toko_by_member("Rtyg45Der");
		$data['toko']=$toko;

		$data['prov']=$this->Model_admin->get_prov();
		$data['content']=$this->load->view("page_admin/profile",$data,true);
		$this->dashboard($data,"xxx!@#xxx");
	}
	function simpanprofile(){
		$id_member=$this->session->userdata("id_member");
		$datainput=array(
			"nama"=>$this->input->post('nama'),
			"tgl_lhr"=>todate($this->input->post('tgl_lhr')),
			"email"=>$this->input->post('email'),
			"nohp"=>$this->input->post('no_hp'),
			"id_prov"=>$this->input->post('prov'),
			"id_kabkot"=>$this->input->post('kabkot'),
			"id_kec"=>$this->input->post('kec'),
			"ket_almt"=>$this->input->post('ket_alamat'),
			"kodepos"=>$this->input->post('kodepos')
		);
		$this->db->where("id_member",$id_member);
		$this->db->update("member",$datainput);
		$row_change=$this->db->affected_rows();
		if($row_change>=0){
			$this->session->set_flashdata("simpan",array("msg"=>"Data profil telah terganti","status"=>true,"row_change"=>$row_change));	
		}else{
			$this->session->set_flashdata("simpan",array("msg"=>"Data profil gagal diganti","status"=>false,"row_change"=>$row_change));	
		}
		redirect("admin/profile");
	}
	function simpantoko(){
		$id_toko=$this->input->post("id_toko");
		$datainput=array(
			"id_toko"=>$id_toko,
			"nama_toko"=>$this->input->post('nama'),
			"deskripsi_toko"=>$this->input->post('deskripsi_toko'),
			"kategori_toko"=>implode(",",$this->input->post("kategori_toko")),
			"id_prov"=>$this->input->post('prov1'),
			"id_kabkot"=>$this->input->post('kabkot1'),
			"id_kec"=>$this->input->post('kec1'),
			"ket_almt"=>$this->input->post('ket_alamat'),
			"kodepos"=>$this->input->post('kodepos')
		);
		$this->db->where("id_toko",$id_toko);
		$this->db->update("toko",$datainput);
		$row_change=$this->db->affected_rows();
		if($row_change>=0){
			$this->session->set_flashdata("simpan",array("msg"=>"Data profil telah terganti","status"=>true,"row_change"=>$row_change));	
		}else{
			$this->session->set_flashdata("simpan",array("msg"=>"Data profil gagal diganti","status"=>false,"row_change"=>$row_change));	
		}
		redirect("admin/profile");	
	}
	function get_kabkot(){
		if($this->input->is_ajax_request()){
			$id_prov=$this->input->post("id_prov");
			$kabkot=$this->Model_admin->get_kabkot($id_prov);
			$kabkot=$kabkot->result_array();
			echo json_encode($kabkot);
		}else{
			show_404();
		}
	}
	function get_kec(){
		if($this->input->is_ajax_request()){
			$id_kabkot=$this->input->post("id_kabkot");
			$kec=$this->Model_admin->get_kec($id_kabkot);
			$kec=$kec->result_array();
			echo json_encode($kec);
		}else{
			show_404();
		}
	}
	function get_toko(){
		if($this->input->is_ajax_request()){
			$id_toko=$this->input->post("id_toko");
			$data['id_toko']=$id_toko;
			$toko=$this->Model_admin->get_toko_by_id($id_toko);
			if($toko->num_rows()==0){die;}
			$data['toko']=$toko->row();
			$this->load->view("page_admin/profil_toko",$data);
		}else{
			show_404();
		}
	}
	function get_desc_toko(){
		if($this->input->is_ajax_request()){
			$id_toko=$this->input->post("id_toko");
			$toko=$this->Model_admin->get_toko_by_id($id_toko);
			if($toko->num_rows()==0){echo "false";die;}
			$toko=$toko->row();
			$prov=$this->Model_admin->get_prov($toko->id_prov);
			$prov=$prov->row();
			$kabkot=$this->Model_admin->get_kabkot($toko->id_kabkot,TRUE);
			$kabkot=$kabkot->row();
			echo json_encode(array("nama_toko"=>$toko->nama_toko,"deskripsi_toko"=>$toko->deskripsi_toko,"provinsi"=>$prov->provinsi,"kabkot"=>$kabkot->kabkot));
		}else{
			show_404();
		}
	}
	function get_kategori(){
		if($this->input->is_ajax_request()){
		  
		  $kategori=$this->input->post('q');
		  $result=$this->Model_admin->get_kategori_ajax($kategori);
		  $result=$result->result();
		  echo json_encode($result);  
		}else{
			show_404();
		}
	}
	public function liststok($id_barang=NULL){
		$data['title']="Stok Barang | Admin";
		$data['logo']="Toko Online";
		$data['minlogo']="TO";

		$data['title2']="Barang";
		$data['subtitle2']="Stok Barang";
		$data['breadcumbparenticon']="fa fa-th";
		$data['breadcrumb']=array("Barang"=>"admin/barang","Stok Barang"=>"");

		$query=$this->Model_admin->barang_exist_by_id($id_barang);
		if($id_barang==NULL){
			$data['barang']=$this->Model_admin->get_stok();
			$data['content']=$this->load->view("page_admin/liststok",$data,true);
		}else if($query){
			$data['editbarang']=$query;
			$data['content']=$this->load->view("page_admin/liststok",$data,true);
		}else{
			$data['barang']=$this->Model_admin->get_stok();
			$data['content']=$this->load->view("page_admin/liststok",$data,true);
		}
		
		$this->dashboard($data,"xxx!@#xxx");
	}
	public function penawaran(){
		if($this->input->post("id_penawaranedit")!=NULL){
			$this->db->where("id",$this->input->post("id_penawaranedit"));
			$this->db->update("penawaran",array("penawaran"=>$this->input->post("penawaran")));
		}
		if($this->input->post("id_penawaranhapus")!=NULL){
			$this->db->where("id",$this->input->post("id_penawaranhapus"));
			$this->db->delete("penawaran");
		}
		$data['title']="Program Penawaran";
		$data['title2']="Program Penawaran ";
		$data['subtitle2']="";
		$data['breadcumbparenticon']="fa fa-dashboard";
		$data['breadcrumb']=array("Program Penawaran"=>"");
		$data['logo']="Toko Online";
		$data['penawaran']=$this->Model_admin->get_penawaran();	
		$data['content']=$this->load->view("page_admin/penawaran",$data,true);
		$this->dashboard($data,"xxx!@#xxx");
	}
	function simpanpenawaran(){
		if(sizeof($this->input->post())>0){
			$datainput=array(
				"penawaran"=>$this->input->post('nama_penawaran')
			);
			$this->db->insert("penawaran",$datainput);
			$row_change=$this->db->affected_rows();
			if($row_change>=0){
				$this->session->set_flashdata("simpan",array("msg"=>"Data telah di tambahkan","status"=>true,"row_change"=>$row_change));	
			}else{
				$this->session->set_flashdata("simpan",array("msg"=>"Data gagal di tambahkan","status"=>false,"row_change"=>$row_change));	
			}
			redirect("admin/penawaran");
		}else{
			show_404();
		}
	}
	public function tahunajaran(){
		if($this->input->post("id_ta")!=NULL){
			$this->db->update("tahunajaran",array("status"=>"Tidak_aktif"));
			$this->db->where("id",$this->input->post("id_ta"));
			$this->db->update("tahunajaran",array("status"=>"Aktif"));
		}
		if($this->input->post("id_tahapus")!=NULL){
			$this->db->where("id",$this->input->post("id_tahapus"));
			$this->db->delete("tahunajaran");
		}
		$data['title']="Tahun Ajaran";
		$data['title2']="Tahun Ajaran";
		$data['subtitle2']="";
		$data['breadcumbparenticon']="fa fa-dashboard";
		$data['breadcrumb']=array("Tahun Ajaran"=>"");
		$data['logo']="SIA Pesantren";
		$data['ta']=$this->Model_admin->get_ta();	
		$data['content']=$this->load->view("page_admin/tahunajaran",$data,true);
		$this->dashboard($data,"xxx!@#xxx");
	}
	function simpanta(){
		if(sizeof($this->input->post())>0){
			$datainput=array(
				"tahun"=>$this->input->post('tahun'),
				"periode"=>$this->input->post('periode')
			);
			$this->db->insert("tahunajaran",$datainput);
			$row_change=$this->db->affected_rows();
			if($row_change>0){
				$this->session->set_flashdata("simpan",array("msg"=>"Data telah di tambahkan","status"=>true,"row_change"=>$row_change));	
			}else{
				$this->session->set_flashdata("simpan",array("msg"=>"Data gagal di tambahkan","status"=>false,"row_change"=>$row_change));	
			}
			redirect("admin/tahunajaran");
		}else{
			show_404();
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect("login");
	}
	public function barang(){
		$data['title']="Tambah Barang | Admin";
		$data['logo']="Toko Online";
		$data['minlogo']="TO";
		
		$data['title2']="Barang";
		$data['subtitle2']="Tambah Barang";
		$data['breadcumbparenticon']="fa fa-th";
		$data['breadcrumb']=array("Barang"=>"admin/barang","Tambah Barang"=>"");
		$data['content']=$this->load->view("page_admin/barang",$data,true);
		$this->dashboard($data,"xxx!@#xxx");
	}
	function edit_barang(){
		if($this->input->post('token')!=NULL){
			$id_barang=$this->input->post('id_barang');
			$datainput=array(
				'id_toko'=>$this->input->post('id_toko'),
				'nama_brg'=>$this->input->post('nama_barang'),
				'kategori'=>implode(",",$this->input->post('kategori_barang')),
				'tag'=>$this->input->post('tag_barang'),
				'keyword'=>$this->input->post('keyword_barang'),
				'deskripsi'=>$this->input->post('deskripsi_barang'),
				'keterangan'=>$this->input->post('keterangan_barang'),
				'harga'=>$this->input->post('harga_barang'),
				'stock'=>$this->input->post('stok_barang'),
				'kondisi'=>$this->input->post('kondisi'),
				'title_seo'=>$this->input->post('title_seo'),
				'permalink'=>$this->input->post('permalink'),
				'video'=>$this->input->post('video_barang'),
				'web_review'=>$this->input->post('web_review'),
				'status'=>$this->input->post('status_barang'),
				'berat'=>$this->input->post('berat'),
				'panjang'=>$this->input->post('panjang'),
				'lebar'=>$this->input->post('lebar'),
				'tinggi'=>$this->input->post('tinggi')
			);
			$file1=$this->input->post("file1");
			$file2=$this->input->post("file2");
			$file3=$this->input->post("file3");
			$file4=$this->input->post("file4");
			$file5=$this->input->post("file5");
			$file6=$this->input->post("file6");
			$gambar_aktiv=0;
			if(file_exists("./assets/upload/image/".$file1)&&$file1!=""){
				$gambar_aktiv=1;
				if (strpos($file1,$id_barang) === false){
					$this->db->set('gambar_1',$id_barang."#".$file1);
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file1, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file1);
				}else{
					$this->db->set('gambar_1',$file1);
				}
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/image/".$file2)&&$file2!=""){
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:2;
				if (strpos($file2,$id_barang) === false){
					$this->db->set('gambar_2',$id_barang."#".$file2);
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file2, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file2);
				}else{
					$this->db->set('gambar_2',$file2);
				}
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/image/".$file3)&&$file3!=""){
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:3;
				if (strpos($file3,$id_barang) === false){
					$this->db->set('gambar_3',$id_barang."#".$file3);
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file3, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file3);
				}else{
					$this->db->set('gambar_3',$file3);
				}
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/image/".$file4)&&$file4!=""){
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:4;
				if (strpos($file4,$id_barang) === false){
					$this->db->set('gambar_4',$id_barang."#".$file4);
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file4, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file4);
				}else{
					$this->db->set('gambar_4',$file4);
				}
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/image/".$file5)&&$file5!=""){
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:5;
				if (strpos($file5,$id_barang) === false){
					$this->db->set('gambar_5',$id_barang."#".$file5);
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file5, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file5);
				}else{
					$this->db->set('gambar_5',$file5);
				}
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/image/".$file6)&&$file6!=""){
				$this->db->set('gambar_6',$id_barang."#".$file6);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:6;
				if (strpos($file6,$id_barang) === false){
					rename("./assets/upload/".$this->session->userdata("username")."/image/".$file6, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file6);
				}
			}
			$this->db->set('gambar_aktiv', $gambar_aktiv);
			$this->db->where("id_barang",$id_barang);
			$this->db->update("barang",$datainput);
			if($this->db->affected_rows()>0){
				$this->session->set_flashdata("simpan",array("status"=>true));
			}else{
				$this->session->set_flashdata("simpan",array("status"=>false));
			}
			redirect("admin/liststok");
		}else{
			show_404();
		}
	}
	function simpan_barang(){
		if($this->input->post('token')!=NULL){
			$id_barang=$this->Model_admin->get_id_barang_uniq();
			$datainput=array(
				'id_toko'=>$this->input->post('id_toko'),
				'id_member'=>$this->session->userdata("id_member"),
				'nama_brg'=>$this->input->post('nama_barang'),
				'kategori'=>implode(",",$this->input->post('kategori_barang')),
				'tag'=>$this->input->post('tag_barang'),
				'keyword'=>$this->input->post('keyword_barang'),
				'deskripsi'=>$this->input->post('deskripsi_barang'),
				'keterangan'=>$this->input->post('keterangan_barang'),
				'harga'=>$this->input->post('harga_barang'),
				'stock'=>$this->input->post('stok_barang'),
				'kondisi'=>$this->input->post('kondisi'),
				'title_seo'=>$this->input->post('title_seo'),
				'permalink'=>$this->input->post('permalink'),
				'video'=>$this->input->post('video_barang'),
				'web_review'=>$this->input->post('web_review'),
				'status'=>$this->input->post('status_barang'),
				'berat'=>$this->input->post('berat'),
				'panjang'=>$this->input->post('panjang'),
				'lebar'=>$this->input->post('lebar'),
				'tinggi'=>$this->input->post('tinggi')
			);
			$file1=$this->input->post("file1");
			$file2=$this->input->post("file2");
			$file3=$this->input->post("file3");
			$file4=$this->input->post("file4");
			$file5=$this->input->post("file5");
			$file6=$this->input->post("file6");
			$gambar_aktiv=0;
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file1)&&$file1!=""){
				$this->db->set('gambar_1',$id_barang."#".$file1);
				$gambar_aktiv=1;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file1, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file1);
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file2)&&$file2!=""){
				$this->db->set('gambar_2',$id_barang."#".$file2);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:2;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file2, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file2);
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file3)&&$file3!=""){
				$this->db->set('gambar_3',$id_barang."#".$file3);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:3;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file3, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file3);
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file4)&&$file4!=""){
				$this->db->set('gambar_4',$id_barang."#".$file4);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:4;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file4, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file4);
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file5)&&$file5!=""){
				$this->db->set('gambar_5',$id_barang."#".$file5);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:5;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file5, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file5);
			}
			if(file_exists("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file6)&&$file6!=""){
				$this->db->set('gambar_6',$id_barang."#".$file6);
				$gambar_aktiv=$gambar_aktiv!=0?$gambar_aktiv:6;
				rename("./assets/upload/".$this->session->userdata("username")."/temp_image/".$file6, "./assets/upload/".$this->session->userdata("username")."/image/".$id_barang."#".$file6);
			}
			$this->db->set('gambar_aktiv', $gambar_aktiv);
			$this->db->set('date_update', 'NOW()', FALSE); 
			$this->db->set('id_barang', $id_barang);
			$this->db->insert("barang",$datainput);
			if($this->db->affected_rows()>0){
				$this->session->set_flashdata("simpan",array("status"=>true));
			}else{
				$this->session->set_flashdata("simpan",array("status"=>false));
			}
			redirect("admin/barang");
		}else{
			show_404();
		}
	}
	public function upload_image($edit=0){
		if($this->input->is_ajax_request()){
			if($edit==0){$folder="temp_image";}
			else{$folder="image";}
			$config['upload_path'] = './assets/upload/'.$this->session->userdata("username").'/'.$folder.'/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']     = '500';
			$config['max_width'] = '768';
			$config['max_height'] = '768';
			$config['file_ext_tolower'] = TRUE;
			$config['file_name'] = "1_".$_FILES['file']['name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
				if ($this->upload->do_upload("file")) {
					echo json_encode(array("status"=>true,"message"=>$this->upload->data('file_name')));
				}else{
					echo json_encode(array("status"=>false,"message"=>$this->upload->display_errors()));
				}
			}
	}
	public function remove_image(){
		if($this->input->is_ajax_request()){
			if($this->input->post('edit')=="1"){
				$folder="image/";
			}else{
				$folder="temp_image/";
			}
		   $storeFolder = './assets/upload/'.$this->session->userdata("username").'/'.$folder;   //2
		   $file=$this->input->post("file");
		   if($this->input->post('id_barang')!=NULL){
		   		$this->db->where("id_barang",$this->input->post('id_barang'));
		   		$this->db->update("barang",array("gambar_".$this->input->post('gambar_ke')=>NULL));
		   }
		   if(file_exists($storeFolder.$file)){	
		   	if(!unlink($storeFolder.$file)){
		   		echo json_encode(array("status"=>false,"message"=>"File not exist"));
		   	}else{
		   		echo json_encode(array("status"=>true,"message"=>$file));
		   	}
		   }else{
		   	echo json_encode(array("status"=>false,"message"=>"File not exist"));
		   }
		}
	}
	public function not_found(){
		show_404();
	}

}
