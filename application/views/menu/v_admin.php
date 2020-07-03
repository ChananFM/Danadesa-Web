<!-- <br>
<br> -->
<div class="col-md-2" role="navigation">
  <style>
    .nav-second-level > li > a{
      padding-left: 40px;
    }
    #side-menu > li{
      border-bottom: 1px solid #f1f1f1;
    }

    ul > li > a{
      color: #e0e0e0;
    }
    ul :hover{
      color: black;
    }
    #side-menu > li > .active{
      background-color: #428BCA;
      color: white;
    }
  </style>
<!-- <div class="navbar-default sidebar" role="navigation"> -->
                <div class="sidebar-nav collapse navbar-collapse bs-navbar-collapse" role="navigation" style="margin-left:-35px;margin-right:-30px;">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a class="" href="<?php echo site_url('admin/c_admin/');?>" id="a-admin" class="" ><i class="fa fa-home fa-fw"></i> Beranda</a>
                        </li>
						            <!-- <li>
                            <a class="" href="<?php echo site_url('admin/c_user/');?>" id="a-user" class="" ><i class="fa fa-user fa-fw"></i> Pengguna</a>
                        </li> -->




				<!---------------------DROPDOWN 2--------------------------------------------------------------->
            <li class="dropdownmenu">
            <a id="a-data-master" class="collapsed" data-toggle="collapse" href="#data-master">
            <i class="fa fa-dropbox fa-fw"></i> Data Master <span class="fa arrow"></span></a>
            <div id="data-master" class="collapse">
              <ul id="" class="nav nav-pills nav-stacked nav-second-level">
                <!-- <li id="nav-user" class="">
                  <a href="<?php echo site_url('admin/c_user/');?>" >Pengguna</a>
                </li> -->
                <li id="nav-bidang" class="">
                  <a href="<?php echo site_url('admin/c_bidang/');?>" >Bidang</a>
                </li>
                <li id="nav-program" class="">
                  <a href="<?php echo site_url('admin/c_program/');?>" >Program</a>
                </li>
                
              </ul>
            </div>
            </li>
            <li class="dropdownmenu">
            <a id="a-perencanaan" class="collapsed" data-toggle="collapse" href="#perencanaan">
            <i class="fa fa-book fa-fw"></i> Perencanaan <span class="fa arrow"></span></a>
            <div id="perencanaan" class="collapse">
              <ul id="" class="nav nav-pills nav-stacked nav-second-level">
                <li id="nav-rka-belanja" class="">
                  <a href="<?php echo site_url('admin/c_perencanaan/rka_belanja/');?>" >RKA Belanja</a>
                </li>
                <li id="nav-rka-pendapatan" class="">
                  <a href="<?php echo site_url('admin/c_perencanaan/rka_pendapatan/');?>" >RKA Pendapatan</a>
                </li>
                <li id="nav-apb-desa" class="">
                  <a href="<?php echo site_url('admin/c_perencanaan/apb_desa/');?>" >Dana Cadangan</a>
                </li>
              </ul>
            </div>
            </li>
            <li class="dropdownmenu">
            <a id="a-pelaksanaan" class="collapsed" data-toggle="collapse" href="#pelaksanaan">
            <i class="fa fa-refresh fa-fw"></i> Pelaksanaan <span class="fa arrow"></span></a>
            <div id="pelaksanaan" class="collapse">
              <ul id="" class="nav nav-pills nav-stacked nav-second-level">
                <li id="nav-rab" class="">
                  <a href="<?php echo site_url('admin/c_pelaksanaan/rab/');?>" >Pelaksanaan Kegiatan</a>
                </li>
                <li id="nav-pls-pendapatan" class="">
                  <a href="<?php echo site_url('admin/c_pelaksanaan/pls_pendapatan/');?>" >Pelaksanaan Pendapatan</a>
                </li>
              </ul>
            </div>
            </li>
            <li>
           <a class="" href="<?php echo site_url('admin/c_kegiatan/');?>" id="a-po" class="" ><i class="fa fa-user fa-fw"></i> Ketua Kegiatan</a>
           </li>
            <li class="dropdownmenu">
            <a id="a-lap" class="collapsed" data-toggle="collapse" href="#lap">
            <i class="fa fa-print fa-fw"></i> Laporan <span class="fa arrow"></span></a>
            <div id="lap" class="collapse">
              <ul id="" class="nav nav-pills nav-stacked nav-second-level">
                <li id="nav-lra" class="">
                  <a href="<?php echo site_url('admin/c_lap/lra');?>" >Laporan Rencana Anggaran</a>
                </li>
                </li>
                <li id="nav-lad" class="">
                  <a href="<?php echo site_url('admin/c_lap/lad');?>" >Pembiayaan Desa</a>
                </li>
              </ul>
            </div>
            </li>

					</ul>
        </div>
                <!-- /.sidebar-collapse -->


</div>
        <!-- /.navbar-static-side -->
