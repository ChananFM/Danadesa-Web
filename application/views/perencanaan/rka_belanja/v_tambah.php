<script type="text/javascript" src="<?=$this->config->item('base_url');?>assetku/js/jquery.maskMoney.min.js"></script>
<link href="<?=$this->config->item('base_url');?>assetku/css/select2.min.css" rel="stylesheet" />
<script src="<?=$this->config->item('base_url');?>assetku/js/select2.min.js"></script>
<script src="<?=$this->config->item('base_url');?>assetku/js/jquery-ui.js"></script>

<h2><?= $page_title ?></h2>

<hr>
<div class="col-md-2"></div>
<div class="col-md-8">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>Form Tambah</b> </h3>
	  </div>
	  <div class="panel-body">

			<?php $flashmessage = $this->session->flashdata('exist');
				echo ! empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>': '';
				$tahun = date('Y');
				$this->db->where('tahun', $tahun);
				 ?>

			<?php echo form_open('admin/c_perencanaan/simpan_rka_belanja'); ?>

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="pelaksana_kegiatan">Nama Kegiatan</label>
					 <div class="col-md-8">
						<input type="text" class="form-control input-md" name="pelaksana_kegiatan" id="pelaksana_kegiatan" size="10" placeholder="Nama Kegiatan" required/>
						<span>&nbsp;</span>
						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="id_kegiatan">Ketua Kegiatan</label>
						<div class="col-md-8">
						<select class="form-control cari_kegiatan" name="id_kegiatan" required>
								<option value=""></option>
								<?php
								foreach ($v_kegiatan->result() as $baris) {?>
									<option value="<?php echo $baris->id_kegiatan; ?>"><?php echo $baris->nama_kegiatan; ?></option>
								<?php
								} ?>
							</select>
						 <span>&nbsp;</span>
 						</div>
				</div>
			    <div class="form-group">
			    	 <label  class="col-md-4 control-label" for="id_bidang">Bidang</label>
			        <div class="col-md-8">
							<select class="form-control cari_bidang" name="id_bidang" required>
								<option value=""></option>
								<?php
								foreach ($v_bidang->result() as $baris) {?>
									<option value="<?php echo $baris->id_bidang; ?>"><?php echo $baris->nama_bidang; ?></option>
								<?php
								} ?>
							</select>
							<span>&nbsp;</span>
				      </div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="id_program">Program</label>
						<div class="col-md-8">
						<select class="form-control cari_program" name="id_program" required>
							<option value=""></option>
							<?php
							foreach ($v_program->result() as $baris) {?>
								<option value="<?php echo $baris->id_program; ?>"><?php echo $baris->nama_program; ?></option>
							<?php
							} ?>
						</select>
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
								 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							 <?php
							 } ?>
						 </select>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="id_dusun">Tingkat Kegiatan</label>
						<div class="col-md-8">
						<select class="form-control cari_dusun" name="id_dusun" required>
								<option value=""></option>
								<?php
								foreach ($v_dusun->result() as $baris) {?>
									<option value="<?php echo $baris->id_dusun; ?>"><?php echo $baris->nama_dusun; ?></option>
								<?php
								} ?>
							</select>
						 <span>&nbsp;</span>
 						</div>
				</div>
				
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tgl_rka_belanja">Rencana Dilaksanakan</label>
					 <div class="col-md-8">
						 <input type="text" class="form-control input-md" name="tgl_rka_belanja" id="tgl_rka_belanja" value="<?php echo date('d-m-Y'); ?>" size="10" placeholder="Ditetapkan Tanggal" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="selesai">Rencana Selesai</label>
					 <div class="col-md-8">
						 <input type="text" class="form-control input-md" name="selesai" id="selesai" value="<?php echo date('d-m-Y'); ?>" size="10" placeholder="Ditetapkan Tanggal" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="anggaran">Anggaran</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="anggaran" id="anggaran" size="100" placeholder="Anggaran" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>

			<hr>
			<div class="form-group">
			    <label class="col-md-0 control-label" for="simpan"></label>
			    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_perencanaan/rka_belanja'"/>Batal</button>
				<button type="submit" class="btn btn-success" name="simpan" id="simpan" style="float:right;"/>Simpan</button>
			    </div>
			</div>
		</div>
	</div>

	<?php echo form_close(); ?>
</div>
<!-- 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>

 -->
<script>
function nav_active(){
	document.getElementById("a-perencanaan").className = "collapsed active";
	var r = document.getElementById("perencanaan");
	r.className = "collapsed";

	var d = document.getElementById("nav-rka-belanja");
	d.className = d.className + "active";
}


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
	$( "#tgl_rka_belanja" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#selesai" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>
