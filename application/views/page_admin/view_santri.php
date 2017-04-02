<?php  
  if(isset($sethapus)&&$sethapus==true){
    ?>
    <b>Yakin Hapus ?</b>
    <br>
    <?php echo form_open("admin/santri/hapusaction/".$this->urlenkripsi->encode_url($santri->nis)); ?>
      <div class="form-group">
        <input type="hidden" name="nis" value="<?php echo $santri->nis; ?>">
        <button class="btn btn-danger" type="submit">Hapus</button>
      </div>  
    </form>
    <?php
    //die;
  }else{
    ?>
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
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th align="center" width="7%">No</th>
                  <th align="center" width="10%">NIS</th>
                  <th>Nama</th>
                  <th align="center" width="7%">Jenis Kelamin</th>
                  <th align="center" width="15%">Tempat/Tgl Lahir</th>
                  <th align="left" width="15%">No Hp</th>
                  <th align="left" width="10%">Aksi</th>
                </tr>
                </thead>
                <?php  
                $x=1;
                $santri=$santri->result();
                ?>
                <tbody>
                <?php  
                  foreach ($santri as $key) {
                    ?>
                    <tr>
                      <td><?php echo $x; ?></td>
                      <td><?php echo $key->nis; ?></td>
                      <td><?php echo $key->nama; ?></td>
                      <td><?php echo $key->jenkel; ?></td>
                      <td><?php echo $key->tmp_lhr.", ".todate($key->tgl_lhr,false); ?></td>
                      <td><?php echo $key->nohp; ?></td>
                      <td>
                        <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>admin/santri/edit/<?php echo $this->urlenkripsi->encode_url($key->nis); ?>">Edit</a>
                        <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>admin/santri/hapus/<?php echo $this->urlenkripsi->encode_url($key->nis); ?>">Hapus</a>
                      </td>
                    </tr>
                    <?php
                  $x++;
                  }
                ?>
                </tbody>
              </table>
              <?php echo $pagination; ?>          
        </div>
        <div class="box-footer"></div>
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
        $('select[name="kab"]').html("Waiting...");
        $('select[name="kec"]').html("<option value=''>Pilih Kecamatan</option>");
        $('select[name="desa"]').html("<option value=''>Pilih Desa</option>");
        $.post("<?php echo base_url(); ?>admin/get_kabkot",{id_prov:$(e.target).val()},function(data){
          $('select[name="kab"]').html("<option value=''>Pilih Kabupaten/Kota</option>");
          var item=JSON.parse(data);
          for(var i=0;i<item.length;i++){
            $('select[name="kab"]').append("<option value='"+item[i].id+"'>"+item[i].name+"</option>");
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
         $("#rtrw").inputmask("999/999", {"placeholder": "RT /RW "});
         $("#datemasktlp").inputmask();
         $("#hportu").inputmask();
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
<?php
  }
?>