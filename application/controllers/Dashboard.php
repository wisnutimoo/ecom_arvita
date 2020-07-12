<?php
class Dashboard extends CI_Controller
{

	public function index()

	{		//START PAGINATION
		$config['base_url']	= site_url('Dashboard/index');
		$config['total_rows']	= $this->db->count_all('tb_barang');
		$config['per_page']		= 5;
		$config['uri_segment']	= 3;
		$choice 				= $config["total_rows"] / $config["per_page"];
		$config["num_links"]	= floor($choice);

		$config['first_link']	= 'First';
		$config['last_link']	= 'Last';
		$config['next_link']	= 'Next';
		$config['prev_link']	= 'Prev';

		$config['full_tag_open']	= '<div class="pagging text-center"><nav><ul class ="pagination justify-content-center">';
		$config['full_tag_close']	= ' </ul></nav></div> ';

		$config['num_tag_open']		= '<li class ="page-item"><span class="page-link">';
		$config['num_tag_close']	= '</span></li>';

		$config['cur_tag_open']		= '<li class ="page-item active"><span class="page-link">';
		$config['cur_tag_close']	= '</span></li>';

		$config['next_tag_open'] 	= '<li class ="page-item "><span class="page-link">';
		$config['next_tagl_close']	= '<span aria-hidden ="true">&raquo </span></span></li>';

		$config['prev_tag_open'] 	= '<li class ="page-item "><span class="page-link">';
		$config['prev_tagl_close']	= '</span> Next </li>';

		$config['first_tag_open'] 	= '<li class ="page-item "><span class="page-link">';
		$config['first_tagl_close']	= '</span></li>';

		$config['last_tag_open'] 	= '<li class ="page-item "><span class="page-link">';
		$config['last_tagl_close']	= '</span></li>';


		$this->pagination->initialize($config);
		$data['page']	= ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['barang'] = $this->model_barang->tampil_data($config["per_page"], $data['page'])->result();
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar ');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');

		//END PAGINATION
	}

	public function tambah_ke_keranjang($id)
	{
		$barang = $this->model_barang->find($id);
		$data = array(
			'id'      	=> $barang->id_brg,
			'qty'     	=> 1,
			'price'   	=> $barang->harga,
			'name'    	=> $barang->nama_brg

		);

		$this->cart->insert($data);
		redirect(base_url("index.php/dashboard"));
	}

	public function detail_keranjang()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('keranjang');
		$this->load->view('templates/footer');
	}

	public function hapus_keranjang()
	{
		$this->cart->destroy();
		redirect(base_url("index.php/dashboard"));
	}

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('role_id') != '2') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
			Silahkan Login!
		 </div>');
			redirect('auth/login');
		}
	}

	public function pembayaran()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('pembayaran');
		$this->load->view('templates/footer');
	}

	public function proses_pemesanan()
	{
		$is_proses = $this->model_invoice->index();
		if ($is_proses) {
			$this->cart->destroy();
			$this->load->view('templates/header');
			$this->load->view('templates/sidebar');
			$this->load->view('proses_pemesanan');
			$this->load->view('templates/footer');
		} else {
			echo "Maaf pesanan anda gagal diproses!";
		}
	}

	public function detail($id_brg)
	{
		$data['barang'] = $this->model_barang->detail_brg($id_brg);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('detail_barang', $data);
		$this->load->view('templates/footer');
	}

	public function search()
	{
		$keyword = $this->input->post('keyword');
		$data['barang'] = $this->model_barang->get_keyword($keyword);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}
