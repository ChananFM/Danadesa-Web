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
       text-align:center;padding:0px;padding-top:15px;padding-bottom:15px;
     }
</style>
<h3><?= $page_title ?></h3>
<hr>
<!-- 
<a href="rka_pendapatan/add" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Create</a>
<a href="rka_pendapatan/print" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i> Print</a> -->
<hr>
<?php
echo $this->session->flashdata('msg');
?>
<div class="table-responsive">
<table id="table_id" class="table table-bordered table-striped display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center">Nama Pendapatan</th>
            <th style="text-align: center">Tahun</th>
            <th style="text-align: center">Pelaksana Kegiatan</th>
            <th style="text-align: center">Kelompok</th>
            <th style="text-align: center">Lokasi Kegiatan</th>
            <th style="text-align: center">Tanggal Pembahasan</th>
            <th style="text-align: center">Rencana Pendapatan</th>
            <th style="text-align: center">Pendapatan</th>
            <th style="text-align: center">Aksi</th>
        </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
      $total_jumlah = 0;
      foreach ($v_data->result() as $baris) {?>
        <tr>
          <th><?php echo $no++; ?>.</th>
          <td><?php echo $baris->jenis; ?></td>
          <td><?php echo $baris->tahun_pendapatan; ?></td>
          <td><?php echo $baris->nama_kegiatan; ?></td>
          <td><?php echo $baris->kelompok; ?></td>
          <td><?php echo $baris->lokasi_kegiatan; ?></td>
          <td><?php echo $this->page_model->tgl_id("$baris->tgl_pembahasan"); ?></td>
          <td>Rp.<span style="float:right;"><?php echo number_format($baris->jumlah, 0,",","."); ?>,-</span></td>
          <td>Rp.<span style="float:right;">
          <?php
            $this->db->select_sum('harga_detail_p')->from('tbl_detail_pendapatan')->where(array('id_rka_pendapatan' => $baris->id_rka_pendapatan));
            $query = $this->db->get()->row('harga_detail_p');
            // var_dump($query);
            echo number_format($query, 0,",",".");
          ?>,-</span></td>
          <td align="center">
            <a href="detail_pnd/<?php echo $baris->id_rka_pendapatan; ?>" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i></a>
            <!-- <a href="hapus_rka_pendapatan/<?php echo $baris->id_rka_pendapatan; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin?');"><i class="fa fa-trash"></i></a> -->
          </td>
        </tr>
      <?php
      $total_jumlah += $query;
      } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="8" style="text-align:right">Total :</th>
        <th><span style="margin-left:-8px;">Rp.</span><span style="float:right;margin-right:-7px;"><?php echo number_format($total_jumlah,0,",","."); ?>,-</span></th>
        <th colspan="2"></th>
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

  var d = document.getElementById("nav-pls-pendapatan");
  d.className = d.className + "active";
  }

// very simple to use!
$(document).ready(function() {
  nav_active();
  $('#table_id').DataTable();
});
</script>
