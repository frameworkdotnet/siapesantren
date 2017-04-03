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
              
          <div class="nav-tabs-custom">
            
            <ul class="nav nav-tabs">
              
              <li class="active"><a href="#datapribadi" data-toggle="tab">Input Data</a></li>
              <li><a href="#datatoko" data-toggle="tab">Data Masuk</a></li>
          
            </ul>
            <div class="tab-content">
              <?php  
                if($role=="plotingsantri"){
              ?>
              <div class="active tab-pane" id="datapribadi">
              <div class="panel">
              <?php echo form_open("admin/kbm/simpanplotingsantri",array("class"=>"panel-body","id"=>"formbio","onsubmit"=>"return validation_bio()"));   
              ?>
                <div class="col-md-12">
                    <div class="row">
                      <fieldset>
                      <legend>Ploting Program Penawaran Santri</legend>
                    <div class="form-group col-md-6">
                      
                    </div>
                  <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary">Simpan</button>
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
    
                    </div>
                  </div>
                  </div>
                  </div>
                </div>
                <?php
                }else if($role=="mapel"){
                  ?>
                  <div class="active tab-pane" id="datapribadi">
                    <div class="panel">
            <?php echo form_open("admin/penawaran/simpanmapel",array("class"=>"panel-body","id"=>""));   
              ?>
                  <div class="col-md-12">
                      <div class="row">
                        <fieldset>
                        <legend>Mapel Program Penawaran</legend>    
                   <div class="col-md-6"> 
                    <div class="form-group">
                      <label>Program Penawaran</label>
                      <select class="form-control" name="id_penawaran">
                        <option value="">Pilih Program Penawaran</option>
                        <?php  
                          $penawaran=$penawaran->result();
                          foreach ($penawaran as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>"><?php echo $key->penawaran; ?></option>
                            <?php
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <button type="button" onclick="plus_mapel(event)" class="btn btn-warning btn-sm">Tambah Mapel</button>
                    </div>
                    <div id="mapelplus">

                    </div>
                   </div> 
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                   
                    </fieldset>
                      </div>
                    </div>
                  <script type="text/javascript">
                  var x=1;
                  function plus_mapel(){
                    if($('select[name="id_penawaran"]').val()!=""&&x<=10){
                      $("#mapelplus").append('<div class="form-group col-md-6">'+
                      '<label>Nama Mapel Penawaran '+x+'</label>'+
                      '<input type="text" class="form-control" name="mapel_penawaran[]" maxlength="50" placeholder="Nama mapel">'+
                    '</div>'+
                    '<div class="form-group col-md-3">'+
                    '<label>Batas KKM '+x+'</label>'+
                    '<input type="number" class="form-control" name="mapel_kkm[]" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="3" placeholder="kkm" >'+
                    '</div>');
                      x++;
                      }
                  }
                  </script>
                <?php echo form_close(); ?>
                    </div>
                  </div>
                  <div class="tab-pane" id="datatoko">
                    <div class="panel">
                    <div class="panel-body">
                  <div class="col-md-12">
                    <div class="row">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th align="center" width="10%">No</th>
                  <th>Program Penawaran</th>
                  <th>Mapel</th>
                  <th>Standar KKM</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $mapel=$mapel->result();
                $x=1;
                foreach ($mapel as $key) {
                ?>
                  <tr>
                    <td align="center"><?php echo $x; ?></td>
                    <td><?php echo $key->penawaran; ?></td>
                    <td><?php echo $key->nama_mapel; ?></td>
                    <td><?php echo $key->standar_kkm; ?></td>
                    <td>
                      <button class="btn btn-warning btn-xs" data-id="<?php echo $key->id_mapel; ?>" onclick="edit_mapel(event)">Edit</a>&nbsp
                      <button class="btn btn-danger btn-xs" data-id="<?php echo $key->id_mapel; ?>" onclick="hapus_mapel(event)">Hapus</button>
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
                  <?php
                } 
                ?>
              
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
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
  
      </script>