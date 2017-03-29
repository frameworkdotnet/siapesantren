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
.drop-area:hover{
  color:red;
  cursor: pointer;
}
img {
    max-height: 100%;
    width:100%;
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
</style>   
      <div class="row">
        <!-- Left col -->
        <?php echo form_open('admin/simpan_barang',array("id"=>"formbarang","method"=>"post","enctype"=>"multipart/form-data")); ?>
        <section class="col-lg-12">
        <div class="box box-danger">
            <div class="box-header">
              <i class="<?php echo $breadcumbparenticon; ?>"></i>
              <h3 class="box-title"><?php echo $subtitle2; ?></h3>
            </div>
            <div class="box-body">
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
                        <option value="<?php echo $key->id_toko; ?>"><?php echo $key->nama_toko; ?></option>
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
                  <input class="form-control filter-text" name="nama_barang" type="text" required>
              </div>
              <div class="form-group">
                <label>Kategori : </label>
                <select class="form-control select2" multiple="multiple" required name="kategori_barang[]" data-placeholder="pilih kategori barang" style="width: 100%;"></select>
              </div>
              <label>Harga : </label>
              <div class="form-group input-group">     
                <span class="input-group-addon">Rp. </span>
                <input class="form-control filter-number" name="harga_barang" type="text" required>
                <span class="input-group-addon"> , 00</span>
              </div>  
              <label>Jumlah Stock Barang : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="stok_barang" type="text" required>
                <span class="input-group-addon"> Item</span>
              </div>
              <div class="form-group">
                <label>Status : </label>
                  <select class="form-control" name="status_barang" required>
                    <option value="">Status Barang</option>
                    <option value="1">Tersedia</option>
                    <option value="0">Belum Tersedia</option>
                  </select>
              </div>         
              <div class="form-group">
                <label>Kondisi Barang : <small>(sertakan kondisi barang yang anda jual)</small> </label>
                  <select class="form-control" name="kondisi" required>
                    <option value="">Kondisi Barang</option>
                    <option value="Baru">Baru</option>
                    <option value="Bekas">Bekas</option>
                    <option value="Rusak">Rusak</option>
                    <option value="LainLain">Tanyakan pada penjual</option>
                  </select>
              </div> 
              </div>  
              <div class="tab-pane" id="barang2">
              <label>Berat : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="berat" type="text">
                <span class="input-group-addon"> gram</span>
              </div> 
              <label>Panjang : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="panjang" type="text">
                <span class="input-group-addon"> Cm</span>
              </div> 
              <label>Lebar : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="lebar" type="text">
                <span class="input-group-addon"> Cm</span>
              </div>
              <label>Tinggi : </label>
              <div class="form-group input-group">     
                <input class="form-control filter-number" name="tinggi" type="text">
                <span class="input-group-addon"> Cm</span>
              </div>  
              <div class="form-group">
                    <label>Link Video : <small>(Bisa di isi URL youtube video review produk anda)</small> </label>
                     <input type="url" class="form-control" name="video_barang">
                  </div>
                  <div class="form-group">
                    <label>Link Website : <small>(Bisa di isi URL website review produk anda)</small> </label>
                     <input type="url" class="form-control" name="web_review">
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
                 <input type="text" class="form-control filter-text" maxlength="60" name="title_seo">
              </div>
              <div class="form-group">
                <label>Permalink SEO : <small>(Custom Link untuk SEO)</small></label>
                 <input type="text" class="form-control filter-text-permalink" maxlength="255" name="permalink">
              </div>
              <div class="form-group">
                <label>Deskripsi Singkat : </label>
                 <textarea class="form-control filter-text" maxlength="160" name="deskripsi_barang" style="height:106px;" required></textarea>
              </div>
              <div class="form-group">
                <label>Keyword Pencarian : <small>(Pisah dengan koma ex : jual mobil sedan, mobil sedan antik)</small></label>
                 <input type="text" class="form-control filter-text" data-role="tagsinput" id="tag_barang2" maxlength="160" name="keyword_barang">
              </div>
              <div class="form-group">
                <label>Tag : <small>(Pisah dengan koma ex : mobil,motor)</small> </label>
                 <input type="text" class="form-control filter-text" data-role="tagsinput" id="tag_barang" name="tag_barang">
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
          <div class="small-box drop-area" id="Timage1" data-index="1" img-name="image1">Click to Add Image</div>
          <div class="progress progress-bar" id="pro1" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image1" name="image1" onchange="fileclickupload(this,'1');" class="hide">
          <input type="hidden" id="file1" name="file1" value=""><br>
          <div onclick="hapusimg(event)" id="hps1" class="hide"><span data-id="1" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage2" data-index="2" img-name="image2">Click to Add Image</div>
          <div class="progress progress-bar" id="pro2" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image2" name="image2" onchange="fileclickupload(this,'2');" class="hide">
          <input type="hidden" id="file2" name="file2" value=""><br>
          <div onclick="hapusimg(event)" id="hps2" class="hide"><span data-id="2" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage3" data-index="3" img-name="image3">Click to Add Image</div>
          <div class="progress progress-bar" id="pro3" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image3" name="image3" onchange="fileclickupload(this,'3');" class="hide">
          <input type="hidden" id="file3" name="file3" value=""><br>
          <div onclick="hapusimg(event)" id="hps3" class="hide"><span data-id="3" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage4" data-index="4" img-name="image4">Click to Add Image</div>
          <div class="progress progress-bar" id="pro4" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image4" name="image4" onchange="fileclickupload(this,'4');" class="hide">
          <input type="hidden" id="file4" name="file4" value=""><br>
          <div onclick="hapusimg(event)" id="hps4" class="hide"><span data-id="4" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage5" data-index="5" img-name="image5">Click to Add Image</div>
          <div class="progress progress-bar" id="pro5" style="width: 0%;height:8px;margin-bottom: auto;"></div>
          <input type="file" id="image5" name="image5" onchange="fileclickupload(this,'5');" class="hide">
          <input type="hidden" id="file5" name="file5" value=""><br>
          <div onclick="hapusimg(event)" id="hps5" class="hide"><span data-id="5" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box drop-area" id="Timage6" data-index="6" img-name="image6">Click to Add Image</div>
          <div class="progress progress-bar" id="pro6" style="width: 0%;height:8px;margin-bottom: auto;"></div> 
          <input type="file" id="image6" name="image6" onchange="fileclickupload(this,'6');" class="hide">
          <input type="hidden" id="file6" name="file6" value=""><br>
          <div onclick="hapusimg(event)" id="hps6" class="hide"><span data-id="6" class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Hapus</div>

        </div>
        <!-- ./col -->
      </div>
      </div>
              </div>
              <div class="col-md-12" style="margin-top: 10px">
              <div class="row">
                <div class="form-group">
                <label>Deskripsi Barang : </label>
                  <textarea class="textarea" name="keterangan_barang" placeholder="Place some text here" style="width: 100%; height: 245px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div> 
                </div>
              </div>
            </div>
            <div class="box-footer clearfix">
               <input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <button type="button" onclick="submit()" class="pull-right btn btn-primary">Tambah Barang
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
        </section>
        <?php echo form_close(); ?>
        <!-- /.Left col -->
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
      <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
      
      <script>
      function submit(){
        submitting=true;
        $("#formbarang").submit();
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
 /*
 $(".drop-area").on('dragenter', function (e){
  e.preventDefault();
 });
 

 $(".drop-area").on('dragover', function (e){
  e.preventDefault();
  $(this).css('background', '#BBD5B8');
 });
 $(".drop-area").on('dragleave', function (e){
  e.preventDefault();
  $(this).css('background', 'white');
 });

 $(".drop-area").on('drop', function (e){
  e.preventDefault();
  $(this).css('background', 'white');
  var image = e.originalEvent.dataTransfer.files;
  createFormData(image,$(this).attr('id'));
 });
 */
});
function hapusimg(e){
  var id=$(e.target).attr('data-id');
  var file=$('#file'+id).val();
  if(id!=undefined){
    $.post('<?php echo base_url(); ?>admin/remove_image',{file:file},function(data,status){
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
        }
      }else{
        alert("gagal koneksi dengan server");
      }
    });                
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
        url: '<?php echo base_url(); ?>admin/upload_image',
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
            $('#Timage'+id).append('<img src="<?php echo base_url(); ?>assets/upload/<?php echo $this->session->userdata("username"); ?>/temp_image/'+result.message+'" class="img-thumbnail img-responsive">');
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
      $(".select2").select2(); 
      $(".textarea").wysihtml5();
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
   });   
      
     
    $(function() {

      $('#tag_barang').tagsInput({width:'auto'});
      $('#tag_barang2').tagsInput({width:'auto'});
      /*
      $('#tags_2').tagsInput({
        width: 'auto',
        onChange: function(elem, elem_tags)
        {
          var languages = ['php','ruby','javascript'];
          $('.tag', elem_tags).each(function()
          {
            if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
              $(this).css('background-color', 'yellow');
          });
        }
      });
      $('#tags_3').tagsInput({
        width: 'auto',

        //autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
        autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
      });
*/

// Uncomment this line to see the callback functions in action
//      $('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});

// Uncomment this line to see an input with no interface for adding new tags.
//      $('input.tags').tagsInput({interactive:false});
    });

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
