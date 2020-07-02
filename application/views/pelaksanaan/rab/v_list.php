<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>assetku/DataTables/datatables.min.css"/>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>assetku/DataTables/dataTables.min.js"></script>

<style>
     .dataTable > thead > tr > th[class*="sort"]::after{display: none}
     table.dataTable thead .sorting,
     table.dataTable thead .sorting_asc,
     table.dataTable thead .sorting_desc {
        background : none;
     }

     #rowspan2{
       text-align:center;padding:0px;padding-bottom:30px;
     }
</style>
<h3><?= $page_title ?></h3>
<hr>

<!-- <a href="rab/add" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Create</a> -->
<!-- <a href="rab/print" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i> Print</a> -->
<hr>
<?php
echo $this->session->flashdata('msg');
?>
<div class="table-responsive">
<table id="table_id" class="table table-bordered table-striped display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th  style="text-align: center">No.</th>
            <th  style="text-align: center">Nama Perencanaan</th>
            <th  style="text-align: center">Ketua Kegiatan</th>
            <th  style="text-align: center">Tahun</th>
            <th  style="text-align: center">Rencana Dimulai</th>
            <th  style="text-align: center">Rencana Selesai</th>
            <th  style="text-align: center">Dana Anggaran</th>
            <th  style="text-align: center">Dana Pengeluaran</th>
            <th  style="text-align: center">Sisa</th>
            <th  style="text-align: center">Aksi</th>
        </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
      $total_anggaran = 0;
      foreach ($v_data->result() as $baris) {?>
        <tr>
          <td><?php echo $no++; ?>.</td>
          <td><?php echo $baris->pelaksana_kegiatan; ?></td>
          <td><?php echo $baris->nama_kegiatan; ?></td>
          <td><?php echo $baris->tahun; ?></td>
          <td><?php echo $baris->tgl_rka_belanja; ?></td>
          <td><?php echo $baris->selesai; ?></td>
          <td><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format($baris->anggaran,0,",","."); ?>,-</span></td>
          <td>Rp.<span style="float:right;">
          <?php
            $this->db->select_sum('harga_detail')->from('tbl_detail')->where(array('id_rka_belanja' => $baris->id_rka_belanja));
            $query = $this->db->get()->row('harga_detail');
            // var_dump($query);
            echo number_format($query, 0,",",".");
          ?>,-</span></td>
          <td><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format(0,",","."); ?>,-</span></td>
          <td align="center">
            <a href="detail/<?php echo $baris->id_rka_belanja; ?>" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i></a>
            <!-- <a href="hapus_rab/<?php echo $baris->id_rka_belanja; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin?');"><i class="fa fa-trash"></i></a> -->
          </td>
        </tr>
      <?php
      // $sisa_anggaran = $anggaran - $query;
      $total_anggaran += $query;
      } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="6" style="text-align:right">Total Pengeluaran :</th>
        <th><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format($total_anggaran,0,",","."); ?>,-</span></th>
        <th></th>
      </tr>
    </tfoot>
</table>
</div>

<script>
function nav_active(){
	// document.getElementById("a-user").className = "collapsed active";
  document.getElementById("a-pelaksanaan").className = "collapsed active";
	var r = document.getElementById("pelaksanaan");
	r.className = "collapsed";

	var d = document.getElementById("nav-rab");
	d.className = d.className + "active";
	}

// very simple to use!
$(document).ready(function() {
  nav_active();
  $('#table_id').DataTable();
});
</script>
