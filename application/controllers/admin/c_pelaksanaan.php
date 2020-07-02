<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pelaksanaan extends CI_Controller {
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

  function index() {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      redirect('admin/c_admin');//$this->lists();
    }else redirect('c_login', 'refresh');
  }

  function pls(){
        $data['page_title'] = 'DATA PELAKSANAAN RKA BELANJA';
        $this->db->join('tbl_bidang', 'tbl_bidang.id_bidang=tbl_rka_belanja.id_bidang');
        $this->db->join('tbl_program', 'tbl_program.id_program=tbl_rka_belanja.id_program');
        $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_belanja.id_kegiatan', 'left');
        $this->db->join('ref_dusun', 'ref_dusun.id_dusun=tbl_rka_belanja.id_dusun');
        $this->db->order_by('id_rka_belanja', 'DESC');
        $data['v_data'] = $this->db->get('tbl_rka_belanja');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['content'] = $this->load->view('pelaksanaan/rab/v_list', $data, TRUE);
      $this->load->view('utama', $data);
  }

  //rab
  function rab($aksi='',$id='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if ($aksi == 'add') {
        $this->add_rab();
      }elseif ($aksi == 'print') {
        $this->print_rab();
      }else {
        $this->pls();
      }
    }else redirect('c_login', 'refresh');
  }

  function add_rab(){
    $session['hasil'] = $this->session->userdata('logged_in');
    $data['idp'] = $this->page_model->getId();
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->order_by('id_rka_belanja', 'ASC');
      $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
      $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['content'] = $this->load->view('pelaksanaan/rab/v_tambah', $data, TRUE);
      $this->load->view('utama', $data);
    }else redirect('c_login', 'refresh');
  }

  function simpan_rab() {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
            if (isset($_POST['simpan'])) {
                $data = array(
                  'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
                  // 'id_bidang'          => $this->input->post('id_bidang'),
                  // 'id_program'         => $this->input->post('id_program'),
                  // 'id_kegiatan'        => $this->input->post('id_kegiatan'),
                  // 'pelaksana_kegiatan' => $this->input->post('pelaksana_kegiatan'),
                  // 'tahun'              => $this->input->post('tahun'),
                  // 'id_dusun'           => $this->input->post('id_dusun'),
                  'jml_tim'            => $this->input->post('jml_tim'),
                  // 'tgl_rka_belanja'    => $this->input->post('tgl_rka_belanja'),
                  // 'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
                );
                $this->db->insert("tbl_pelaksanaan", $data);

                // $data = array(
                //   'id_detail'     => $this->input->post('idp'),
                //   'tgl_detail'          => $this->input->post('tgl'),
                //   'keterangan_detail'         => $this->input->post('ket'),
                //   'harga_detail'        => $this->input->post('harga'),
                //   'nota_detail' => $this->input->post('nota'),
                // );
                // $this->db->insert("tbl_detail", $data);
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
            redirect('admin/c_pelaksanaan/rab');
    }else
      redirect('c_login', 'refresh');
  }

  function edit_rab($id=''){
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;
      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
        $data['hasil'] = $this->db->get_where("tbl_pelaksanaan", array('id_rka_belanja' => "$id"))->row();
        $data['detail'] = $this->db->get_where("tbl_detail", array('id_detail' => "$id"))->row();
        $data['page_title'] = 'Rencana Anggaran Biaya';
        $this->db->order_by('id_rka_belanja', 'ASC');
        $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
        $this->db->order_by('nama_bidang', 'ASC');
        $data['v_bidang'] = $this->db->get('tbl_bidang');
        $this->db->order_by('nama_program', 'ASC');
        $data['v_program'] = $this->db->get('tbl_program');
        $this->db->order_by('nama_kegiatan', 'ASC');
        $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
        $this->db->order_by('nama_dusun', 'ASC');
        $data['v_dusun'] = $this->db->get('ref_dusun');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('pelaksanaan/rab/v_ubah', $data, TRUE);

        $this->load->view('utama', $data);
      }else
        redirect('c_login', 'refresh');
  }

  function update_rab() {
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
          $file = UPLOAD_DIR . $id . 'ft1.jpg';
          $file2 = UPLOAD_DIR . $id . 'ft2.jpg';
          $file3 = UPLOAD_DIR . $id . 'ft3.jpg';
          $file4 = UPLOAD_DIR . $id . 'ft4.jpg';
          $success = file_put_contents($file, $data);
          $success = file_put_contents($file2, $data);
          $success = file_put_contents($file3, $data);
          $success = file_put_contents($file4, $data);

          $path = $file;
          $path2 = $file2;
          $path3 = $file3;
          $path4 = $file4;

        
          $data = array(
                'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
                // 'id_bidang'          => $this->input->post('id_bidang'),
                // 'id_program'         => $this->input->post('id_program'),
                // 'id_kegiatan'        => $this->input->post('id_kegiatan'),
                // 'pelaksana_kegiatan' => $this->input->post('pelaksana_kegiatan'),
                // 'tahun'              => $this->input->post('tahun'),
                // 'id_dusun'           => $this->input->post('id_dusun'),id_rka_belanja
                'jml_tim'            => $this->input->post('jml_tim'),
                // 'tgl_rka_belanja'    => $this->input->post('tgl_rka_belanja'),
                // 'anggaran'           => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
          );
          $this->db->update("tbl_pelaksanaan", $data, array('id_rka_belanja' => "$id"));

          $data = array(
                'tgl_detail'          => $this->input->post('tgl'),
                'keterangan_detail'   => $this->input->post('ket'),
                'harga_detail'        => $this->input->post('harga'),
                'nota_detail'         => $this->input->post('nota'),
          );
          $this->db->update("tbl_detail", $data, array('id_detail' => "$id"));
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
      redirect('admin/c_pelaksanaan/rab');

    }
  }

  function hapus_rab($id='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
            $this->db->delete("tbl_pelaksanaan", array('id_rka_belanja' => "$id"));
            $this->db->delete("tbl_detail", array('id_detail' => "$id"));
            $this->session->set_flashdata('msg',
              '
              <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
                  </button>
                  <strong>Sukses!</strong> Berhasil dihapus.
              </div>'
            );
            redirect('admin/c_pelaksanaan/rab');
    }
  }

  function print_rab() {
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->join('tbl_bidang', 'tbl_bidang.id_bidang=tbl_rka_belanja.id_bidang');
      $this->db->join('tbl_program', 'tbl_program.id_program=tbl_rka_belanja.id_program');
      $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_belanja.id_kegiatan');
      $this->db->join('ref_dusun', 'ref_dusun.id_dusun=tbl_rka_belanja.id_dusun');
      $this->db->order_by('id_rka_belanja', 'DESC');
      $data['v_data'] = $this->db->get('tbl_rka_belanja');
      $this->load->view('pelaksanaan/rab/v_print', $data);
  }

  //detail
  function detail($aksi='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if ($aksi == 'add') {
        // var_dump($id);
        $this->add_detail();
      }elseif ($aksi == 'print') {
        $this->print_detail();
      }else {
        $this->lists_detail($aksi);
      }
    }else redirect('c_login', 'refresh');
  }

  function lists_detail($id=''){
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;
      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
        // $data['hasil'] = $this->db->get_where("tbl_pelaksanaan", array('id_pelaksanaan' => "$id"))->row();
        $data['rka'] = $this->db->get_where('tbl_detail',array('id_rka_belanja'=>"$id"));
        $data['page_title'] = 'Rencana Anggaran Biaya';
        $this->db->order_by('id_rka_belanja', 'ASC');
        $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
        $this->db->order_by('nama_bidang', 'ASC');
        $data['v_bidang'] = $this->db->get('tbl_bidang');
        $this->db->order_by('nama_program', 'ASC');
        $data['v_program'] = $this->db->get('tbl_program');
        $this->db->order_by('nama_kegiatan', 'ASC');
        $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
        $this->db->order_by('nama_dusun', 'ASC');
        $data['v_dusun'] = $this->db->get('ref_dusun');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['id'] = $id;
        $data['content'] = $this->load->view('pelaksanaan/rab/detail/v_list', $data, TRUE);

        $this->load->view('utama', $data);
      }else
        redirect('c_login', 'refresh');
  }

  public function add_detail()
  {
    $session['hasil'] = $this->session->userdata('logged_in');
    $data['idp'] = $this->page_model->getId();
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      // var_dump($this->input->post('id_pelaksanaan'));
      // echo $this->input->post('id_pelaksanaan');
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->order_by('id_rka_belanja', 'ASC');
      $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
      $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['id'] = $this->input->post('id_rka_belanja');
      $data['content'] = $this->load->view('pelaksanaan/rab/detail/v_tambah', $data, TRUE);
      $this->load->view('utama', $data);
    }else redirect('c_login', 'refresh');
  }

  public function simpan_detail()
  {   
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if (isset($_POST['simpan'])) {
        $newfile = $this->input->post('image-data', TRUE);
    
        define('UPLOAD_DIR', 'uploads/nota/');
        $img = $newfile;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . date('Ymd') . $this->input->post('id_rka_belanja') . '.jpg';
        $success = file_put_contents($file, $data);
        $path = $file;

        $data = array(
          'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
          'tgl_detail'    => $this->input->post('tgl_detail'),
          'keterangan_detail'  => $this->input->post('barang'),
          'harga_detail'       => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
          'nota_detail'        => $path
        );
        $this->db->insert("tbl_detail", $data);
        $this->session->set_flashdata('msg',
          '<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
              </button>
              <strong>Sukses!</strong> Berhasil ditambah.
          </div>'
        );
      }
      redirect('admin/c_pelaksanaan/detail/'.$this->input->post('id_rka_belanja'));
    }else redirect('c_login', 'refresh');
  }

  public function edit_detail($id='', $idp=''){
    $session['hasil'] = $this->session->userdata('logged_in');
    $data['idp'] = $this->page_model->getId();
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      // var_dump($this->input->post('id_pelaksanaan'));
      // echo $this->input->post('id_pelaksanaan');
      $data['detail'] = $this->db->get_where("tbl_detail", array('id_detail' => "$id"))->row();
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->order_by('id_rka_belanja', 'ASC');
      $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
      $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['id'] = $idp;
      $data['id_detail'] = $id;
      $data['content'] = $this->load->view('pelaksanaan/rab/detail/v_ubah', $data, TRUE);
      $this->load->view('utama', $data);
    }else redirect('c_login', 'refresh');
  }

  public function update_detail(){
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if (isset($_POST['simpan'])) {
        $id = $this->input->post('id');
        $newfile = $this->input->post('image-data', TRUE);
    
        define('UPLOAD_DIR', 'uploads/nota/');
        $img = $newfile;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . date('Ymd') . $this->input->post('id_rka_belanja') . '.jpg';
        $success = file_put_contents($file, $data);
        $path = $file;

        $data = array(
          'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
          'tgl_detail'    => $this->input->post('tgl_detail'),
          'keterangan_detail'  => $this->input->post('barang'),
          'harga_detail'       => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
          'nota_detail'        => $path
        );
        $this->db->update("tbl_detail", $data, array('id_detail' => $this->input->post('id_detail'), 'id_rka_belanja' => $this->input->post('id_rka_belanja')));
        $this->session->set_flashdata('msg',
          '<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
              </button>
              <strong>Sukses!</strong> Berhasil diedit.
          </div>'
        );
      }
      redirect('admin/c_pelaksanaan/detail/'.$this->input->post('id_rka_belanja'));
    }else redirect('c_login', 'refresh');
  }

  function hapus_detail($id='', $idp='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      $this->db->delete("tbl_detail", array('id_detail' => "$id"));
      $this->session->set_flashdata('msg',
        '
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
            </button>
            <strong>Sukses!</strong> Berhasil dihapus.
        </div>'
      );
      redirect('admin/c_pelaksanaan/detail/'.$idp);
    }
  }

  public function print_detail()
  {
    # code...
  }

  //pendapatan
    function pls_pendapatan($aksi='',$id='')    {
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
    }else{
      redirect('c_login', 'refresh');
    }
    }

    function lists_rka_pendapatan() {
         $data['page_title'] = 'DATA PELAKSANAAN PENDAPATAN';
        $this->db->join('tbl_kegiatan', 'tbl_kegiatan.id_kegiatan=tbl_rka_pendapatan.id_kegiatan', 'left');
          $this->db->order_by('id_rka_pendapatan', 'DESC');
        $data['v_data'] = $this->db->get('tbl_rka_pendapatan');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('pelaksanaan/pls_pendapatan/v_list', $data, TRUE);
          $this->load->view('utama', $data);
    }

      //deail pendapatan
    function detail_pnd($aksi='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if ($aksi == 'add') {
        // var_dump($id);
        $this->add_detail_pnd();
      }elseif ($aksi == 'print') {
        $this->print_detail_pnd();
      }else {
        $this->lists_detail_pnd($aksi);
      }
    }else redirect('c_login', 'refresh');
  }

  function lists_detail_pnd($id=''){
      $session['hasil'] = $this->session->userdata('logged_in');
      $role = $session['hasil']->role;
      if($this->session->userdata('logged_in') AND $role == 'Administrator')
      {
        // $data['hasil'] = $this->db->get_where("tbl_pelaksanaan", array('id_pelaksanaan' => "$id"))->row();
        $data['pnd'] = $this->db->get_where('tbl_detail_pendapatan',array('id_rka_pendapatan'=>"$id"));
        $this->db->order_by('id_rka_pendapatan', 'ASC');
        $data['v_rka_pendapatan'] = $this->db->get('tbl_rka_pendapatan');
        $data['page_title'] = 'Rencana Anggaran Biaya';
        $this->db->order_by('nama_kegiatan', 'ASC');
        $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
        $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['id'] = $id;
        $data['content'] = $this->load->view('pelaksanaan/pls_pendapatan/pnd_detail/v_list', $data, TRUE);

        $this->load->view('utama', $data);
      }else
        redirect('c_login', 'refresh');
  }

  public function add_detail_pnd()
  {
    $session['hasil'] = $this->session->userdata('logged_in');
    $data['idp'] = $this->page_model->getId();
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      // var_dump($this->input->post('id_pelaksanaan'));
      // echo $this->input->post('id_pelaksanaan');
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->order_by('id_rka_belanja', 'ASC');
      $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
      $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['id'] = $this->input->post('id_rka_belanja');
      $data['content'] = $this->load->view('pelaksanaan/rab/detail/v_tambah', $data, TRUE);
      $this->load->view('utama', $data);
    }else redirect('c_login', 'refresh');
  }

  public function simpan_detail_pnd()
  {   
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if (isset($_POST['simpan'])) {
        $newfile = $this->input->post('image-data', TRUE);
    
        define('UPLOAD_DIR', 'uploads/nota/');
        $img = $newfile;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . date('Ymd') . $this->input->post('id_rka_belanja') . '.jpg';
        $success = file_put_contents($file, $data);
        $path = $file;

        $data = array(
          'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
          'tgl_detail'    => $this->input->post('tgl_detail'),
          'keterangan_detail'  => $this->input->post('barang'),
          'harga_detail'       => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
          'nota_detail'        => $path
        );
        $this->db->insert("tbl_detail", $data);
        $this->session->set_flashdata('msg',
          '<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
              </button>
              <strong>Sukses!</strong> Berhasil ditambah.
          </div>'
        );
      }
      redirect('admin/c_pelaksanaan/detail/'.$this->input->post('id_rka_belanja'));
    }else redirect('c_login', 'refresh');
  }

  public function edit_detail_pnd($id='', $idp=''){
    $session['hasil'] = $this->session->userdata('logged_in');
    $data['idp'] = $this->page_model->getId();
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      // var_dump($this->input->post('id_pelaksanaan'));
      // echo $this->input->post('id_pelaksanaan');
      $data['detail'] = $this->db->get_where("tbl_detail", array('id_detail' => "$id"))->row();
      $data['page_title'] = 'Rencana Anggaran Biaya';
      $this->db->order_by('id_rka_belanja', 'ASC');
      $data['v_rka_belanja'] = $this->db->get('tbl_rka_belanja');
      $this->db->order_by('nama_bidang', 'ASC');
      $data['v_bidang'] = $this->db->get('tbl_bidang');
      $this->db->order_by('nama_program', 'ASC');
      $data['v_program'] = $this->db->get('tbl_program');
      $this->db->order_by('nama_kegiatan', 'ASC');
      $data['v_kegiatan'] = $this->db->get('tbl_kegiatan');
      $this->db->order_by('nama_dusun', 'ASC');
      $data['v_dusun'] = $this->db->get('ref_dusun');
      $data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
      $data['id'] = $idp;
      $data['id_detail'] = $id;
      $data['content'] = $this->load->view('pelaksanaan/rab/detail/v_ubah', $data, TRUE);
      $this->load->view('utama', $data);
    }else redirect('c_login', 'refresh');
  }

  public function update_detail_pnd(){
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      if (isset($_POST['simpan'])) {
        $id = $this->input->post('id');
        $newfile = $this->input->post('image-data', TRUE);
    
        define('UPLOAD_DIR', 'uploads/nota/');
        $img = $newfile;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . date('Ymd') . $this->input->post('id_rka_belanja') . '.jpg';
        $success = file_put_contents($file, $data);
        $path = $file;

        $data = array(
          'id_rka_belanja'     => $this->input->post('id_rka_belanja'),
          'tgl_detail'    => $this->input->post('tgl_detail'),
          'keterangan_detail'  => $this->input->post('barang'),
          'harga_detail'       => preg_replace('/[Rp. ]/', '', $this->input->post('anggaran')),
          'nota_detail'        => $path
        );
        $this->db->update("tbl_detail", $data, array('id_detail' => $this->input->post('id_detail'), 'id_rka_belanja' => $this->input->post('id_rka_belanja')));
        $this->session->set_flashdata('msg',
          '<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
              </button>
              <strong>Sukses!</strong> Berhasil diedit.
          </div>'
        );
      }
      redirect('admin/c_pelaksanaan/detail/'.$this->input->post('id_rka_belanja'));
    }else redirect('c_login', 'refresh');
  }

  function hapus_detail_pnd($id='', $idp='') {
    $session['hasil'] = $this->session->userdata('logged_in');
    $role = $session['hasil']->role;
    if($this->session->userdata('logged_in') AND $role == 'Administrator')
    {
      $this->db->delete("tbl_detail", array('id_detail' => "$id"));
      $this->session->set_flashdata('msg',
        '
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
            </button>
            <strong>Sukses!</strong> Berhasil dihapus.
        </div>'
      );
      redirect('admin/c_pelaksanaan/detail/'.$idp);
    }
  }

  

}