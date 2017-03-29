            <?php echo form_open("admin/simpantoko",array("id"=>"formtoko","onsubmit"=>"return validation_toko()")); ?>
                <fieldset>
                        <legend>Rincian Toko</legend>
                        <div class="form-group col-md-12">
                          <label>Nama Toko</label>
                          <input type="hidden" name="id_toko" value="<?php echo $id_toko; ?>">
                          <input type="text" name="nama" class="form-control filter-text" value="<?php echo $toko->nama_toko; ?>" required placeholder="Name Toko">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Deskripsi Toko</label>
                          <textarea class="form-control filter-text" name="deskripsi_toko" required placeholder="Deskripsi Toko"><?php echo $toko->deskripsi_toko; ?></textarea>
                        </div>
                        <div class="form-group col-md-12">
                          <label>Kategori : </label>
                          <select class="form-control select2" multiple="multiple" required name="kategori_toko[]" data-placeholder="pilih kategori toko" style="width: 100%;">
                          <?php  
                            $kat=$this->Model_admin->get_kategori_by_coma_separator($toko->kategori_toko);
                            $kat=$kat->result();
                            foreach ($kat as $key) {
                              ?>
                               <option value="<?php echo $key->id; ?>"><?php echo $key->kategori; ?></option> 
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Provinsi</label>
                          <select class="form-control" name="prov1" required onchange="get_kabkot1(event)">
                            <option value="">Pilih Provinsi</option>
                            <?php
                              $prov=$this->Model_admin->get_prov();
                              $prov=$prov->result();
                              foreach ($prov as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php echo $toko->id_prov==$key->id?'selected':''; ?>><?php echo $key->provinsi; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Kabupaten/Kota</label>
                          <select class="form-control" name="kabkot1" required onchange="get_kec1(event)">
                            <option value="">Pilih Kabupaten/Kota</option>
                            <?php 
                              $kabkot=$this->Model_admin->get_kabkot($toko->id_prov); 
                              $kabkot=$kabkot->result();
                              foreach ($kabkot as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php echo $toko->id_kabkot==$key->id?'selected':''; ?>><?php echo $key->kabkot; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>

                        <div class="form-group col-md-6">
                          <label>Kecamatan</label>
                          <select class="form-control" name="kec1" required>
                            <option value="">Pilih Kecamatan</option>
                            <?php 
                              $kec=$this->Model_admin->get_kec($toko->id_kabkot);
                              $kec=$kec->result();
                              foreach ($kec as $key) {
                                ?>
                                <option value="<?php echo $key->id; ?>" <?php echo $toko->id_kec==$key->id?'selected':''; ?>><?php echo $key->kecamatan; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Kodepos</label>
                          <input type="text" class="form-control filter-number" value="<?php echo $toko->kodepos; ?>" name="kodepos" placeholder="Kodepos">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Keterangan Tambahan Alamat</label>
                          <textarea class="form-control filter-text" name="ket_alamat" placeholder="Keterangan Alamat Tambahan"><?php echo $toko->ket_almt; ?></textarea>
                        </div>
                        <div class="form-group col-md-12" align="right">
                         
                            <button type="button" onclick="simpan_toko()" class="btn btn-danger">Submit</button>
                         
                        </div>
                      </fieldset>
                      <?php echo form_close(); ?>
                      <script type="text/javascript">

                      function validation_toko(){
                        return true;
                      }
                      function simpan_toko(){
                       var $myForm = $('#formtoko');
                          if ($myForm[0].checkValidity()) {
                            $("#formtoko").submit();
                          }else{
                            alert("form belum valid, pastikan sudah terisi semua");
                          }
                      }
                        function get_kabkot1(e){
                          $('select[name="kabkot1"]').html("Waiting...");
                          $('select[name="kec1"]').html("<option value=''>Pilih Kecamatan</option>");
                          $.post("<?php echo base_url(); ?>admin/get_kabkot",{id_prov:$(e.target).val()},function(data){
                            $('select[name="kabkot1"]').html("<option value=''>Pilih Kabupaten/Kota</option>");
                            var item=JSON.parse(data);
                            for(var i=0;i<item.length;i++){
                              $('select[name="kabkot1"]').append("<option value='"+item[i].id+"'>"+item[i].kabkot+"</option>");
                            }
                          });
                        }
                        function get_kec1(e){
                          $('select[name="kec1"]').html("Waiting...");
                          $.post("<?php echo base_url(); ?>admin/get_kec",{id_kabkot:$(e.target).val()},function(data){
                            $('select[name="kec1"]').html("<option value=''>Pilih Kecamatan</option>");
                            var item=JSON.parse(data);
                            for(var i=0;i<item.length;i++){
                              $('select[name="kec1"]').append("<option value='"+item[i].id+"'>"+item[i].kecamatan+"</option>");
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
         var value_kategori='<?php echo $toko->kategori_toko; ?>';
         var kategori_id=[<?php echo $toko->kategori_toko; ?>];
         value_kategori=value_kategori.split(","); 
         $('.select2').val(value_kategori).trigger('change');
         /*
         $('.select2').on('change',function(){
          if($(this).select2('val')!=null){
            var json_kategori = JSON.stringify($(this).select2('val'));
            console.log(json_kategori);
            /*
            $.post('<?php echo base_url(); ?>admin/get_kategori',{kategori_id:json_kategori},function(data,status){
              if(status=="success"){
                //return data;
                $(this).html("<option value='1'>xx</option><option value='2'>yy</option>").change();
              }else{
                //return "";
              }
            });
            
            //console.log(pop.statusText);
            //$(this).html("<option value='1'>xx</option><option value='2'>yy</option>").change();
          }
         });
        */
         
   });
                      </script>