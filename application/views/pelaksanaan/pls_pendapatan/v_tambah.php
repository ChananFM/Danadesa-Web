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

			<?php echo form_open('admin/c_perencanaan/simpan_rka_pendapatan'); ?>

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tahun_pendapatan">Tahun</label>
					 <div class="col-md-8">
						 <select class="form-control cari_tahun" name="tahun_pendapatan" required>
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
					 <label  class="col-md-4 control-label" for="id_kegiatan">Tingkat Kegiatan</label>
						<div class="col-md-8">
						<select class="form-control cari_dusun" name="id_kegiatan" required>
								<option value=""></option>
								<?php
								foreach ($c_dusun->result() as $baris) {?>
									<option value="<?php echo $baris->id_kegiatan; ?>"><?php echo $baris->nama_kegiatan; ?></option>
								<?php
								} ?>
							</select>
						 <span>&nbsp;</span>
 						</div>
				</div>

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="kelompok">Kelompok</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="kelompok" id="kelompok" size="100" placeholder="Kelompok" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="jenis">Jenis</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="jenis" id="jenis" size="100" placeholder="Jenis" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="lokasi_kegiatan">Lokasi Kegiatan</label>
						<div class="col-md-8">
							<textarea name="lokasi_kegiatan" id="lokasi_kegiatan" class="form-control" rows="3" cols="80" placeholder="Lokasi Kegiatan" required></textarea>
							<span>&nbsp;</span>
							</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="jumlah">Jumlah</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="jumlah" id="jumlah" size="100" placeholder="Jumlah" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tgl_pembahasan">Tanggal Pembahasan</label>
						<div class="col-md-4">
						 <input type="text" class="form-control input-md" name="tgl_pembahasan" id="tgl_pembahasan" value="<?php echo date('d-m-Y'); ?>" size="10" placeholder="Tanggal Pembahasan" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>

			<hr>
			<div class="form-group">
			    <label class="col-md-0 control-label" for="simpan"></label>
			    <button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_perencanaan/rka_pendapatan'"/>Batal</button>
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

	var d = document.getElementById("nav-rka-pendapatan");
	d.className = d.className + "active";
}

// very simple to use!
$(document).ready(function() {
  nav_active();
  $(".cari_dusun").select2({
			placeholder: "Pilih Tingkat Kegiatan"
	});
  $(".cari_tahun").select2({
			placeholder: "Pilih Tahun"
	});
  $('#jumlah').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
  $( "#tgl_pembahasan" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>
