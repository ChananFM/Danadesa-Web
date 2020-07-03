<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_perencanaan extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('page_model');
		    $this->load->library('encrypt');
    }

    function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			redirect('admin/c_admin');//$this->lists();
		}else
			redirect('c_login', 'refresh');

    }

    function rka_belanja($aksi='',$id='')    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
      if ($aksi == 'add') {
        $this->add_rka_belanja();
      }elseif ($aksi == 'print') {
        $this->print_rka_belanja();
      }else {
        $this->lists_rka_belanja();
      }
		}else
			redirect('c_login', 'refresh');

    }

    function lists_rka_belanja() {
        $data['page_title'] = 'DATA RKA BELANJA | Rencana Anggaran Biaya (RAB)';
        $this->db->join('tbl_bidang', 'tbl_bidang.id_bidang=tbl_rka_belanja.id_bidang');
        $this->db->join('tbl_program', 'tbl_program.id_program=tbl_rka_belanja.id_program');
        $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_belanja.id_kegiatan');
        $this->db->join('ref_dusun', 'ref_dusun.id_dusun=tbl_rka_belanja.id_dusun');
        $this->db->order_by('id_rka_belanja', 'DESC');
        $data['v_data'] = $this->db->get('tbl_rka_belanja');
		    $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('perencanaan/rka_belanja/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function add_rka_belanja(){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['page_title'] = 'Tambah DATA RKA BELANJA | Rencana Anggaran Biaya (RAB)';
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('perencanaan/rka_belanja/v_tambah', $data, TRUE);
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');

    }

    function simpan_rka_belanja() {
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;
      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
            	if (isset($_POST['simpan'])) {
                  $data = array(
                    'id_bidang'          => $this->input->post('id_bidang'),
          					'id_program'         => $this->input->post('id_program'),
          					'id_kegiatan'        => $this->input->post('id_kegiatan'),
          					'pelaksana_kegiatan' => $this->input->post('pelaksana_kegiatan'),
                    'tahun'              => $this->input->post('tahun'),
                    'id_dusun'           => $this->input->post('id_dusun'),
                    'tgl_rka_belanja'    => $this->input->post('tgl_rka_belanja'),
                    'selesai'            => $this->input->post('selesai'),
                    'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran'))
          				);

                    $this->db->insert("tbl_rka_belanja", $data);
                    $this->session->set_flashdata('msg',
                    '
                    <div class="alert alert-success alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                       </button>
                       <strong>Sukses!</strong> Berhasil ditambah.
                    </div>'
                  );
                  // }
          				
              }
      				redirect('admin/c_perencanaan/rka_belanja');
      }else
        redirect('c_login', 'refresh');
    }

      function edit_rka_belanja($id=''){
          $session['hasil'] = $this->session->userdata('logged_in');
      		$role = $session['hasil']->role;
      		if($this->session->userdata('logged_in') AND $role == 'Administrator')
      		{
      			$data['hasil'] = $this->db->get_where("tbl_rka_belanja", array('id_rka_belanja' => "$id"))->row();

            $data['page_title'] = 'EDIT DATA RKA BELANJA | Rencana Anggaran Biaya (RAB)';
            $this->db->order_by('nama_bidang', 'ASC');
            $data['v_bidang'] = $this->db->get('tbl_bidang');
            $this->db->order_by('nama_program', 'ASC');
            $data['v_program'] = $this->db->get('tbl_program');
            $this->db->order_by('nama_kegiatan', 'ASC');
            $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
            $this->db->order_by('nama_dusun', 'ASC');
            $data['v_dusun'] = $this->db->get('ref_dusun');
      			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      			$data['content'] = $this->load->view('perencanaan/rka_belanja/v_ubah', $data, TRUE);
      			$this->load->view('utama', $data);
      		}else
      			redirect('c_login', 'refresh');
      }


      function update_rka_belanja() {
        $session['hasil'] = $this->session->userdata('logged_in');
        $role = $session['hasil']->role;
        if($this->session->userdata('logged_in') AND $role == 'Administrator')
        {


          if (isset($_POST['simpan'])) {
             $image = $this->input->post('image', TRUE);
             $id_rka_belanja = $this->input->post('id_rka_belanja', TRUE);
             $id = $this->input->post('id');

             $newfile = $this->input->post('image-data', TRUE);
    
             define('UPLOAD_DIR', 'uploads/');
             $img = $newfile;
             $img = str_replace('data:image/jpeg;base64,', '', $img);
             $img = str_replace(' ', '+', $img);
             $data = base64_decode($img);
             $file = UPLOAD_DIR . $id . '.jpg';
             $success = file_put_contents($file, $data);
    
             $path = $file;
            //  var_dump($path);
            
              $data = array(
                'id_bidang'          => $this->input->post('id_bidang'),
                'id_program'         => $this->input->post('id_program'),
                'id_kegiatan'        => $this->input->post('id_kegiatan'),
                'pelaksana_kegiatan' => $this->input->post('pelaksana_kegiatan'),
                'tahun'              => $this->input->post('tahun'),
                'image'              => $path,
                'id_dusun'           => $this->input->post('id_dusun'),
                'tgl_rka_belanja'    => $this->input->post('tgl_rka_belanja'),
                'selesai'            => $this->input->post('selesai'),
                'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran'))
              );
              $this->db->update("tbl_rka_belanja", $data, array('id_rka_belanja' => "$id"));
              $this->session->set_flashdata('msg',
                '
                <div class="alert alert-success alert-dismissible" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                   </button>
                   <strong>Sukses!</strong> Berhasil diupdate.
                </div>'
              );
          }
          redirect('admin/c_perencanaan/rka_belanja');

        }
      }

      function hapus_rka_belanja($id='') {
        $session['hasil'] = $this->session->userdata('logged_in');
        $role = $session['hasil']->role;
        if($this->session->userdata('logged_in') AND $role == 'Administrator')
        {
                $this->db->delete("tbl_rka_belanja", array('id_rka_belanja' => "$id"));
                $this->session->set_flashdata('msg',
                  '
                  <div class="alert alert-success alert-dismissible" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                     </button>
                     <strong>Sukses!</strong> Berhasil dihapus.
                  </div>'
                );
                redirect('admin/c_perencanaan/rka_belanja');
        }
      }

      function print_rka_belanja($id='') {
          $data['page_title'] = 'DATA RKA BELANJA | Rencana Anggaran Biaya (RAB)';
          $this->db->join('tbl_bidang', 'tbl_bidang.id_bidang=tbl_rka_belanja.id_bidang');
          $this->db->join('tbl_program', 'tbl_program.id_program=tbl_rka_belanja.id_program');
          $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_belanja.id_kegiatan');
          if ($id!='') {
            $this->db->like('tbl_rka_belanja.tahun', "$id", 'before');
          }
          $this->db->order_by('id_rka_belanja', 'DESC');
          $data['v_data'] = $this->db->get('tbl_rka_belanja');
          $this->load->view('perencanaan/rka_belanja/v_print', $data);
      }


      function rka_pendapatan($aksi='',$id='')    {
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;
      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
        if ($aksi == 'add') {
          $this->add_rka_pendapatan();
        }elseif ($aksi == 'print') {
          $this->print_rka_pendapatan();
        }else {
          $this->lists_rka_pendapatan();
        }
      }else
        redirect('c_login', 'refresh');

      }

      function lists_rka_pendapatan() {
          $data['page_title'] = 'DATA RKA PENDAPATAN';
          $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_pendapatan.id_kegiatan', 'left');
          $this->db->order_by('id_rka_pendapatan', 'DESC');
          $data['v_data'] = $this->db->get('tbl_rka_pendapatan');
          $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
          $data['content'] = $this->load->view('perencanaan/rka_pendapatan/v_list', $data, TRUE);
          $this->load->view('utama', $data);
      }

      function add_rka_pendapatan(){
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;

      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
        $data['page_title'] = 'Tambah DATA RKA PENDAPATAN';
        $this->db->order_by('nama_kegiatan', 'ASC');
        $data['c_dusun'] = $this->db->get('tbl_kegiatan');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('perencanaan/rka_pendapatan/v_tambah', $data, TRUE);
        $this->load->view('utama', $data);
      }else
        redirect('c_login', 'refresh');

      }

      function simpan_rka_pendapatan() {
        $session['hasil'] = $this->session->userdata('logged_in');
        $role = $session['hasil']->role;
        if($this->session->userdata('logged_in') AND $role == 'Administrator')
        {
                if (isset($_POST['simpan'])) {
                    $data = array(
                      'kelompok'           => $this->input->post('kelompok'),
                      'tahun_pendapatan'   => $this->input->post('tahun_pendapatan'),
                      'id_kegiatan'        => $this->input->post('id_kegiatan'),
                      'jenis'              => $this->input->post('jenis'),
                      'lokasi_kegiatan'    => $this->input->post('lokasi_kegiatan'),
                      'jumlah'             => preg_replace('/[Rp. ]/', '', $this->input->post('jumlah')),
                      'tgl_pembahasan'     => $this->input->post('tgl_pembahasan')
                    );
                    $this->db->insert("tbl_rka_pendapatan", $data);
                    $this->session->set_flashdata('msg',
                      '
                      <div class="alert alert-success alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                         </button>
                         <strong>Sukses!</strong> Berhasil ditambah.
                      </div>'
                    );
                }
                redirect('admin/c_perencanaan/rka_pendapatan');
        }else
          redirect('c_login', 'refresh');
      }

        function edit_rka_pendapatan($id=''){
            $session['hasil'] = $this->session->userdata('logged_in');
            $role = $session['hasil']->role;
            if($this->session->userdata('logged_in') AND $role == 'Administrator')
            {
              $data['hasil'] = $this->db->get_where("tbl_rka_pendapatan", array('id_rka_pendapatan' => "$id"))->row();

              $data['page_title'] = 'EDIT DATA RKA PENDAPATAN';
              $this->db->order_by('nama_kegiatan', 'ASC');
              $data['c_dusun'] = $this->db->get('tbl_kegiatan');
              $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
              $data['content'] = $this->load->view('perencanaan/rka_pendapatan/v_ubah', $data, TRUE);

              $this->load->view('utama', $data);
            }else
              redirect('c_login', 'refresh');
        }


        function update_rka_pendapatan() {
          $session['hasil'] = $this->session->userdata('logged_in');
          $role = $session['hasil']->role;
          if($this->session->userdata('logged_in') AND $role == 'Administrator')
          {
            if (isset($_POST['simpan'])) {
              $id = $this->input->post('id');
                $data = array(
                  'kelompok'           => $this->input->post('kelompok'),
                  'tahun_pendapatan'   => $this->input->post('tahun_pendapatan'),
                  'id_kegiatan'           => $this->input->post('id_kegiatan'),
                  'jenis'              => $this->input->post('jenis'),
                  'lokasi_kegiatan'    => $this->input->post('lokasi_kegiatan'),
                  'jumlah'             => preg_replace('/[Rp. ]/', '', $this->input->post('jumlah')),
                  'tgl_pembahasan'     => $this->input->post('tgl_pembahasan')
                );
                $this->db->update("tbl_rka_pendapatan", $data, array('id_rka_pendapatan' => "$id"));
                $this->session->set_flashdata('msg',
                  '
                  <div class="alert alert-success alert-dismissible" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                     </button>
                     <strong>Sukses!</strong> Berhasil diupdate.
                  </div>'
                );
            }
            redirect('admin/c_perencanaan/rka_pendapatan');

          }
        }

        function hapus_rka_pendapatan($id='') {
          $session['hasil'] = $this->session->userdata('logged_in');
          $role = $session['hasil']->role;
          if($this->session->userdata('logged_in') AND $role == 'Administrator')
          {
                  $this->db->delete("tbl_rka_pendapatan", array('id_rka_pendapatan' => "$id"));
                  $this->session->set_flashdata('msg',
                    '
                    <div class="alert alert-success alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                       </button>
                       <strong>Sukses!</strong> Berhasil dihapus.
                    </div>'
                  );
                  redirect('admin/c_perencanaan/rka_pendapatan');
          }
        }

        function print_rka_pendapatan() {
            $data['page_title'] = 'DATA RKA PENDAPATAN';
            $this->db->order_by('id_rka_pendapatan', 'DESC');
            $data['v_data'] = $this->db->get('tbl_rka_pendapatan');
            $this->load->view('perencanaan/rka_pendapatan/v_print', $data);
        }


        function raperdes($aksi='',$id='')    {
        $session['hasil'] = $this->session->userdata('logged_in');
        $role = $session['hasil']->role;
        if($this->session->userdata('logged_in') AND $role == 'Administrator')
        {
          if ($aksi == 'add') {
            $this->add_raperdes();
          }elseif ($aksi == 'print') {
            $this->print_raperdes();
          }else {
            $this->lists_raperdes();
          }
        }else
          redirect('c_login', 'refresh');

        }

        function lists_raperdes() {
            $data['page_title'] = 'DATA RAPERDES';
            $this->db->order_by('id_raperdes', 'DESC');
            $data['v_data'] = $this->db->get('tbl_raperdes');
            $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
            $data['content'] = $this->load->view('perencanaan/raperdes/v_list', $data, TRUE);
            $this->load->view('utama', $data);
        }

        function add_raperdes(){
        $session['hasil'] = $this->session->userdata('logged_in');
        $role = $session['hasil']->role;
        if($this->session->userdata('logged_in') AND $role == 'Administrator')
        {
          $data['page_title'] = 'Tambah DATA RAPERDES';
          $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
          $data['content'] = $this->load->view('perencanaan/raperdes/v_tambah', $data, TRUE);
          $this->load->view('utama', $data);
        }else
          redirect('c_login', 'refresh');

        }

        function simpan_raperdes() {
          $session['hasil'] = $this->session->userdata('logged_in');
          $role = $session['hasil']->role;
          if($this->session->userdata('logged_in') AND $role == 'Administrator')
          {
                  if (isset($_POST['simpan'])) {
                    $nomor = $this->input->post('nomor');
                    $tahun = $this->input->post('tahun');
                    if ($this->db->get_where("tbl_raperdes", array('nomor' => "$nomor", 'tahun' => "$tahun"))->num_rows() != 0) {
                      $this->session->set_flashdata('msg',
                        '
                        <div class="alert alert-warning alert-dismissible" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                           </button>
                           <strong>Gagal!</strong> Maaf, Nomor <b>"'.$nomor.'"</b> dan Tahun <b>"'.$tahun.'"</b> sudah ada!.
                        </div>'
                      );
                      redirect('admin/c_perencanaan/raperdes/add');
                    }
                      $data = array(
                        'nomor'              => $nomor,
                        'tahun'              => $tahun,
                        'ditetapkan_tgl'     => $this->input->post('ditetapkan_tgl'),
                        'uraian'             => $this->input->post('uraian'),
                        'jumlah'             => preg_replace('/[Rp. ]/', '', $this->input->post('jumlah')),
                        'satuan'             => $this->input->post('satuan'),
                        'harga'              => preg_replace('/[Rp. ]/', '', $this->input->post('harga')),
                        'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
                        'keterangan'         => $this->input->post('keterangan'),
                        'tgl_raperdes'       => date('d-m-Y')
                      );
                      $this->db->insert("tbl_raperdes", $data);
                      $this->session->set_flashdata('msg',
                        '
                        <div class="alert alert-success alert-dismissible" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                           </button>
                           <strong>Sukses!</strong> Berhasil ditambah.
                        </div>'
                      );
                  }
                  redirect('admin/c_perencanaan/raperdes');
          }else
            redirect('c_login', 'refresh');
        }

          function edit_raperdes($id=''){
              $session['hasil'] = $this->session->userdata('logged_in');
              $role = $session['hasil']->role;
              if($this->session->userdata('logged_in') AND $role == 'Administrator')
              {
                $data['hasil'] = $this->db->get_where("tbl_raperdes", array('id_raperdes' => "$id"))->row();

                $data['page_title'] = 'EDIT DATA RAPERDES';
                $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
                $data['content'] = $this->load->view('perencanaan/raperdes/v_ubah', $data, TRUE);

                $this->load->view('utama', $data);
              }else
                redirect('c_login', 'refresh');
          }


          function update_raperdes() {
            $session['hasil'] = $this->session->userdata('logged_in');
            $role = $session['hasil']->role;
            if($this->session->userdata('logged_in') AND $role == 'Administrator')
            {
              if (isset($_POST['simpan'])) {
                $id = $this->input->post('id');
                $id_nomor = $this->input->post('id_nomor');
                $id_tahun = $this->input->post('id_tahun');
                $nomor = $this->input->post('nomor');
                $tahun = $this->input->post('tahun');
                $cek_nomor = $this->db->get_where("tbl_raperdes", array('nomor' => "$nomor", 'tahun' => "$tahun"));
                if ($id_nomor != $nomor or $id_tahun != $tahun) {
                  if ($cek_nomor->row()->nomor == $nomor) {
                    if ($cek_nomor->num_rows() != 0) {
                      $this->session->set_flashdata('msg',
                        '
                        <div class="alert alert-warning alert-dismissible" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                           </button>
                           <strong>Gagal!</strong> Maaf, Nomor <b>"'.$nomor.'"</b> dan Tahun <b>"'.$tahun.'"</b> sudah ada!.
                        </div>'
                      );
                      redirect('admin/c_perencanaan/edit_raperdes/'.$id);
                    }
                  }
                }

                  $data = array(
                    'nomor'              => $nomor,
                    'tahun'              => $tahun,
                    'ditetapkan_tgl'     => $this->input->post('ditetapkan_tgl'),
                    'uraian'             => $this->input->post('uraian'),
                    'jumlah'             => $this->input->post('jumlah'),
                    'satuan'             => $this->input->post('satuan'),
                    'harga'              => preg_replace('/[Rp. ]/', '', $this->input->post('harga')),
                    'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
                    'keterangan'         => $this->input->post('keterangan'),
                    'tgl_raperdes'       => date('d-m-Y')
                  );
                  $this->db->update("tbl_raperdes", $data, array('id_raperdes' => "$id"));
                  $this->session->set_flashdata('msg',
                    '
                    <div class="alert alert-success alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                       </button>
                       <strong>Sukses!</strong> Berhasil diupdate.
                    </div>'
                  );
              }
              redirect('admin/c_perencanaan/raperdes');

            }
          }

          function hapus_raperdes($id='') {
            $session['hasil'] = $this->session->userdata('logged_in');
            $role = $session['hasil']->role;
            if($this->session->userdata('logged_in') AND $role == 'Administrator')
            {
                    $this->db->delete("tbl_raperdes", array('id_raperdes' => "$id"));
                    $this->session->set_flashdata('msg',
                      '
                      <div class="alert alert-success alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                         </button>
                         <strong>Sukses!</strong> Berhasil dihapus.
                      </div>'
                    );
                    redirect('admin/c_perencanaan/raperdes');
            }
          }

          function print_raperdes($id='') {
              $data['page_title'] = 'DATA RAPERDES';
              if ($id!='') {
                $this->db->like('tgl_raperdes', "$id", 'before');
              }
              $this->db->order_by('id_raperdes', 'DESC');
              $data['v_data'] = $this->db->get('tbl_raperdes');
              $this->load->view('perencanaan/raperdes/v_print', $data);
          }


          function apb_desa($aksi='',$id='')    {
          $session['hasil'] = $this->session->userdata('logged_in');
          $role = $session['hasil']->role;
          if($this->session->userdata('logged_in') AND $role == 'Administrator')
          {
            if ($aksi == 'add') {
              $this->add_apb_desa();
            }elseif ($aksi == 'print') {
              $this->print_apb_desa();
            }else {
              $this->lists_apb_desa();
            }
          }else
            redirect('c_login', 'refresh');

          }

          function lists_apb_desa() {
              $data['page_title'] = 'DANA CADANGAN';
              $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_apb_desa.id_kegiatan');
              $this->db->order_by('id_apb_desa', 'DESC');
              $data['v_data'] = $this->db->get('tbl_apb_desa');
              $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
              $data['content'] = $this->load->view('perencanaan/apb_desa/v_list', $data, TRUE);
              $this->load->view('utama', $data);
          }

          function add_apb_desa(){
          $session['hasil'] = $this->session->userdata('logged_in');
          $role = $session['hasil']->role;
          if($this->session->userdata('logged_in') AND $role == 'Administrator')
          {
            $data['page_title'] = 'TAMBAH DANA CADANGAN';
            $this->db->order_by('nama_kegiatan', 'ASC');
            $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
            $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
            $data['content'] = $this->load->view('perencanaan/apb_desa/v_tambah', $data, TRUE);
            $this->load->view('utama', $data);
          }else
            redirect('c_login', 'refresh');

          }

          function simpan_apb_desa() {
            $session['hasil'] = $this->session->userdata('logged_in');
            $role = $session['hasil']->role;
            if($this->session->userdata('logged_in') AND $role == 'Administrator')
            {
                    if (isset($_POST['simpan'])) {
                      $tahun = $this->input->post('tahun');
                      if ($this->db->get_where("tbl_apb_desa", array('tahun' => "$tahun"))->num_rows() != 0) {
                        $this->session->set_flashdata('msg',
                          '
                          <div class="alert alert-warning alert-dismissible" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                             </button>
                             <strong>Gagal!</strong> Maaf, dan Tahun <b>"'.$tahun.'"</b> sudah ada!.
                          </div>'
                        );
                        redirect('admin/c_perencanaan/apb_desa/add');
                      }
                        $data = array(
                          'tahun'              => $tahun,
                          'nama_apb'           => $this->input->post('nama_apb'),
                          'id_kegiatan'        => $this->input->post('id_kegiatan'),
                          'uraian'             => $this->input->post('uraian'),
                          'jumlah'             => $this->input->post('jumlah'),
                          'anggaran'              => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
                          'tgl_apb_desa'       => date('d-m-Y')
                        );
                        $this->db->insert("tbl_apb_desa", $data);
                        $this->session->set_flashdata('msg',
                          '
                          <div class="alert alert-success alert-dismissible" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                             </button>
                             <strong>Sukses!</strong> Berhasil ditambah.
                          </div>'
                        );
                    }
                    redirect('admin/c_perencanaan/apb_desa');
            }else
              redirect('c_login', 'refresh');
          }

            function edit_apb_desa($id=''){
                $session['hasil'] = $this->session->userdata('logged_in');
                $role = $session['hasil']->role;
                if($this->session->userdata('logged_in') AND $role == 'Administrator')
                {
                  $data['hasil'] = $this->db->get_where("tbl_apb_desa", array('id_apb_desa' => "$id"))->row();
                  $data['page_title'] = 'EDIT DANA CADANGAN';
                  $this->db->order_by('nama_kegiatan', 'ASC');
                  $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
                  $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
                  $data['content'] = $this->load->view('perencanaan/apb_desa/v_ubah', $data, TRUE);

                  $this->load->view('utama', $data);
                }else
                  redirect('c_login', 'refresh');
            }


            function update_apb_desa() {
              $session['hasil'] = $this->session->userdata('logged_in');
              $role = $session['hasil']->role;
              if($this->session->userdata('logged_in') AND $role == 'Administrator')
              {
                if (isset($_POST['simpan'])) {
                $id = $this->input->post('id');
                    $data = array(
                          'tahun'              => $this->input->post('tahun'),
                          'nama_apb'           => $this->input->post('nama_apb'),
                          'id_kegiatan'        => $this->input->post('id_kegiatan'),
                          'jumlah'             => $this->input->post('jumlah'),
                          'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
                          'tgl_apb_desa'       => $this->input->post('tgl_apb_desa')
                    );
                    $this->db->update("tbl_apb_desa", $data, array('id_apb_desa' => "$id"));
                    $this->session->set_flashdata('msg',
                      '
                      <div class="alert alert-success alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                         </button>
                         <strong>Sukses!</strong> Berhasil diupdate.
                      </div>'
                    );
                }
                redirect('admin/c_perencanaan/apb_desa');

              }
            }

            function hapus_apb_desa($id='') {
              $session['hasil'] = $this->session->userdata('logged_in');
              $role = $session['hasil']->role;
              if($this->session->userdata('logged_in') AND $role == 'Administrator')
              {
                      $this->db->delete("tbl_apb_desa", array('id_apb_desa' => "$id"));
                      $this->session->set_flashdata('msg',
                        '
                        <div class="alert alert-success alert-dismissible" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                           </button>
                           <strong>Sukses!</strong> Berhasil dihapus.
                        </div>'
                      );
                      redirect('admin/c_perencanaan/apb_desa');
              }
            }

            function print_apb_desa($id='') {
                $data['page_title'] = 'PEMBIAYAAN DESA';
                if ($id!='') {
                  $this->db->like('tgl_apb_desa', "$id", 'before');
                }
                $this->db->order_by('id_apb_desa', 'DESC');
                $data['v_data'] = $this->db->get('tbl_apb_desa');
                $this->load->view('perencanaan/apb_desa/v_print', $data);
            }
}
?>
