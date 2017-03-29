<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<style type="text/css">
  fieldset {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    border:none;
    width:130px;
}

</style>
<div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/profile/<?php echo $this->session->userdata('foto'); ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>assets/image/default-profile.png';" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this->session->userdata('nama'); ?></h3>

              <p class="text-muted text-center"><?php echo $this->session->userdata('username'); ?></p>
              <!--
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Pengunjung</b> <small><a href="#">(Lihat !)</a></small> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Pengikut</b> <small><a href="#">(Keterangan)</a></small> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Total Produk</b> <small><a href="#">(Detail)</a></small> <a class="pull-right">13,287</a>
                </li>
              </ul>
               -->
              <a href="#" class="btn btn-primary btn-block btn-sm"><b>Ganti Profil Avatar</b></a>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary" id="desc_toko">
            <div class="box-header with-border">
              <h3 class="box-title">Tentang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
              <p class="text-muted area">sdfsd</p>
              <hr>
              <strong><i class="fa fa-pencil margin-r-5"></i> Kategori </strong>
              <p>
              <!--
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              -->
              </p>
              <hr>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Deskripsi</strong>
              <p class="text-muted desc"></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datapribadi" data-toggle="tab">Data Pribadi</a></li>
              <!--
              <li><a href="#datatoko" data-toggle="tab">Data Toko</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
              -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="datapribadi">
              <div class="panel">
              <?php echo form_open("admin/simpanprofile",array("class"=>"panel-body","id"=>"formbio","onsubmit"=>"return validation_bio()")); 
                $member=$member->result();
                $datamember=NULL;
                foreach ($member as $key) {
                  $datamember=$key;
                }
              ?>
                <div class="col-md-12">
                    <div class="row">
                      <fieldset>
                      <legend>Data Pribadi</legend>
              <?php    
                  if($this->session->flashdata("simpan")['status']==true && $this->session->flashdata("simpan")!=NULL){
                      ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                <?php   echo $this->session->flashdata("simpan")['msg']; ?>
              </div>        
                      <?php
                  }else if($this->session->flashdata("simpan")['status']==false && $this->session->flashdata("simpan")!=NULL){
                      ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
                <?php   echo $this->session->flashdata("simpan")['msg']; ?>
              </div>
                      <?php
                    }
              ?>        
              
                  <div class="form-group col-md-6">
                    <label>Nama Anda</label>
                    <input type="text" class="form-control filter-text" name="nama" value="<?php  echo $datamember->nama; ?>" placeholder="Name Owner Toko" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php  echo $datamember->email; ?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Nomor Hp</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control" id="datemasktlp" name="no_hp" value="<?php  echo $datamember->nohp; ?>" data-inputmask="'mask': ['999-999-999-999', '+6299-999-999-999']" data-mask>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tanggal Lahir</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" id="datemasktgl" class="form-control" name="tgl_lhr" value="<?php  echo todate($datamember->tgl_lhr,FALSE); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" required>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                          <label>Provinsi Anda Tinggal :</label>
                          <select class="form-control" name="prov" required onchange="get_kabkot(event)">
                            <option value="">Pilih Provinsi</option>
                            <?php 
                              $prov=$prov->result();
                              foreach ($prov as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php   echo $datamember->id_prov==$key->id?'selected':''; ?>><?php echo $key->provinsi; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Kabupaten/Kota Anda Tinggal</label>
                          <select class="form-control" name="kabkot" required onchange="get_kec(event)">
                            <option value="">Pilih Kabupaten/Kota</option>
                            <?php    
                              $kabkot=$this->Model_admin->get_kabkot($datamember->id_prov);
                              $kabkot=$kabkot->result();
                              foreach ($kabkot as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php   echo $datamember->id_kabkot==$key->id?'selected':''; ?>><?php echo $key->kabkot; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>

                        <div class="form-group col-md-6">
                          <label>Kecamatan Anda Tinggal</label>
                          <select class="form-control" name="kec" required>
                            <option value="">Pilih Kecamatan</option>
                            <?php    
                              $kec=$this->Model_admin->get_kec($datamember->id_kabkot);
                              $kec=$kec->result();
                              foreach ($kec as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php   echo $datamember->id_kec==$key->id?'selected':''; ?>><?php echo $key->kecamatan; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Kodepos</label>
                          <input type="text" class="form-control filter-number" value="<?php  echo $datamember->kodepos; ?>" name="kodepos" placeholder="Kodepos">
                        </div>

                   <div class="form-group col-md-12">
                      <label>Alamat Tambahan : </label>
                      <textarea class="form-control filter-text" name="ket_alamat" placeholder="Keterangan Alamat anda"><?php  echo $datamember->ket_almt; ?></textarea>
                  </div>
                  <div class="form-group col-md-12" align="right">
                    
                      <button type="button" onclick="simpanbio()" class="btn btn-danger">Simpan</button>
                   
                  </div>
                  </fieldset>
                    </div>
                  </div>
                  
                <?php echo form_close(); ?>
                </div>
              </div>
              <!-- /.tab-pane -->
              <!--
              <div class="tab-pane" id="datatoko">
                <div class="panel">
                <div class="panel-body">
                  <div class="col-md-12">
                    <div class="row">
                      <fieldset>
                        <legend>Toko Anda</legend>
                        <div class="form-group">
                          <label>Pilih Toko</label>
                          <select class="form-control" name="toko" required onchange="get_rincian_toko(event)">
                            <option value="">Pilih Toko</option>
                            <?php 
                              $toko=$toko->result();
                              foreach ($toko as $key) {
                                ?>
                                <option value="<?php echo $key->id_toko; ?>"><?php echo $key->nama_toko; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row" id="content_toko">
                      
                    </div>
                  </div>
                  </div>
                  </div>
                </div>
                
              <div class="tab-pane" id="settings">
                asdasd
              </div>
              -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
      <script type="text/javascript">
      function validation_bio(){
        return true;
      }
      function simpanbio(){
       var $myForm = $('#formbio');
          if ($myForm[0].checkValidity()) {
            $("#formbio").submit();
          }else{
            alert("form belum valid, pastikan sudah terisi semua");
          }
      }
      function get_rincian_toko(e){
        $("#content_toko").html("");
        $.post("<?php echo base_url(); ?>admin/get_toko",{id_toko:$(e.target).val()},function(data){
         $("#content_toko").html(data);
        });
        $.post("<?php echo base_url(); ?>admin/get_desc_toko",{id_toko:$(e.target).val()},function(data){
         var jsondata=JSON.parse(data);
         $("#desc_toko .box-title").html("Preview "+jsondata.nama_toko);
         $("#desc_toko .desc").html(jsondata.deskripsi_toko);
         $("#desc_toko .area").html(jsondata.provinsi+", "+jsondata.kabkot);
        });
      }
      function get_kabkot(e){
        $('select[name="kabkot"]').html("Waiting...");
        $('select[name="kec"]').html("<option value=''>Pilih Kecamatan</option>");
        $.post("<?php echo base_url(); ?>admin/get_kabkot",{id_prov:$(e.target).val()},function(data){
          $('select[name="kabkot"]').html("<option value=''>Pilih Kabupaten/Kota</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="kabkot"]').append("<option value='"+item[i].id+"'>"+item[i].kabkot+"</option>");
          }
        });
      }
      function get_kec(e){
        $('select[name="kec"]').html("Waiting...");
        $.post("<?php echo base_url(); ?>admin/get_kec",{id_kabkot:$(e.target).val()},function(data){
          $('select[name="kec"]').html("<option value=''>Pilih Kecamatan</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="kec"]').append("<option value='"+item[i].id+"'>"+item[i].kecamatan+"</option>");
          }
        });
      }
        $(document).ready(function(){
         
         $('.filter-text').keypress(function(e){
            var txt = String.fromCharCode(e.which);
            //console.log(txt + ' : ' + e.which);
            if(!txt.match(/[A-Za-z0-9+#., -]/)&&e.which!=8) 
            {
                return false;
            }
         });
         $('.filter-text-permalink').keypress(function(e){
                          var txt = String.fromCharCode(e.which);
                          //console.log(txt + ' : ' + e.which);
                          if(!txt.match(/[a-z0-9-]/)&&e.which!=8) 
                          {
                              return false;
                          }
                       });
         $('.filter-number').keypress(function(e){
            var txt = String.fromCharCode(e.which);
            //console.log(txt + ' : ' + e.which);
            if(!txt.match(/[0-9+#.]/)&&e.which!=8) 
            {
                return false;
            }
         });
         $("#datemasktgl").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
         $("#datemasktlp").inputmask();
   });
      </script>