<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<div class="row">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <?php 
            if(isset($editbarang)){
              $editbarang=$editbarang->result();
              foreach ($editbarang as $key) {
                $editbarang=$key;
              }
              ?>
              <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
              <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
              <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/taginput/jquery.tagsinput.css" />
              <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/taginput/jquery.tagsinput.js"></script>
              <style type="text/css">
              .drop-area
              {
                text-align: center;
                vertical-align: middle;
                line-height: 90px;
                height:100px;
                background-color:white;
                border:3px dashed grey;
                margin-bottom: 5px;
              }
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
                    width:240px;
                }
                .drop-area:hover{
                  color:red;
                  cursor: pointer;
                }
                img {
                    max-height: 100%;
                    width:100%;
                }
              </style>
              <div class="box-header">
              <i class="<?php echo $breadcumbparenticon; ?>"></i>
              <h3 class="box-title"><?php echo $subtitle2; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php echo form_open('admin/edit_barang',array("id"=>"formbarang","method"=>"post","enctype"=>"multipart/form-data")); ?>
                <div class="col-md-5">
                <div class="row">
                <div class="form-group">
                <label>Nama Toko Anda</label>
                  <?php  
                    $toko=$this->Model_admin->get_toko_by_member($this->session->userdata("id_member"));
                    $toko=$toko->result();
                  ?>
                  <select class="form-control" name="id_toko" required>
                     <option value="">Pilih Toko</option>
                     <?php
                      foreach ($toko as $key) {
                        ?>
                        <option value="<?php echo $key->id_toko; ?>" <?php echo $key->id_toko==$editbarang->id_toko?'selected':''; ?>><?php echo $key->nama_toko; ?></option>
                        <?php
                      }
                     ?> 
                  </select>
                </div>
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#barang1" data-toggle="tab">Barang</a></li>
              <li><a href="#barang2" data-toggle="tab">Rincian Barang</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="barang1">
                <div class="form-group">
                <label>Nama Barang : </label>
                  <input class="form-control filter-text" name="nama_barang" value="<?php echo $editbarang->nama_brg; ?>" type="text" required>
                </div>  
                <div class="form-group">
                <label>Kategori : </label>
                <select class="form-control select2" multiple="multiple" required name="kategori_barang[]" data-placeholder="pilih kategori barang" style="width: 100%;">
                  <?php  
                  $kat=$this->Model_admin->get_kategori_by_coma_separator($editbarang->kategori);
                  $kat=$kat->result();
                  foreach ($kat as $key) {
                    ?>
                     <option value="<?php echo $key->id; ?>"><?php echo $key->kategori; ?></option> 
                    <?php
                  }
                  ?>
                </select>
              </div>
              <label>Harga : </label>
              <div class="form-group input-group">     
                <span class="input-group-addon">Rp. </span>
                <input class="form-control filter-number" name="harga_barang" value="<?php echo $editbarang->harga; ?>" type="text" required>
                <span class="input-group-addon"> , 00</span>
              </div>  
              <label>Jumlah Stock Barang : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="stok_barang" value="<?php echo $editbarang->stock; ?>" type="text" required>
                <span class="input-group-addon"> Item</span>
              </div>
              <div class="form-group">
                <label>Status : </label>
                  <select class="form-control" name="status_barang" required>
                    <option value="">Status Barang</option>
                    <option value="1" <?php echo $editbarang->status==1?'selected':'' ?>>Tersedia</option>
                    <option value="0" <?php echo $editbarang->status==0?'selected':'' ?>>Belum Tersedia</option>
                  </select>
              </div>         
              <div class="form-group">
                <label>Kondisi Barang : <small>(sertakan kondisi barang yang anda jual)</small> </label>
                  <select class="form-control" name="kondisi" required>
                    <option value="">Kondisi Barang</option>
                    <option value="Baru" <?php echo $editbarang->kondisi=="Baru"?'selected':'' ?>>Baru</option>
                    <option value="Bekas" <?php echo $editbarang->kondisi=="Bekas"?'selected':'' ?>>Bekas</option>
                    <option value="Rusak" <?php echo $editbarang->kondisi=="Rusak"?'selected':'' ?>>Rusak</option>
                    <option value="LainLain" <?php echo $editbarang->kondisi=="LainLain"?'selected':'' ?>>Tanyakan pada penjual</option>
                  </select>
              </div>
              </div>
              <div class="tab-pane" id="barang2">
                <label>Berat : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" value="<?php echo $editbarang->berat; ?>" name="berat" type="text">
                <span class="input-group-addon"> gram</span>
              </div> 
              <label>Panjang : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" value="<?php echo $editbarang->panjang; ?>" name="panjang" type="text">
                <span class="input-group-addon"> Cm</span>
              </div> 
              <label>Lebar : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" value="<?php echo $editbarang->lebar; ?>" name="lebar" type="text">
                <span class="input-group-addon"> Cm</span>
              </div>
              <label>Tinggi : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="tinggi" value="<?php echo $editbarang->tinggi; ?>" type="text">
                <span class="input-group-addon"> Cm</span>
              </div>  
              <div class="form-group">
                <label>Link Video : <small>(Bisa di isi URL youtube video review produk anda)</small> </label>
                 <input type="url" class="form-control" value="<?php echo $editbarang->video; ?>" name="video_barang">
              </div>
              <div class="form-group">
                    <label>Link Website : <small>(Bisa di isi URL website review produk anda)</small> </label>
                     <input type="url" class="form-control" value="<?php echo $editbarang->web_review; ?>" name="web_review">
                  </div>
              </div>  
              </div>
</div>              
              </div>
              </div>
              <div class="col-md-7">
              
              <fieldset>
              <legend>Pengaturan pada Search Engine</legend>
              <div class="form-group">
                <label>Judul SEO : <small>(Judul yang tertera pada hasil pencarian search engine)</small></label>
                 <input type="text" class="form-control filter-text" maxlength="60" value="<?php echo $editbarang->title_seo; ?>" name="title_seo">
              </div>
              <div class="form-group">
                <label>Permalink SEO : <small>(Custom Link untuk SEO)</small></label>
                 <input type="text" class="form-control filter-text-permalink" maxlength="255" value="<?php echo $editbarang->permalink; ?>" name="permalink">
              </div>
              <div class="form-group">
                <label>Deskripsi SEO : </label>
                 <textarea class="form-control filter-text" maxlength="160" name="deskripsi_barang" style="height:106px;" required><?php echo $editbarang->deskripsi; ?></textarea>
              </div>
              <div class="form-group">
                <label>Keyword SEO : <small>(Pisah dengan koma ex : jual mobil sedan, mobil sedan antik)</small></label>
                 <input type="text" class="form-control filter-text" id="tag_barang1" data-role="tagsinput" maxlength="160" value="<?php echo $editbarang->keyword; ?>" name="keyword_barang">
              </div>
              <div class="form-group">
                <label>Tag : <small>(Pisah dengan koma ex : mobil,motor)</small> </label>
                 <input type="text" class="form-control filter-text" data-role="tagsinput" value="<?php echo $editbarang->tag; ?>" id="tag_barang" name="tag_barang">
              </div>
              </fieldset>                 
              </div>
              <div class="row">
              <div class="col-md-12">
              <label>Gambar Produk : <br><small><u><i>Format : (PNG/JPG/JPEG), Max Size : (500kb) Max Height/Width : (768/768 pixel)</i></u></small></label>
              <div class="form-group">
              <br>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage1" data-index="1" img-name="image1">
            <?php 
            if($editbarang->gambar_1==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_1); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro1" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image1" name="image1" onchange="fileclickupload(this,'1');" class="hide">
          <input type="hidden" id="file1" name="file1" value="<?php echo $editbarang->gambar_1; ?>"><br>
          <div onclick="hapusimg(event)" id="hps1" class="<?php echo $editbarang->gambar_1==NULL?'hide':''; ?>"><span data-id="1" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage2" data-index="2" img-name="image2">
            <?php 
            if($editbarang->gambar_2==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_2); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro2" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image2" name="image2" onchange="fileclickupload(this,'2');" class="hide">
          <input type="hidden" id="file2" name="file2" value="<?php echo $editbarang->gambar_2; ?>"><br>
          <div onclick="hapusimg(event)" id="hps2" class="<?php echo $editbarang->gambar_2==NULL?'hide':''; ?>"><span data-id="2" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage3" data-index="3" img-name="image3">
            <?php 
            if($editbarang->gambar_3==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_3); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro3" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image3" name="image3" onchange="fileclickupload(this,'3');" class="hide">
          <input type="hidden" id="file3" name="file3" value="<?php echo $editbarang->gambar_3; ?>"><br>
          <div onclick="hapusimg(event)" id="hps3" class="<?php echo $editbarang->gambar_3==NULL?'hide':''; ?>"><span data-id="3" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div> 
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage4" data-index="4" img-name="image4">
            <?php 
            if($editbarang->gambar_4==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_4); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro4" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image4" name="image4" onchange="fileclickupload(this,'4');" class="hide">
          <input type="hidden" id="file4" name="file4" value="<?php echo $editbarang->gambar_4; ?>"><br>
          <div onclick="hapusimg(event)" id="hps4" class="<?php echo $editbarang->gambar_4==NULL?'hide':''; ?>"><span data-id="4" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage5" data-index="5" img-name="image5">
            <?php 
            if($editbarang->gambar_5==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_5); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro5" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image5" name="image5" onchange="fileclickupload(this,'5');" class="hide">
          <input type="hidden" id="file5" name="file5" value="<?php echo $editbarang->gambar_5; ?>"><br>
          <div onclick="hapusimg(event)" id="hps5" class="<?php echo $editbarang->gambar_5==NULL?'hide':''; ?>"><span data-id="5" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage6" data-index="6" img-name="image6">
            <?php 
            if($editbarang->gambar_6==NULL){
              ?>
              Click to Add Image
              <?php
            }else{
              ?>
              <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$editbarang->gambar_6); ?>" class="img-thumbnail img-responsive">
              <?php
            }
            ?>
          </div>
          <div class="progress progress-bar" id="pro6" style="width: 0%;height:8px;margin-bottom: auto;"></div> 
          <input type="file" id="image6" name="image6" onchange="fileclickupload(this,'6');" class="hide">
          <input type="hidden" id="file6" name="file6" value="<?php echo $editbarang->gambar_6; ?>"><br>
          <div onclick="hapusimg(event)" id="hps6" class="<?php echo $editbarang->gambar_6==NULL?'hide':''; ?>"><span data-id="6" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>

        </div>
        <!-- ./col -->
      </div>


      </div>
              </div>
              <div class="col-md-12" style="margin-top: 10px">
              <br>
              <div class="row">
                <div class="form-group">
                <label>Deskripsi Barang : </label>
                  <textarea class="textarea" name="keterangan_barang" placeholder="Place some text here" style="width: 100%; height: 245px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $editbarang->keterangan; ?></textarea>
                </div> 
                </div>
              </div>
              <input type="hidden" name="id_barang" value="<?php echo $editbarang->id_barang; ?>">
              <input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <?php echo form_close(); ?>
              <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
              <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
              <script type="text/javascript">
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
                    
                    var value_kategori='<?php echo $editbarang->kategori; ?>';
                    value_kategori=value_kategori.split(",");
                    $('.select2').select2({
                      ajax: {
                        url: "<?php echo base_url(); ?>admin/get_kategori",
                        method: 'POST',
                        data: function (params) {
                          return {
                            q: params.term
                          };
                        },
                        cache: false,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data, params) {
                          return {
                            results: data,
                            more: false
                          };
                        }
                      }
                    });
                    $('.select2').val(value_kategori).trigger('change');

                    $(".textarea").wysihtml5();
                    $('#tag_barang').tagsInput({width:'auto'});
                    $('#tag_barang1').tagsInput({width:'auto'});
                 });   
                function hapusimg(e,edit){
                  if($(e.target).attr('data-id')!=undefined){
                    var id=$(e.target).attr('data-id');
                    var file=$('#file'+id).val();
                    if(id!=undefined){
                      $.post('<?php echo base_url(); ?>admin/remove_image',{file:file,edit:"1",gambar_ke:id,id_barang:'<?php echo $editbarang->id_barang; ?>'},function(data,status){
                        if(status=="success"){
                          var result=JSON.parse(data);
                          if(result.status){
                            alert("gambar "+result.message+" terhapus");
                            $('#Timage'+id).html("Click to Add Image");
                            $('#pro'+id).css("width","0%");
                            $('#hps'+id).addClass("hide");
                            $('#file'+id).val("");
                          }else{
                            alert("gagal menghapus gambar karena : "+result.message);
                            $('#Timage'+id).html("Click to Add Image");
                            $('#pro'+id).css("width","0%");
                            $('#hps'+id).addClass("hide");
                            $('#file'+id).val("");
                          }
                        }else{
                          alert("gagal koneksi dengan server");
                        }
                      });                
                    }
                  }
                }
                function fileclickupload(e,id){
                  var image = e.files;
                  createFormData(image,id);
                  e.value=null;
                }
                function createFormData(image,id)
                {
                 var formImage = new FormData();
                 formImage.append('file', image[0]);
                 uploadFormData(formImage,id);
                }
                function uploadFormData(formData,id) 
                {
                var hasil="";
                $.ajax({
                        type:'POST',
                        url: '<?php echo base_url(); ?>admin/upload_image/1',
                        data:formData,
                        xhr: function() {
                                var myXhr = $.ajaxSettings.xhr();
                                if(myXhr.upload){
                                    myXhr.upload.addEventListener('progress',function(e){
                                      if(e.lengthComputable){
                                          var max = e.total;
                                          var current = e.loaded;
                                          var Percentage = (current * 100)/max;
                                          console.log(Percentage);
                                          if(Percentage >= 100)
                                          {
                                             $('#pro'+id).css("width",Percentage+"%"); 
                                          }
                                      } 
                                    }, false);
                                }
                                return myXhr;
                        },
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(data){
                          var result=JSON.parse(data);
                          //alert($('#'+id).attr("img-name")+result.message);
                          if(result.status){
                            $('#Timage'+id).html("");
                            $('#Timage'+id).append('<img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/'+result.message+'" class="img-thumbnail img-responsive">');
                            $('#hps'+id).removeClass("hide");
                            $('#file'+id).val(result.message);
                          }else{
                            alert("image not allow, check requirement");
                            $('#Timage'+id).html("Drop to Add Image");
                            $('#pro'+id).css("width","0%");
                          }
                          
                        },

                        error: function(data){
                          
                        }
                    });
                }
                $(document).ready(function()
                {
                 $(".drop-area").on('click', function (e){
                  if($('#file'+$(e.target).attr('data-index')).val()==""){
                    $('#'+$(this).attr("img-name")).click();
                  }else{
                    alert("Hapus gambar terlebih dahulu");
                  }
                 });
                });
                function submit(){
                  submitting=true;
                  $("#formbarang").submit();
                }
                var submitting = false;
                window.onbeforeunload = function (e) {
                    if (submitting)
                    {
                        return;
                    }


                    var message = "Die eingegebenen Formulardaten werden aus Sicherheitsgründen nicht gespeichert und gehen beim Verlassen des Formulars verloren! Sind Sie sicher, dass Sie die Formularseite verlassen möchten?";

                    var e = e || window.event;

                    // For IE and Firefox prior to version 4
                    if (e) {
                        e.returnValue = message;
                    }

                    // For Safari
                    return message;
                };
              </script>
            </div>
            <div class="box-footer clearfix">
               <input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <button type="button" onclick="submit()" class="pull-right btn btn-primary">Simpan Barang
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
              <?php
            }else{
              ?>
            <div class="box-header">
              <i class="<?php echo $breadcumbparenticon; ?>"></i>
              <h3 class="box-title"><?php echo $subtitle2; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Id Barang</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Stok</th>
                  <th>Kondisi</th>
                  <th>Harga</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $barang=$barang->result();
                $x=1;
                foreach ($barang as $key) {
                ?>
                  <tr>
                    <td align="center"><?php echo $x; ?></td>
                    <td align="center"><?php 
                          if($key->gambar_1!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_1); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          }else if($key->gambar_2!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_2); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          }else if($key->gambar_3!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_3); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          }else if($key->gambar_4!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_4); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          }if($key->gambar_5!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_5); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          }else if($key->gambar_6!=NULL){
                            ?>
                            <img src="<?php echo base_url(); ?>assets/upload/<?php  echo $this->session->userdata('username'); ?>/image/<?php echo str_replace('#','%23',$key->gambar_6); ?>" width="80" height="50" class="img-circle img-responsive">
                            <?php
                          } 

                        ?>
                    </td>
                    <td><?php echo $key->id_barang; ?></td>
                    <td><?php echo $key->nama_brg; ?></td>
                    <td align="center"><?php echo $key->stock; ?></td>
                    <td align="center"><?php echo $key->kondisi; ?></td>
                    <td align="center"><?php echo $key->harga; ?></td>
                    <td>
                      <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>admin/liststok/<?php echo $key->id_barang; ?>">Edit</a>
                      <button class="btn btn-danger btn-xs">Hapus</button>
                    </td>  
                  </tr>
                <?php
                $x++;
                }
                ?>
                </tbody>
              </table>
            </div>
              <?php
            }
           ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section> 
</div>
<script>
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