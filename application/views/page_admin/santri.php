<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

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
    width:100px;
}

</style>
<div class="row">
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
        <div class="col-md-12">
        <div class="box box-info">
        <div class="box-body">
          <div class="nav-tabs-custom ">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datapribadi" data-toggle="tab">Data Diri</a></li>
              <li><a href="#datatoko" data-toggle="tab">Alamat</a></li>
              <li><a href="#settings" data-toggle="tab">Orang Tua</a></li>
              <!--
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
              -->
            </ul>
            <?php echo form_open("admin/santri/daftar",array("id"=>"formSantri","class"=>"panel-body","id"=>"formbio","onsubmit"=>"return validation_bio()")); ?>
            <div class="tab-content">
              <div class="active tab-pane" id="datapribadi">
              <div class="panel">              
                <div class="col-md-8">
                    <div class="row">
                      <fieldset>
                      <legend>Data Diri</legend> 
                  <div class="form-group col-md-8">
                    <label>NIS</label>
                    <input type="text" class="form-control filter-number" name="nis" placeholder="Nomor Induk Santri" required>
                  </div>
                  <div class="form-group col-md-8">
                    <label>Nama Santri</label>
                    <input type="text" class="form-control filter-text" name="nama" placeholder="Nama Santri" required>
                  </div>
                  <div class="form-group col-md-8">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="jenkel">
                      <option value="Pria">Laki-laki</option>
                      <option value="Wanita">Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group col-md-8">
                    <label>Agama</label>
                    <select class="form-control" name="agama">
                      <option value="Islam" selected>Islam</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                  </div>
                  <div class="form-group col-md-6">
                    <label>No Hp</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" class="form-control" id="datemasktlp" name="no_hp" data-inputmask="'mask': ['999-999-999-999', '+6299-999-999-999']" data-mask>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tempat Lahir</label>
                    <input type="text" class="form-control filter-text" name="tmp_lhr" placeholder="Kota Lahir">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Tanggal Lahir</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input required type="text" id="datemasktgl" class="form-control" name="tgl_lhr" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                    </div>
                  </div>
                  </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="datatoko">
                <div class="panel">              
                <div class="col-md-8">
                    <div class="row">
                      <fieldset>
                      <legend>Alamat</legend> 
                  <div class="form-group col-md-6">
                    <label>Provinsi</label>
                    <select class="form-control" name="prov" onchange="get_kabkot(event)">
                      <option value="">Pilih Provinsi</option>
                            <?php 
                              $prov=$prov->result();
                              foreach ($prov as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?></option>
                                <?php
                              }
                            ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Kabupaten/Kota</label>
                    <select class="form-control" name="kabkot" onchange="get_kec(event)">
                      <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Kecamatan</label>
                    <select class="form-control" name="kec" onchange="get_desa(event)">
                      <option value="">Pilih Kecamatan</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Desa</label>
                    <select class="form-control" name="desa">
                      <option value="">Pilih Desa</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label>RT</label>
                    <input type="text" class="form-control filter-number" name="rt" placeholder="RT">
                  </div>
                  <div class="form-group col-md-4">
                    <label>RW</label>
                    <input type="text" class="form-control filter-number" name="rw" placeholder="RW">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Kodepos</label>
                    <input type="text" class="form-control filter-number" name="kodepos" placeholder="Kodepos">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Keterangan Tambahan</label>
                    <textarea class="form-control filter-text" name="ket_lain" placeholder="Misal : Nama Jalan, Nomor Rumah"></textarea>

                  </div>
                  </fieldset>
                    </div>
                  </div>
                </div>
              </div>  
              <div class="tab-pane" id="settings">
                <div class="panel">              
                <div class="col-md-8">
                    <div class="row">
                      <fieldset>
                      <legend>Orang Tua</legend> 
                  
                  <div class="form-group col-md-6">
                    <label>Nama Ayah</label>
                    <input type="text" class="form-control filter-text" name="namaayah" placeholder="Nama Ayah">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Nama Ibu</label>
                    <input type="text" class="form-control filter-text" name="namaibu" placeholder="Nama Ibu">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Pekerjaan Ayah</label>
                    <input type="text" class="form-control filter-text" name="workayah" placeholder="Pekerjaan Ayah">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Pekerjaan Ibu</label>
                    <input type="text" class="form-control filter-text" name="workibu" placeholder="Pekerjaan Ibu">
                  </div>
                  <div class="form-group col-md-6">
                    <label>No Hp Ortu</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" id="hportu" class="form-control filter-text" name="hportu" data-inputmask="'mask': ['999-999-999-999', '+6299-999-999-999']" data-mask>
                    </div>
                  </div>
                  </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              </div>

             </div>
              <!-- /.tab-pane -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Simpan</button>
            </div>
          </div>
            <!-- /.tab-content -->

          </div>
          <!-- /.nav-tabs-custom -->
          
              <?php echo form_close(); ?>
        </div>

        <!-- /.col -->
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?php echo base_url() ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
      <script type="text/javascript">
      function validation_bio(){
        return true;
      }
      function simpanformsantri(){
       //var $myForm = $('#formSantri');
        $("#formSantri").submit();
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
        $('select[name="desa"]').html("<option value=''>Pilih Desa</option>");
        $.post("<?php echo base_url(); ?>admin/get_kabkot",{id_prov:$(e.target).val()},function(data){
          $('select[name="kabkot"]').html("<option value=''>Pilih Kabupaten/Kota</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="kabkot"]').append("<option value='"+item[i].id+"'>"+item[i].name+"</option>");
          }
        });
      }
      function get_kec(e){
        $('select[name="kec"]').html("Waiting...");
        $('select[name="desa"]').html("<option value=''>Pilih Desa</option>");
        $.post("<?php echo base_url(); ?>admin/get_kec",{id_kabkot:$(e.target).val()},function(data){
          $('select[name="kec"]').html("<option value=''>Pilih Kecamatan</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="kec"]').append("<option value='"+item[i].id+"'>"+item[i].name+"</option>");
          }
        });
      }
      function get_desa(e){
        $('select[name="desa"]').html("Waiting...");
        $.post("<?php echo base_url(); ?>admin/get_desa",{id_kec:$(e.target).val()},function(data){
          $('select[name="desa"]').html("<option value=''>Pilih Desa</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="desa"]').append("<option value='"+item[i].id+"'>"+item[i].name+"</option>");
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
         $("#hportu").inputmask();
   });

   function edit_penawaran(e){
    var id=$(e.target).attr("data-id");
    $("#edit #id_penawaran").val(id);
    $("#showingmodal .modal-body").html($("#edit").html());
    $("#showingmodal").modal("show");
   }
   function hapus_penawaran(e){
    var id=$(e.target).attr("data-id");
    $("#hapusta #id_penawaran").val(id);
    $("#showingmodal .modal-body").html($("#hapusta").html());
    $("#showingmodal").modal("show");
   }
      </script>
    <div id="edit" class="hide">
      <?php echo form_open("admin/penawaran"); ?>
      <input type="hidden" name="id_penawaranedit" id="id_penawaran">
      <label>Program Penawaran</label>
      <div class="form-group">
        <input type="text" name="penawaran" class="form-control">
      </div>
      <div class="form-group">
      <button class="btn btn-warning" type="submit">
      Edit</button>
      </div>
      <?php echo form_close(); ?>
    </div>
    <div id="hapusta" class="hide">
      <?php echo form_open("admin/penawaran"); ?>
      <input type="hidden" name="id_penawaranhapus" id="id_penawaran"><button class="btn btn-danger" type="submit">
      Hapus</button>
      <?php echo form_close(); ?>
    </div>
