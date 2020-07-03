<script type="text/javascript" src="<?=$this->config->item('base_url');?>assetku/js/jquery.maskMoney.min.js"></script>
<link href="<?=$this->config->item('base_url');?>assetku/css/select2.min.css" rel="stylesheet" />
<script src="<?=$this->config->item('base_url');?>assetku/js/select2.min.js"></script>

<h2><?= $page_title ?></h2>

<hr>
<div class="col-md-2"></div>
<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Form Detail</b> </h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12" style="margin: 0px 0px 10px 0px;">
        <div class="col-md-2" style="margin-left: -15px;">
          <?php echo form_open('admin/c_pelaksanaan/add_detail_pnd'); ?>
            <input type="hidden" name="id_rka_pendapatan" id="id_rka_pendapatan" value="<?php echo $id;?>" required/>
            <button type="submit" class="btn btn-primary" name="simpan" id="simpan"><i class="glyphicon glyphicon-plus"></i> Create</button>
          <?php echo form_close(); ?>
        </div>
        <!-- <div class="col-md-2" style="margin-left: -45px;">
          <?php echo form_open('admin/c_pelaksanaan/simpan_rab'); ?>
            <button type="submit" class="btn btn-warning" name="print" id="print"><i class="fa fa-print"></i> Print</button>
          <?php echo form_close(); ?>
        </div> -->
        </div>
        <div class="col-md-12">
            <style type="text/css">
              tr td {
                padding:6px;
              }
            </style>
            <div class="table-responsive">
              <table id="table_id" class="table table-bordered table-striped display" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                         <th width="1%;">No.</th>
                          <th width="10%;">Tanggal </th>
                          <th width="10%;">Keterangan</th>
                          <th width="5%;">Pendapatan</th>
                          <th width="8%;">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $total_harga_detail  = 0;
                      foreach($pnd->result() as $baris){?>
                      <tr>
                        <td><?= $baris->id_detail_p; ?></td>
                        <td><?= $baris->tgl_detail_p; ?></td>
                        <td><?= $baris->ket_detail_p; ?></td>
                        <td><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format($baris->harga_detail_p,0,",","."); ?>,-</span></td>
                        <td>
                          <a href="<?= base_url() ?>admin/c_pelaksanaan/edit_detail/<?php echo $baris->id_detail; ?>/<?php echo $id;?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="<?= base_url() ?>admin/c_pelaksanaan/hapus_detail/<?php echo $baris->id_detail; ?>/<?php echo $id;?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin?');"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php $total_harga_detail += $baris->harga_detail_p; } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3" style="text-align:right">Total :</th>
                      <th><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format($total_harga_detail,0,",","."); ?>,-</span></th>
                      <th colspan="2"></th>
                    </tr>
                  </tfoot>
              </table>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="col-md-0 control-label" for="simpan"></label>
            <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_pelaksanaan/pls_pendapatan'">Kembali</button>
        </div>
      </div>
    </div>
  </div>


  <?php echo form_close(); ?>
</div>

<style>
    /* Show load indicator when image is being loaded */
    .cropit-image-preview.cropit-image-loading .spinner {
    opacity: 1;
    }

    /* Show move cursor when image has been loaded */
    .cropit-image-preview.cropit-image-loaded {
    cursor: move;
    }

    /* Gray out zoom slider when the image cannot be zoomed */
    .cropit-image-zoom-input[disabled] {
    opacity: .2;
    }

    
      .cropit-image-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 200px;
        height: 200px;
        cursor: move;
      }

      .cropit-image-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input {
        display: block;
      }

      button[type="submit"] {
        margin-top: 10px;
      }
    </style>  
<script src="<?php echo base_url(); ?>assetku/cropit/jquery.cropit.js"></script> 

<script>
$(function() {
  
$('.image-editor').cropit({
  imageState: {
  src: '<?php echo site_url($result->image);?>'
  }
});
  
$('form').submit(function() {
    // Move cropped image data to hidden input
   var imageData = $('.image-editor').cropit('export', {
      type: 'image/jpeg',
      quality: 2,
      originalSize: false
    });   
    $('.hidden-image-data').val(imageData);
    
    // Prevent the form from actually submitting
    return true;
  });
  });

</script>

<script>

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#bukti').attr('src', e.target.result);   
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#bukti").change(function(){
    readURL(this);
  {document.getElementById("lihat").style.display = "block";}
});
</script>

<script>
function nav_active(){
  document.getElementById("a-pelaksanaan").className = "collapsed active";
  var r = document.getElementById("pelaksanaan");
  r.className = "collapsed";

  var d = document.getElementById("nav-pls-pendapatan");
  d.className = d.className + "active";
}

$("#imgInp").change(function(){
    readURL(this);
  {document.getElementById("blah").style.display = 'block';}
  
});




// very simple to use!
$(document).ready(function() {
  // document.getElementById("lihat").style.display = "block";
  // $(".cropit-image-preview").reload();

  nav_active();
  $(".cari_bidang").select2({
      placeholder: "Pilih Bidang"
  });
  $(".cari_program").select2({
      placeholder: "Pilih Program"
  });
  $(".cari_kegiatan").select2({
      placeholder: "Pilih Kegiatan"
  });
  $(".cari_dusun").select2({
      placeholder: "Pilih Tingkat Kegiatan"
  });
  $(".cari_tahun").select2({
      placeholder: "Pilih Tahun"
  });

  
  $('#anggaran').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
  $( "#tgl_baris_belanja" ).datepicker({ dateFormat: 'dd-mm-yy' });
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
  {document.getElementById("blah").style.display = 'block';}
  
});


$( document ).ready(function() {
   
   var cek = $('input[name="is_bsm"]:checked').val();  
   if(cek == 'Y') 
   {
    document.getElementById("bsm").style.display = 'block';
   }
   else document.getElementById("bsm").style.display = 'none';
   
    document.getElementById("lihat").style.display = "block";
  $(".cropit-image-preview").reload();


});
</script>