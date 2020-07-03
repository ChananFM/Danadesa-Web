
<script type="text/javascript" src="<?=$this->config->item('base_url');?>assetku/js/jquery.maskMoney.min.js"></script>
<link href="<?=$this->config->item('base_url');?>assetku/css/select2.min.css" rel="stylesheet" />
<script src="<?=$this->config->item('base_url');?>assetku/js/select2.min.js"></script>

<h2><?= $page_title ?></h2>

<hr>
<div class="col-md-2"></div>
<div class="col-md-8">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>Form Edit</b> </h3>
	  </div>
	  <div class="panel-body">

			<?php $flashmessage = $this->session->flashdata('exist');
				echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': '';

				$tahun = date('Y');
				echo $this->session->flashdata('msg');
				 ?>

			<?php echo form_open('admin/c_perencanaan/update_apb_desa'); ?>

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="nama_apb">Nama Dana Cadangan</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="nama_apb" value="<?php echo $hasil->nama_apb; ?>" id="nama_apb" size="100" placeholder="Nama Dana Cadangan" required/>
 						<span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tahun">Tahun</label>
						<div class="col-md-8">
						 <select class="form-control cari_tahun" name="tahun" required>
							 <option value=""></option>
							 <?php
								 for ($i=$tahun; $i >= 2010 ; $i--) { ?>
									 <option value="<?php echo $i; ?>" <?php if($hasil->tahun==$i){echo "selected";} ?>><?php echo $i; ?></option>
								 <?php
								 } ?>
						 </select>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="id_kegiatan">Ketua Kegiatan</label>
						<div class="col-md-8">
						<select class="form-control cari_dusun" name="id_kegiatan" required>
								<option value=""></option>
								<?php
							foreach ($v_kegiatan->result() as $baris) {?>
								<option value="<?php echo $baris->id_kegiatan; ?>" <?php if($hasil->id_kegiatan==$baris->id_kegiatan){echo "selected";} ?>><?php echo $baris->nama_kegiatan; ?></option>
							<?php
							} ?>
							</select>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tgl_apb_desa">Tanggal Pembahasan</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="tgl_apb_desa" id="tgl_apb_desa" value="<?php if($hasil->tgl_apb_desa == ''){echo date('d-m-Y');}else{echo $hasil->tgl_apb_desa;} ?>" size="10" placeholder="Tanggal Pembahasan" required/>
 						<span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="jumlah">Satuan</label>
						<div class="col-md-8">
						  <input type="text" class="form-control input-md" name="jumlah" value="<?php echo $hasil->jumlah; ?>" id="jumlah" size="100" placeholder="Satuan" required/>
 						<span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="anggaran">Harga</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="anggaran" value="Rp. <?php echo number_format($hasil->anggaran,0,",","."); ?>" id="anggaran" size="100" placeholder="Harga" required/>
						<span>&nbsp;</span>
 						</div>
				</div>
				<hr>
				<div class="form-group">
				    <label class="col-md-0 control-label" for="simpan"></label>
				    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_perencanaan/apb_desa'"/>Batal</button>
						<button type="submit" class="btn btn-success" name="simpan" id="simpan" style="float:right;"/>Simpan</button>
				    </div>
				</div>
			</div>
		</div>

		<?php echo form_close(); ?>
	</div>

	<script>
	function nav_active(){
		document.getElementById("a-perencanaan").className = "collapsed active";
		var r = document.getElementById("perencanaan");
		r.className = "collapsed";

		var d = document.getElementById("nav-apb-desa");
		d.className = d.className + "active";
	}

	// very simple to use!
	$(document).ready(function() {
	  nav_active();
		$(".cari_tahun").select2({
				placeholder: "Pilih Tahun"
		});
		// $('#uraian').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
	$('#anggaran').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $( "#tgl_apb_desa" ).datepicker({ dateFormat: 'dd-mm-yy' });
	  // $( "#ditetapkan_tgl" ).datepicker({ dateFormat: 'dd-mm-yy' });
	});
	</script>
