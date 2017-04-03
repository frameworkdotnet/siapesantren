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
        <div class="panel">
        <div class="panel-body">
          <div class="nav-tabs-custom ">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datapribadi" data-toggle="tab">Data Kategori Nilai</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="datapribadi">
              <div class="panel">              
                <div class="col-md-12">
                    <div class="row">
             <?php  
              if(isset($role)&&$role=="input"){
                echo form_open("admin/penawaran/mapel/insertkategoriaction");
                ?>
                <div class="form-group">
                  <input type="hidden" name="id_mapel" value="<?php echo $idmapel; ?>">
                      <button type="button" onclick="plus_mapel(event)" class="btn btn-warning btn-sm">Tambah Kategori</button>
                    </div>
                    <div id="mapelplus">

                    </div>
                   </div> 
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <script type="text/javascript">
                  var x=1;
                  function plus_mapel(){
                      $("#mapelplus").append('<div class="form-group col-md-6">'+
                      '<label>Nama kategori_penilaian '+x+'</label>'+
                      '<input type="text" class="form-control" name="kategori_penilaian[]" maxlength="50" placeholder="Nama Kategori">'+
                    '</div>');
                      x++;
                  }
                  </script>
                <?php
                echo form_close();
              }else if(isset($role)&&$role=="edit"){
                echo form_open("admin/penawaran/makul/editkategoriaction");
                ?>
                <div class="form-group">
                  <input type="hidden" name="id_mapel" value="<?php echo $idmapel; ?>">
                      <button type="button" onclick="plus_mapel(event)" class="btn btn-warning btn-sm">Tambah Kategori</button>
                    </div>
                    <div id="mapelplus">
                      <?php  
                      $x=1;
                      $kategori=$kategori->result();
                       foreach ($kategori as $key) {
                         ?>
                         <div class="form-group col-md-6">
                          <label>Nama kategori_penilaian <?php echo $x; ?></label>
                          <input type="text" value="<?php echo $key->nama_kategori; ?>" class="form-control" name="kategori_penilaian[<?php echo $key->kategori_id; ?>]" maxlength="50">
                        </div>
                         <?php
                         $x++;
                       }
                      ?>
                    </div>
                   </div> 
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <script type="text/javascript">
                  var x=<?php echo $x; ?>;
                  function plus_mapel(){
                      $("#mapelplus").append('<div class="form-group col-md-6">'+
                      '<label>Nama kategori_penilaian '+x+'</label>'+
                      '<input type="text" class="form-control" name="kategori_penilaian[]" maxlength="50" placeholder="Nama Kategori">'+
                    '</div>');
                      x++;
                  }
                  </script>
                <?php
                echo form_close();
              }else{
                ?>
                         
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th align="center" width="5%">No</th>
                  <th>Program Penawaran</th>
                  <th>Mapel</th>
                  <th>Kategori Nilai</th>
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
                    <td><?php  
                      $kategori=$this->Model_admin->get_kategori_nilai($key->id_mapel);
                      $kategori=$kategori->result();
                      foreach ($kategori as $key) {
                        echo $key->nama_kategori.",";
                      }
                    ?></td>
                    <td>
                      <a class="btn btn-primary btn-xs" data-id="<?php echo $key->id; ?>" href="<?php echo base_url(); ?>admin/penawaran/mapel/inputkategori/<?php echo $this->urlenkripsi->encode_url($key->id_mapel); ?>">Input</a>
                      <a class="btn btn-warning btn-xs" data-id="<?php echo $key->id; ?>" href="<?php echo base_url(); ?>admin/penawaran/mapel/editkategori/<?php echo $this->urlenkripsi->encode_url($key->id_mapel); ?>">Edit</a>
                      <a class="btn btn-danger btn-xs" data-id="<?php echo $key->id; ?>" onclick="hapus_kategori(event)">Hapus</a>
                    </td>  
                  </tr>
                <?php
                $x++;
                }
                ?>
                </tbody>
              </table>
              <?php
              }
             ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              </div>

             </div>
              <!-- /.tab-pane -->
            </div>
            <div class="box-footer">
            
            </div>
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
   function hapus_kategori(e){
    var id=$(e.target).attr("data-id");
    $("#hapusta #id_kategorinilai").val(id);
    $("#showingmodal .modal-body").html($("#hapusta").html());
    $("#showingmodal").modal("show");
   }
      </script>
    <div id="hapusta" class="hide">
      <?php echo form_open("admin/penawaran"); ?>
      <input type="hidden" name="id_kategorinilai" id="id_kategorinilai"><button class="btn btn-danger" type="submit">
      Hapus</button>
      <?php echo form_close(); ?>
    </div>
