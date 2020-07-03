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
				$this->db->order_by('nomor', 'DESC');
				$this->db->limit(1);
				$cek_na = $this->db->get('tbl_apb_desa');
				if ($cek_na->num_rows() == 0) {
				  $no_urut        = "001";
				}else{
				  $noUrut 	    	= substr($cek_na->row()->nomor, 0, 3);
				  $noUrut++;
				  $no_urut				= sprintf("%03s", $noUrut);
				}
				echo $this->session->flashdata('msg');
				?>

			<?php echo form_open('admin/c_perencanaan/simpan_apb_desa'); ?>

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="nama_apb">Nama Dana Cadangan</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="nama_apb" id="nama_apb" size="100" placeholder="Nama Dana Cadangan"  required/>
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
					 <label  class="col-md-4 control-label" for="id_kegiatan">Ketua Kegiatan</label>
						<div class="col-md-8">
						<select class="form-control cari_dusun" name="id_kegiatan" required>
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
					 <label  class="col-md-4 control-label" for="tgl_apb_desa">Tanggal Pembahasan</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="tgl_apb_desa" id="tgl_apb_desa" value="<?php echo date('d-m-Y'); ?>" size="10" placeholder="Tanggal Pembahasan" required/>
 						<span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="jumlah">Satuan</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="jumlah" id="jumlah" size="100" placeholder="Satuan"  required/>
 						<span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					 <label  class="col-md-4 control-label" for="anggaran">Harga</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="anggaran" id="anggaran" size="100" placeholder="Anggaran" required />
						<span>&nbsp;</span>
 						</div>
				</div>
				<!-- <div class="form-group">
					<div class="col-md-12">
						<div class="panel panel-info">
 						 <div class="panel-heading">
 					 	    <h3 class="panel-title"><b>Rekening</b> </h3>
 					 	 </div>
 						 <div class="panel-body">
			 				 <label  class="col-md-12 control-label" for="kode">Jenis Bank</label>
			 					<div class="col-md-12">
			 						 <input type="text" class="form-control input-md" name="kode" id="kode" size="100" placeholder="Jenis Bank" required/>
			 						<span>&nbsp;</span>
			  				</div>
 							 <label class="col-md-12 control-label" for="uraian">Nomer Rekening</label>
 								<div class="col-md-12">
 									<input type="number" class="form-control input-md" name="uraian" id="uraian" size="100" placeholder="Nomer Rekening"/>
 									
 									<span>&nbsp;</span>
 								</div>
 						 </div>
 					 </div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<div class="panel panel-danger">
 						 <div class="panel-heading">
 					 	    <h3 class="panel-title"><b>Anggaran</b> </h3>
 					 	 </div>
 						 <div class="panel-body">
							 <div class="form-group">
									<label  class="col-md-2 control-label" for="jumlah">Jumlah</label>
									 <div class="col-md-10">
										<input type="text" class="form-control input-md" name="jumlah" id="jumlah" size="100" placeholder="Jumlah" required/>
										<span>&nbsp;</span>
									 </div>
							 </div>
							 <div class="form-group">
									<label  class="col-md-2 control-label" for="satuan">Satuan</label>
									 <div class="col-md-10">
										<input type="text" class="form-control input-md" name="satuan" id="satuan" size="100" placeholder="Satuan" required/>
										<span>&nbsp;</span>
									 </div>
							 </div>
							 <div class="form-group">
									<label  class="col-md-2 control-label" for="harga">Harga</label>
									 <div class="col-md-10">
										<input type="text" class="form-control input-md" name="harga" id="harga" size="100" placeholder="Harga" required/>
										<span>&nbsp;</span>
									 </div>
							 </div>
							 <div class="form-group">
									<label  class="col-md-2 control-label" for="anggaran">Anggaran</label>
									 <div class="col-md-10">
										<input type="text" class="form-control input-md" name="anggaran" id="anggaran" size="100" placeholder="Anggaran" required/>
										<span>&nbsp;</span>
									 </div>
							 </div>
 						 </div>
 					 </div>
					</div>
				</div> -->

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
    $(".cari_dusun").select2({
			placeholder: "Pilih Ketua Kegiatan"
	});
	$(".cari_tahun").select2({
			placeholder: "Pilih Tahun"
	});
	// $('#uraian').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
	$('#anggaran').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $( "#tgl_apb_desa" ).datepicker({ dateFormat: 'dd-mm-yy' });
  // $( "#ditetapkan_tgl" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>
