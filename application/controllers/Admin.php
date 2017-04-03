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
	function get_desa(){
		if($this->input->is_ajax_request()){
			$id_kec=$this->input->post("id_kec");
			$desa=$this->Model_admin->get_desa($id_kec);
			$desa=$desa->result_array();
			echo json_encode($desa);
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
	public function penawaran($role=NULL,$subrole=NULL,$idsubrole=NULL){
		if($this->input->post("id_penawaranedit")!=NULL){
			$this->db->where("id",$this->input->post("id_penawaranedit"));
			$this->db->update("penawaran",array("penawaran"=>$this->input->post("penawaran")));
			redirect("admin/penawaran");
		}
		if($this->input->post("id_penawaranhapus")!=NULL){
			$this->db->where("id",$this->input->post("id_penawaranhapus"));
			$this->db->delete("penawaran");
			redirect("admin/penawaran");
		}
		if($role=="mapel"){
			if($subrole=="kategorinilai"){
				$data['role']="mapel";
				$data['title']="Kategori Nilai Mapel";
				$data['title2']="Kategori Nilai Mapel";
				$data['subtitle2']="";
				$data['breadcumbparenticon']="fa fa-dashboard";
				$data['breadcrumb']=array("Program Penawaran"=>"admin/penawaran","Mapel"=>"admin/penawaran/mapel","Kategori Nilai"=>"");
				$data['logo']="SIA Pesantren";
				$data['minlogo']="SP";	
				$data['mapel']=$this->Model_admin->get_mapel();
				$data['content']=$this->load->view("page_admin/kategorinilai",$data,true);
				$this->dashboard($data,"xxx!@#xxx");
			}else if($subrole=="inputkategori"||$subrole=="editkategori"){
				$id=$this->urlenkripsi->decode_url($idsubrole);
				$data['role']="mapel";
				$data['title']="Kategori Nilai Mapel";
				$data['title2']="Kategori Nilai Mapel";
				$data['subtitle2']="";
				$data['breadcumbparenticon']="fa fa-dashboard";
				$data['breadcrumb']=array("Program Penawaran"=>"admin/penawaran","Mapel"=>"admin/penawaran/mapel","Kategori Nilai"=>"");
				$data['logo']="SIA Pesantren";
				$data['minlogo']="SP";
				$data['role']=$subrole=="inputkategori"?'input':'edit';
				$data['idmapel']=$id;
				$data['kategori']=$this->Model_admin->get_kategori_nilai($id);	
				$data['content']=$this->load->view("page_admin/kategorinilai",$data,true);
				$this->dashboard($data,"xxx!@#xxx");
			}else if($subrole=="hapuskategori"){
				$id=$this->urlenkripsi->decode_url($idsubrole);
				
			}else if($subrole=="insertkategoriaction"){
				if(sizeof($this->input->post())>0){
				$datainput=array();
				$nama_mapel=$this->input->post('kategori_penilaian');
				foreach ($nama_mapel as $key=>$value) {
				  if(trim($value," ")!=""){	
					array_push($datainput, array(
						'id_mapel'=>$this->input->post('id_mapel'),
						'nama_kategori'=>$this->db->escape_str($value)
					));
				  }	
				}
				if(sizeof($datainput)>0){
				$this->db->insert_batch("kategori_nilai",$datainput);
				$row_change=$this->db->affected_rows();
				if($row_change>0){
					$this->session->set_flashdata("simpan",array("msg"=>"Data sudah di tambahkan","status"=>true,"row_change"=>$row_change));	
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Data gagal di tambahkan","status"=>false,"row_change"=>$row_change));	
				}
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Data mapel harus terisi","status"=>false,"row_change"=>$row_change));
				}
				redirect("admin/penawaran/mapel/kategorinilai");
			}else{
				show_404();
			}
			}else if($subrole==NULL){
				$data['role']="mapel";
				$data['title']="Mapel Program Penawaran";
				$data['title2']="Mapel Program Penawaran ";
				$data['subtitle2']="";
				$data['breadcumbparenticon']="fa fa-dashboard";
				$data['breadcrumb']=array("Program Penawaran"=>"admin/penawaran","Mapel"=>"");
				$data['logo']="SIA Pesantren";
				$data['minlogo']="TO";
				$data['penawaran']=$this->Model_admin->get_penawaran();	
				$data['mapel']=$this->Model_admin->get_mapel();
				$data['content']=$this->load->view("page_admin/penawaran",$data,true);
				$this->dashboard($data,"xxx!@#xxx");
			}else{
				redirect("admin/penawaran/mapel");
			}
		}else if($role=="simpanpenawaran"){
			if(sizeof($this->input->post())>0){
				$datainput=array(
					"penawaran"=>$this->input->post('nama_penawaran')
				);
				$this->db->insert("penawaran",$datainput);
				$row_change=$this->db->affected_rows();
				if($row_change>0){
					$this->session->set_flashdata("simpan",array("msg"=>"Data telah di tambahkan","status"=>true,"row_change"=>$row_change));	
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Data gagal di tambahkan","status"=>false,"row_change"=>$row_change));	
				}
				redirect("admin/penawaran");
			}else{
				show_404();
			}
		}else if($role=="simpanmapel"){
			if(sizeof($this->input->post())>0){
				$datainput=array();
				$nama_mapel=$this->input->post('mapel_penawaran');
				$kkm=$this->input->post('mapel_kkm');
				foreach ($nama_mapel as $key=>$value) {
				  if(trim($value," ")!=""&&$kkm[$key]!=NULL){	
					array_push($datainput, array(
						'id_penawaran'=>$this->input->post('id_penawaran'),
						'nama_mapel'=>$this->db->escape_str($value),
						'standar_kkm'=>$kkm[$key]
					));
				  }	
				}
				if(sizeof($datainput)>0){
				$this->db->insert_batch("mapel",$datainput);
				$row_change=$this->db->affected_rows();
				if($row_change>=0){
					$this->session->set_flashdata("simpan",array("msg"=>"Data mapel di tambahkan","status"=>true,"row_change"=>$row_change));	
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Data mapel di tambahkan","status"=>false,"row_change"=>$row_change));	
				}
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Data mapel harus terisi","status"=>false,"row_change"=>$row_change));
				}
				redirect("admin/penawaran/mapel");
			}else{
				show_404();
			}
		}else{
			$data['role']="penawaran";
			$data['title']="Program Penawaran";
			$data['title2']="Program Penawaran ";
			$data['subtitle2']="";
			$data['breadcumbparenticon']="fa fa-dashboard";
			$data['breadcrumb']=array("Program Penawaran"=>"");
			$data['logo']="SIA Pesantren";
			$data['minlogo']="TO";
			$data['penawaran']=$this->Model_admin->get_penawaran();	
			$data['content']=$this->load->view("page_admin/penawaran",$data,true);
			$this->dashboard($data,"xxx!@#xxx");	
		}
	}

	public function tahunajaran(){
		if($this->input->post("id_ta")!=NULL){
			$this->db->trans_start();
				$this->db->update("tahunajaran",array("status"=>"Tidak_aktif"));
				$this->db->where("id",$this->input->post("id_ta"));
				$this->db->update("tahunajaran",array("status"=>"Aktif"));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$row_change=0; 
			}else{
				$row_change=1;	
			}
			if($row_change>0){
				$this->session->set_flashdata("simpan",array("msg"=>"Tahun ajaran telah diaktifkan","status"=>true,"row_change"=>$row_change));	
			}else{
				$this->session->set_flashdata("simpan",array("msg"=>"Tahun ajaran gagal diaktifkan","status"=>false,"row_change"=>$row_change));	
			}
			redirect("admin/tahunajaran");
		}
		if($this->input->post("id_tahapus")!=NULL){
			$this->db->where("id",$this->input->post("id_tahapus"));
			$this->db->delete("tahunajaran");
			$row_change=$this->db->affected_rows();
			if($row_change>0){
				$this->session->set_flashdata("simpan",array("msg"=>"Tahun ajaran telah terhapus","status"=>true,"row_change"=>$row_change));	
			}else{
				$this->session->set_flashdata("simpan",array("msg"=>"Tahun ajaran gagal dihapus","status"=>false,"row_change"=>$row_change));	
			}
			redirect("admin/tahunajaran");
		}
		$data['title']="Tahun Ajaran";
		$data['title2']="Tahun Ajaran";
		$data['subtitle2']="";
		$data['breadcumbparenticon']="fa fa-dashboard";
		$data['breadcrumb']=array("Tahun Ajaran"=>"");
		$data['logo']="SIA Pesantren";
		$data['minlogo']="TO";
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
	public function santri($role=NULL,$nis=NULL){
		if($role=="view"){
			$data['title']="Daftar Santri";
			$data['title2']="Daftar Santri";
			$data['subtitle2']="";
			$data['breadcumbparenticon']="fa fa-dashboard";
			$data['breadcrumb']=array("Data Santri"=>"");
			$data['logo']="SIA Pesantren";
			$data['minlogo']="SP";
			$santri=$this->Model_admin->get_santri();
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/santri/view/";
			$config['full_tag_open'] = '<ul class="pagination">';
	        $config['full_tag_close'] = '</ul>';
	        $config['first_link'] = false;
	        $config['last_link'] = false;
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo';
	        $config['prev_tag_open'] = '<li class="prev">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = '&raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="#">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';
			$config['total_rows'] = $santri->num_rows();
			$config['per_page'] = 500;
			$this->pagination->initialize($config);
			$data['pagination']=$this->pagination->create_links();
			$nis=$nis==NULL?0:$nis;
			$data['santri']=$this->Model_admin->get_santri(NULL,$nis,500);
			$data['content']=$this->load->view("page_admin/view_santri",$data,true);
			$this->dashboard($data,"xxx!@#xxx");
		}else if($role=="edit"){
			$nis=$this->urlenkripsi->decode_url($nis);
			$santri=$this->Model_admin->get_santri($nis);
			$santri=$santri->row();
			if(isset($santri)){
				$data['title']="Edit Data Santri";
				$data['title2']="Edit Data Santri";
				$data['subtitle2']="";
				$data['breadcumbparenticon']="fa fa-dashboard";
				$data['breadcrumb']=array("Data Santri"=>"");
				$data['logo']="SIA Pesantren";	
				$data['prov']=$this->Model_admin->get_prov();
				$data['kab']=$this->Model_admin->get_kabkot($santri->id_prov);
				$data['kec']=$this->Model_admin->get_kec($santri->id_kab);
				$data['desa']=$this->Model_admin->get_desa($santri->id_kec);
				$data['santri']=$santri;
				$data['content']=$this->load->view("page_admin/edit_santri",$data,true);
				$this->dashboard($data,"xxx!@#xxx");
			}else{
				redirect("admin/santri");
			}
		}else if($role=="editaction"){
			if(sizeof($this->input->post())>0){
				$datainput=array(
						'nis'=>$this->input->post('nis'),
					    'nama'=>$this->input->post('nama'),
					    'jenkel'=>$this->input->post('jenkel'),
					    'agama'=>$this->input->post('agama'),
					    'email'=>$this->input->post('email'),
					    'nohp'=>$this->input->post('no_hp'), 
					    'tmp_lhr'=>$this->input->post('tmp_lhr'), 
					    'tgl_lhr'=>todate($this->input->post('tgl_lhr')),
					    'id_prov'=>$this->input->post('prov'), 
					    'id_kab'=>$this->input->post('kab'), 
					    'id_kec'=>$this->input->post('kec'), 
					    'id_desa'=>$this->input->post('desa'), 
					    'rt_rw'=>$this->input->post('rt_rw'), 
					    'kodepos'=>$this->input->post('kodepos'), 
					    'ket_alamat_lain'=>$this->input->post('ket_lain'), 
					    'nama_ayah'=>$this->input->post('namaayah'), 
					    'nama_ibu'=>$this->input->post('namaibu'), 
					    'work_ayah'=>$this->input->post('workayah'), 
					    'work_ibu'=>$this->input->post('workibu'), 
					    'hp_ortu'=>$this->input->post('hportu')
		    		);
				$this->db->where("nis",$datainput['nis']);
				$this->db->update("data_santri",$datainput);
				$row_change=$this->db->affected_rows();
				if($row_change>=0){
					$this->session->set_flashdata("simpan",array("msg"=>"Data telah di ganti","status"=>true,"row_change"=>$row_change));	
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Tidak ada perubahan","status"=>true,"row_change"=>$row_change));	
				}
				redirect("admin/santri/edit/".$this->urlenkripsi->encode_url($datainput['nis']));
			}else{
				redirect("admin/santri");
			}
		}else if($role=="hapus"){
			$nis=$this->urlenkripsi->decode_url($nis);
			$santri=$this->Model_admin->get_santri($nis);
			$santri=$santri->row();
			if(isset($santri)){
				$data['title']="Hapus Data Santri";
				$data['title2']="Hapus Data Santri";
				$data['subtitle2']="";
				$data['breadcumbparenticon']="fa fa-dashboard";
				$data['breadcrumb']=array("Data Santri"=>"");
				$data['logo']="SIA Pesantren";
				$data['minlogo']="SP";
				$data['santri']=$santri;
				$data['sethapus']=true;
				$data['content']=$this->load->view("page_admin/view_santri",$data,true);
				$this->dashboard($data,"xxx!@#xxx");
			}else{
				redirect("admin/santri/view/");
			}	
		}else if($role=="hapusaction"){
			if(sizeof($this->input->post())>0){
				$this->db->where("nis",$this->input->post("nis"));
				$this->db->delete("data_santri");
				$row_change=$this->db->affected_rows();
				if($row_change>0){
					$this->session->set_flashdata("simpan",array("msg"=>"Data telah di terhapus","status"=>true,"row_change"=>$row_change));	
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Gagal menghapus data","status"=>false,"row_change"=>$row_change));	
				}
				redirect("admin/santri/view/");
			}else{
				show_404();
			}
		}else if($role=="daftar"){
			if(sizeof($this->input->post())>0){
				if($this->Model_admin->santri_exist_by_id($this->input->post('nis'))){
					$datainput=array(
						'nis'=>$this->input->post('nis'),
					    'nama'=>$this->input->post('nama'),
					    'jenkel'=>$this->input->post('jenkel'),
					    'agama'=>$this->input->post('agama'),
					    'email'=>$this->input->post('email'),
					    'nohp'=>$this->input->post('no_hp'), 
					    'tmp_lhr'=>$this->input->post('tmp_lhr'), 
					    'tgl_lhr'=>date_parse($this->input->post('tgl_lhr')),
					    'id_prov'=>$this->input->post('prov'), 
					    'id_kabkot'=>$this->input->post('kabkot'), 
					    'id_kec'=>$this->input->post('kec'), 
					    'id_desa'=>$this->input->post('desa'), 
					    'rt_rw'=>$this->input->post('rt_rw'), 
					    'kodepos'=>$this->input->post('kodepos'), 
					    'ket_alamat_lain'=>$this->input->post('ket_lain'), 
					    'nama_ayah'=>$this->input->post('namaayah'), 
					    'nama_ibu'=>$this->input->post('namaibu'), 
					    'work_ayah'=>$this->input->post('workayah'), 
					    'work_ibu'=>$this->input->post('workibu'), 
					    'hp_ortu'=>$this->input->post('hportu')
		    		);
		    		$this->db->insert("data_santri",$datainput);
		    		$row_change=$this->db->affected_rows();
					if($row_change>=0){
						$this->session->set_flashdata("simpan",array("msg"=>"Data telah di tambahkan","status"=>true,"row_change"=>$row_change));	
					}else{
						$this->session->set_flashdata("simpan",array("msg"=>"Data gagal di tambahkan","status"=>false,"row_change"=>$row_change));	
					}
				}else{
					$this->session->set_flashdata("simpan",array("msg"=>"Nis Sudah Terdaftar","status"=>false,"row_change"=>$row_change));	
				}
			}
			redirect("admin/santri");
		}else{
			$data['title']="Tambah Data Santri";
			$data['title2']="Tambah Data Santri";
			$data['subtitle2']="";
			$data['breadcumbparenticon']="fa fa-dashboard";
			$data['breadcrumb']=array("Data Santri"=>"");
			$data['logo']="SIA Pesantren";	
			$data['minlogo']="SP";
			$data['prov']=$this->Model_admin->get_prov();
			$data['content']=$this->load->view("page_admin/santri",$data,true);
			$this->dashboard($data,"xxx!@#xxx");	
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
