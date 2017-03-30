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
    width:200px;
}

</style>
<div class="row">
 
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datapribadi" data-toggle="tab">Input Data</a></li>
              <li><a href="#datatoko" data-toggle="tab">Data Masuk</a></li>
              <!--
              <li><a href="#datatoko" data-toggle="tab">Data Toko</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
              -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="datapribadi">
              <div class="panel">
              <?php echo form_open("admin/simpanta",array("class"=>"panel-body","id"=>"formbio","onsubmit"=>"return validation_bio()"));   
              ?>
                <div class="col-md-12">
                    <div class="row">
                      <fieldset>
                      <legend>Form Tahun Ajaran</legend>
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
              
                  <div class="form-group col-md-3">
                    <label>Tahun Ajaran</label>
                    <input type="number" required class="form-control filter-number" name="tahun" placeholder="Input Tahun" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Periode</label>
                    <select class="form-control" required name="periode">
                      <option value="">Periode</option>
                      <option value="Genap">Genap</option>
                      <option value="Ganjil">Ganjil</option>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="button" onclick="simpanbio()" class="btn btn-primary">Simpan</button>
                  </div>
                 
                  </fieldset>
                    </div>
                  </div>
                  
                <?php echo form_close(); ?>
                </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="datatoko">
                <div class="panel">
                <div class="panel-body">
                  <div class="col-md-12">
                    <div class="row">
                     <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th align="center" width="10%">No</th>
                  <th>Tahun Ajaran</th>
                  <th>Periode</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $ta=$ta->result();
                $x=1;
                foreach ($ta as $key) {
                ?>
                  <tr>
                    <td align="center"><?php echo $x; ?></td>
                    <td><?php echo $key->tahun; ?></td>
                    <td><?php echo $key->periode; ?></td>
                    <td><?php echo $key->status; ?></td>
                    <td>
                      <?php  
                      if($key->status=="Aktif"){
                        ?>
                        <button class="btn btn-warning btn-xs">Ta Aktif</button>
                        <?php
                      }else{
                        ?>
                        <button class="btn btn-default btn-xs" data-id="<?php echo $key->id; ?>" onclick="aktifkan_ta(event)">Set Aktif</button>    
                        <?php
                      }
                      ?>
                      

                      <button class="btn btn-danger btn-xs" data-id="<?php echo $key->id; ?>" onclick="hapus_ta(event)">Hapus</button>
                    </td>  
                  </tr>
                <?php
                $x++;
                }
                ?>
                </tbody>
              </table>
                    </div>
                  </div>
                  </div>
                  </div>
                </div>
                <!--
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
      <div id="aktivasi">
      <?php echo form_open("admin/tahunajaran"); ?>
      <input type="hidden" name="id_ta" id="id_ta"><button class="btn btn-warning" type="submit">
      Aktifkan</button>
      <?php echo form_close(); ?>
      </div>
      <div id="hapusta">
      <?php echo form_open("admin/tahunajaran"); ?>
      <input type="hidden" name="id_tahapus" id="id_ta"><button class="btn btn-danger" type="submit">
      Aktifkan</button>
      <?php echo form_close(); ?>
      </div>
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
   $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });     
   function aktifkan_ta(e){
    var id_ta=$(e.target).attr("data-id");
    $("#aktivasi #id_ta").val(id_ta);
    $("#showingmodal .modal-body").html($("#aktivasi").html());
    $("#showingmodal").modal("show");
   }
   function hapus_ta(e){
    var id_ta=$(e.target).attr("data-id");
    $("#hapusta #id_ta").val(id_ta);
    $("#showingmodal .modal-body").html($("#hapusta").html());
    $("#showingmodal").modal("show");
   }
      </script>
   
