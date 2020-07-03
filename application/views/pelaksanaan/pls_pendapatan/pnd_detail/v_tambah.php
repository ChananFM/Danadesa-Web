<script type="text/javascript" src="<?= $this->config->item('base_url'); ?>assetku/js/jquery.maskMoney.min.js"></script>
<link href="<?= $this->config->item('base_url'); ?>assetku/css/select2.min.css" rel="stylesheet" />
<script src="<?= $this->config->item('base_url'); ?>assetku/js/select2.min.js"></script>

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
			echo !empty($flashmessage) ? '<p class="message">' . $flashmessage . '</p>' : '';
			$tahun = date('Y');
			$this->db->where('tahun', $tahun);
			?>

			<?php echo form_open('admin/c_pelaksanaan/simpan_detail'); ?>
				<input type="hidden" name="id_rka_pendapatan" id="id_rka_pendapatan" value="<?php echo $id; ?>" required />

				<div class="form-group">
					 <label  class="col-md-4 control-label" for="tgl_detail_p">Tanggal</label>
						<div class="col-md-8">
						 <input type="text" class="form-control input-md" name="tgl_detail_p" id="tgl_detail_p" value="<?php echo date('d-m-Y'); ?>" size="10" placeholder="Pilih Tanggal" required/>
						 <span>&nbsp;</span>
 						</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="ket_detail_p">Keterangan</label>
					<div class="col-md-8">
						<textarea name="ket_detail_p" id="ket_detail_p" rows="3" class="form-control" cols="80" placeholder="Keterangan"></textarea>
						<span>&nbsp;</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="harga_detail_p">Pendapatan</label>
					<div class="col-md-8">
						<input type="text" class="form-control input-md" name="harga_detail_p" id="harga_detail_p" size="100" placeholder="Pendapatan" required />
						<span>&nbsp;</span>
					</div>
				</div>
				
				<hr>
				<div class="form-group">
					<label class="col-md-0 control-label" for="simpan"></label>
					<button type="button" class="btn btn-danger" name="batal" id="batal" onclick="location.href='<?= base_url() ?>admin/c_pelaksanaan/detail_pnd/<?php echo $id; ?>'">Batal</button>
					<button type="submit" class="btn btn-success" name="simpan" id="simpan" style="float:right;">Simpan</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
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
				src: '<?= base_url() . $hasil->image ?>'
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

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#bukti').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#bukti").change(function() {
		readURL(this); {
			document.getElementById("lihat").style.display = "block";
		}
	});

	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#blah').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function nav_active() {
		document.getElementById("a-pelaksanaan").className = "collapsed active";
		var r = document.getElementById("pelaksanaan");
		r.className = "collapsed";

		var d = document.getElementById("nav-rab");
		d.className = d.className + "active";
	}

	$("#imgInp").change(function() {
		readURL(this); {
			document.getElementById("blah").style.display = 'block';
		}

	});

	// very simple to use!
	$(document).ready(function() {
		nav_active();
		// document.getElementById("lihat").style.display = "block";
  		$('#harga_detail_p').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
  		$( "#tgl_pembahasan" ).datepicker({ dateFormat: 'dd-mm-yy' });
	});
</script>