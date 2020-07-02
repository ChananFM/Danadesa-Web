<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url();?>uploads/logonew.png" type="image/x-icon" />
    <style>
    table{
        border-collapse: collapse;
        /* width: 70%; */
        margin: 0 auto;
    }
    table thead th{
        border:1px solid #000;
        padding: 3px;
        font-weight: bold;
        text-align: center;
    }

    #tr_head{
        background-color: #f1f1f1;
        color: #222;
    }

    #tr_head2{
        background-color: #f0f0f0;
        color: #222;
    }

    #tr td{
        border:1px solid #000;
        background-color: #f9f9f9;
        padding: 3px;
        vertical-align: top;
    }

    #tr_foot{
        background-color: #f1f1f1;
        color: #222;
    }

  		body{
  			font-family: Arial;
  		}

      h2{
        text-align:center;
      }
  	</style>
  </head>
  <body onload="window.print()">

    <h2><?php echo $page_title; ?></h2>
    <br>
    <table border="1" width="100%">
        <thead>
            <tr id="tr_head">
              <th width="1%" id="rowspan2">No.</th>
              <th width="15%" id="rowspan2">Kelompok</th>
              <th width="15%" id="rowspan2">Jenis</th>
              <th width="24%" id="rowspan2">Lokasi Kegiatan</th>
              <th width="15%" id="rowspan2">Jumlah</th>
              <th width="15%" id="rowspan2">Tanggal Pembahasan</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $no=1;
          $total_jumlah = 0;
          foreach ($v_data->result() as $baris) {?>
            <tr id="tr">
              <th style="background-color: #f1f1f1;color: #222;"><?php echo $no++; ?>.</th>
              <td><?php echo $baris->kelompok; ?></td>
              <td><?php echo $baris->jenis; ?></td>
              <td><?php echo $baris->lokasi_kegiatan; ?></td>
              <td>Rp.<span style="float:right;"><?php echo number_format($baris->jumlah, 0,",","."); ?>,-</span></td>
              <td><?php echo $this->page_model->tgl_id("$baris->tgl_pembahasan"); ?></td>
            </tr>
          <?php
          $total_jumlah += $baris->jumlah;
          } ?>
        </tbody>
        <tfoot id="tr_foot">
          <tr>
            <th colspan="4" style="text-align:right">Total :</th>
            <th><span style="float:left;">Rp.</span><span style="float:right;"><?php echo number_format($total_jumlah,0,",","."); ?>,-</span></th>
            <th></th>
          </tr>
        </tfoot>
    </table>
  </body>
</html>
