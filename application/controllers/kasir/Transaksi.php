<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_login');
		$this->load->model('m_crud');
		$this->load->model('m_akun');
		$this->load->model('m_anggota');
		$this->load->model('m_transaksi');
		$this->load->model('m_simpanan');

		if($this->is_not_login()){
			redirect(base_url('kasir/login'));
		}

        if($this->is_not_kasir()){
			show_404();
		}
    }

	public function index()
	{
		$data["title"]			= "Data Transaksi";
		$data['wajib']		= $this->m_simpanan->tampil_data_kasir('wajib')->result();
		$data['sukarela']	= $this->m_simpanan->tampil_data_kasir('sukarela')->result();
		$this->load->view('kasir/head',$data);
		$this->load->view('kasir/menu',$data);
		$this->load->view('kasir/simpanan',$data);
		$this->load->view('kasir/footer',$data);
	}
	
	public function baru($a=NULL)
	{
		$data["title"]			= "Data Pembayaran";
		if(isset($_POST['tombolkode'])){
			$kodeunik			= $_POST['kode'];
			if($this->m_transaksi->edit_data($kodeunik)->num_rows() > 0){
			    $data['transaksi']	= $this->m_transaksi->edit_data($kodeunik)->result();
    			foreach($this->m_transaksi->edit_data($kodeunik)->result() as $b)
    			{
    				$id_transaksi	= $b->id;
    				$data['status']	= $b->status_trx;
    				$data['total']	= $b->harga_total;
    				$data['id']	    = $b->id;
    			}
    			$data['detail']		= $this->m_transaksi->tampil_detail($id_transaksi)->result();
    			$data['kodeunik']	= $kodeunik;
    			$this->load->view('kasir/head',$data);
    			$this->load->view('kasir/menu',$data);
    			$this->load->view('kasir/transaksi-detail',$data);
    			$this->load->view('kasir/footer',$data);
			}
			else{
			    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Gagal !</strong> Transaksi tidak dikenal.</div>');
			    redirect(base_url('kasir/transaksi/baru'));
			}
			
		}else{
		    if(!empty($a)){
		        $id_transaksi		= $a;
			    $data['transaksi']	= $this->m_transaksi->edit_data2($id_transaksi)->result();
    			foreach($this->m_transaksi->edit_data2($id_transaksi)->result() as $b)
    			{
    				$kodeunik	    = $b->kodeunik;
    				$data['status']	= $b->status_trx;
    				$data['total']	= $b->harga_total;
				    $data['id']	    = $b->id;
    			}
    			$data['detail']		= $this->m_transaksi->tampil_detail($a)->result();
    			$data['kodeunik']	= $kodeunik;
    			$this->load->view('kasir/head',$data);
    			$this->load->view('kasir/menu',$data);
    			$this->load->view('kasir/transaksi-detail',$data);
    			$this->load->view('kasir/footer',$data);
		    }
		    else{
		        $this->load->view('kasir/head',$data);
    			$this->load->view('kasir/menu',$data);
    			$this->load->view('kasir/transaksi-baru',$data);
    			$this->load->view('kasir/footer',$data);
		    }
		}
	}
	
	public function konfirmasi($a)
	{
	    $data                   = array(
	                            'status_trx' => 'selesai',
	                            'id_admin' => $this->session->userdata('sehat_dkk@id_user')
        );
        
        $where                  = array(
                                'id' => $a
        );
		$this->m_crud->update_data('tbl_transaksi',$data,$where);
		redirect(base_url('kasir/transaksi/baru/'.$a));
	}
	
	public function saldo()
	{
		$data["title"]		= "Data Pembayaran";
		$this->load->view('kasir/head',$data);
		$this->load->view('kasir/menu',$data);
		$this->load->view('kasir/pengisian-saldo',$data);
		$this->load->view('kasir/footer',$data);
	}
	
	public function aksi_saldo()
	{
		$id_user			= $_POST['id_user'];
		$tanggal			= $_POST['tanggal'].' '.date('H:i:s');
		$nominal			= str_replace(".", "", $_POST['nominal']);
		$id_admin			= $this->session->userdata('sehat_dkk@id_user');
		$simpanan			= $_POST['simpanan'];

		switch ($simpanan) {
			case '1':
				$sukarela	= array(
							'id_user' => $id_user,
							'tanggal' => $tanggal,
							'nominal' => $nominal,
							'id_admin' => $id_admin,
							'periode' => date('Y')
				);

				$this->m_crud->tambah_data($sukarela,'tbl_sim_sukarela');

				$riwayat	= array(
							'judul' => 'Pembayaran',
							'deskripsi' => 'Simpanan Sukarela Rp. '.$nominal,
							'nominal' => $nominal,
							'tanggal' => $tanggal,
							'id_user'  => $id_user,
							'id_admin' =>  $id_admin,
							'keterangan' => 'tunai'
				);
				$this->m_crud->tambah_data($riwayat,'tbl_riwayat');

				$notifikasi	= array(
							'id_user' => $id_user,
							'keterangan' => 'Simpanan Sukarela Rp. '.$nominal,
							'judul' => 'Pembayaran',
							'status' => 'Y',
							'tanggal' => $_POST['tanggal']
				);
				$this->m_crud->tambah_data($notifikasi,'tbl_notif');
				$id_simpanan	= $this->db->query("SELECT id_simpanan FROM tbl_sim_sukarela WHERE id_user = '$id_user' AND tanggal = '$tanggal' ORDER BY id_simpanan DESC LIMIT 1")->row()->id_simpanan;
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Gagal !</strong> Transaksi tidak dikenal.</div>');
				redirect(base_url('kasir/transaksi/cetak/sukarela/'.$id_simpanan));

				break;
			
			case '2':
				$wajib		= array(
							'id_user' => $id_user,
							'tanggal' => $tanggal,
							'nominal' => $nominal,
							'id_admin' => $id_admin,
							'periode' => date('Y')
				);

				$this->m_crud->tambah_data($wajib,'tbl_sim_wajib');

				$riwayat	= array(
							'judul' => 'Pembayaran',
							'deskripsi' => 'Simpanan Wajib Rp. '.$nominal,
							'nominal' => $nominal,
							'tanggal' => $tanggal,
							'id_user'  => $id_user,
							'id_admin' =>  $id_admin,
							'keterangan' => 'tunai'
				);
				$this->m_crud->tambah_data($riwayat,'tbl_riwayat');

				$notifikasi	= array(
							'id_user' => $id_user,
							'keterangan' => 'Simpanan Wajib Rp. '.$nominal,
							'judul' => 'Pembayaran',
							'status' => 'Y',
							'tanggal' => $_POST['tanggal']
				);
				$this->m_crud->tambah_data($notifikasi,'tbl_notif');
				$id_simpanan	= $this->db->query("SELECT id_simpanan FROM tbl_sim_wajib WHERE id_user = '$id_user' AND tanggal = '$tanggal' ORDER BY id_simpanan DESC LIMIT 1")->row()->id_simpanan;
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Berhasil !</strong> Transaksi tidak dikenal.</div>');
				redirect(base_url('kasir/transaksi/cetak/wajib/'.$id_simpanan));
				break;
			
			default:
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Berhasil !</strong> Transaksi tidak dikenal.</div>');
				redirect(base_url('kasir/transaksi/baru'));
				break;
		}	
	}

	public function pengambilan()
	{
		$data["title"]		= "Data Transaksi";
		$this->load->view('kasir/head',$data);
		$this->load->view('kasir/menu',$data);
		$this->load->view('kasir/404',$data);
		$this->load->view('kasir/footer',$data);
    }

	public function cari_anggota()
	{
		if (isset($_GET['term'])) {
			$a				= $_GET['term'];
		  	$b 				= $this->m_anggota->cari_anggota($a);
		   	if (count($b) > 0) {
		    foreach ($b as $c)
		     	$data[]	 	= array(
							'id_user' => $c->id_user,
							'label' => $c->no_anggota,
							'nama' => $c->nama,
							'kelurahan' => $c->kelurahan,
							'kecamatan' => $c->kecamatan,
							'rt' => $c->rt,
							'rw' => $c->rw
				);
		     	echo json_encode($data);
		   	}
		}
	}
	
	public function export()
	{
		$data["title"]		= "Data Transaksi";
		$this->load->view('kasir/head',$data);
		$this->load->view('kasir/menu',$data);
		$this->load->view('kasir/404',$data);
		$this->load->view('kasir/footer',$data);
    }
	
	public function cetak($a,$b)
	{
		$data['kasir']      = $this->session->userdata('sehat_dkk@id_user');
		switch ($a) {
			case 'transaksi':
				$kodeunik			= $b;
				$data['transaksi']	= $this->m_transaksi->edit_data($kodeunik)->result();
				foreach($this->m_transaksi->edit_data($kodeunik)->result() as $b)
				{
					$id_transaksi	= $b->id;
					$data['id_user']= $b->no_anggota;
					$data['nama']	= $b->nama;
					$data['status']	= $b->status_trx;
					$data['total']	= $b->harga_total;
				}
				$data['cetail']		= $this->m_transaksi->tampil_detail($id_transaksi)->result();
				$data['kasir']		= $this->session->userdata('sehat_dkk@id_user');
				$this->load->view('kasir/cetak-transaksi',$data);
				break;
			case 'sukarela':
			    $data['keterangan'] = 'Pembayaran Simp. Sukarela';
				$data['cetak']		= $this->m_simpanan->edit_data($a,$b)->result();
				$this->load->view('kasir/cetak-simpanan',$data);
				break;
			case 'wajib':
			    $data['keterangan'] = 'Pembayaran Simp. Wajib';
				$data['cetak']		= $this->m_simpanan->edit_data($a,$b)->result();
				$this->load->view('kasir/cetak-simpanan',$data);
				break;

			case 'simpanan':
				if($b == 'sukarela'){
					$data['kasir']	= $this->session->userdata('sehat_dkk@id_user');
					$data['cetak']	= $this->m_simpanan->tampil_data_kasir('sukarela')->result();
					$this->load->view('kasir/cetak-riwayat-sukarela',$data);
				}else{
					$data['kasir']	= $this->session->userdata('sehat_dkk@id_user');
					$data['cetak']	= $this->m_simpanan->tampil_data_kasir('wajib')->result();
					$this->load->view('kasir/cetak-riwayat-wajib',$data);
				}
				break;
				
			case 'belanja':
		        $id_transaksi		= $b;
			    $data['transaksi']	= $this->m_transaksi->edit_data2($id_transaksi)->result();
    			foreach($this->m_transaksi->edit_data2($id_transaksi)->result() as $c)
    			{
    				$kodeunik	    = $c->kodeunik;
    				$data['status']	= $c->status_trx;
    				$data['total']	= $c->harga_total;
				    $data['id']	    = $c->id;
				    $data['id_user']= $c->id_user;
				    $data['nama']   = $c->nama;
    			}
    			$data['kasir']      = $this->session->userdata('sehat_dkk@id_user');
    			$data['detail']		= $this->m_transaksi->tampil_detail($id_transaksi)->result();
    			$data['kodeunik']	= $kodeunik;
				$this->load->view('kasir/cetak-transaksi',$data);
				break;
				
			default:
				show_404();
				break;
		}
	}
}