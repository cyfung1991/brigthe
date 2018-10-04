<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Product_model');
	}

	// Product list page
	public function index( $page = 1, $sort_by = "product_id", $order="ASC" ){
		// Record per page
		$record = 10;
		$result_arr = $this->_get_product_list($page, $record, $sort_by, $order);

		// JS library
		$data['js'] = array('product_list');
		// Css library
		$data['css'] = array('product_list');
		// Total page of product
		$total_page = ceil($result_arr['total'] / $record);
		$data['page_title'] = "Product List";
		$data['current_page'] = $page;
		$data['total_page'] = $total_page;
		$data['records_per_page'] = $record;
		$data['result'] = $result_arr['records'];

		$data['sort_by'] = $sort_by;
		$data['order'] = $order;
		$this->load->view('product/list', $data);
	}

	// Create product page
	public function create_product(){
		$data['page_title'] = "Create product";
		$data['api_link'] = "product/api_create";
		$data['js'] = array('product_create');
		// No any info in create
		$data['product_info'] = array();

		$this->load->view('product/product_form', $data);
	}

	// Edit product page
	public function edit_product( $product_id = 0 ){
		if( $product_id <= 0 ){
			// No this product
			$this->_p_show_error('Product error', 'Please check your product id');
			return;
		}
		$product_detail = $this->Product_model->get_product_details( $product_id );
		if( count($product_detail) <= 0 ){
			$this->_p_show_error('Product error', 'Database no this product id');
			return;
		}
		if( (int)$product_detail[0]['status'] === 0 ){
			$this->_p_show_error('Product error', 'This product is deleted');
			return;
		}
		$data['page_title'] = "Edit product";
		$data['api_link'] = "product/api_edit";
		$data['js'] = array('product_edit');
		$data['product_info'] = $product_detail;

		$this->load->view('product/product_form', $data);
	}

	// Product view page
	public function view_product( $product_id = 0 ){
		if( $product_id <= 0 ){
			// No this product
			$this->_p_show_error('Product error', 'Please check your product id');
			return;
		}
		$product_detail = $this->Product_model->get_product_details( $product_id );
		if( count($product_detail) <= 0 ){
			$this->_p_show_error('Product error', 'Database no this product id');
			return;
		}
		if( (int)$product_detail[0]['status'] === 0 ){
			$this->_p_show_error('Product error', 'This product is deleted');
			return;
		}
		$data['page_title'] = "View product | ".$product_detail[0]['name'];
		$data['js'] = array('product_edit');
		$data['product_info'] = $product_detail[0];

		$this->load->view('product/product_view', $data);
	}

	// Private for redirect only and show msg
	private function _p_show_error( $title = "", $msg = "" ){
		$data['title'] = $title;
		$data['msg'] = $msg;
		$this->load->view('product/f_error', $data);
	}

	public function api_create() {
		$return_arr = array(
			'isError' => TRUE,
			'msg' => ""
		);

		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|min_length[4]|xss_clean|greater_than[0]');
		$this->form_validation->set_rules('desc', 'Description', 'trim|required|min_length[4]|xss_clean');
		if (empty($_FILES['image']['name']))
		{
		    $this->form_validation->set_rules('userfile', 'Image', 'required');
		}
		if ($this->form_validation->run() == FALSE){
			$return_arr['isError'] = TRUE;
			$return_arr['msg'] = validation_errors();
		}else{
			$config['upload_path']   = $this->config->item('upload_path');
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 1024;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('image')) {
				$return_arr['isError'] = TRUE;
				$return_arr['msg'] = $this->upload->display_errors();
			}else{
				$pic_data = $this->upload->data();
				$data_arr = array(
					'name' => $data['name'],
					'price' => $data['price'],
					'desc' => $data['desc'],
					'pic_path' => $pic_data['file_name'],
					'date_create' => date("Y-m-d H:i:s"),
					'date_update' => date("Y-m-d H:i:s"),
					'status' => 1
				);
				$result = $this->Product_model->insert_product( $data_arr );

				$return_arr['isError'] = FALSE;
				$return_arr['msg'] = "Success";
			}
		}
		echo json_encode($return_arr);
	}

	public function api_edit() {
		$return_arr = array(
			'isError' => TRUE,
			'msg' => ""
		);
		$this->security->xss_clean($this->input->post());
		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|min_length[4]|xss_clean|greater_than[0]');
		$this->form_validation->set_rules('desc', 'Description', 'trim|required|min_length[4]|xss_clean');

		if ($this->form_validation->run() == FALSE){
			$return_arr['isError'] = TRUE;
			$return_arr['msg'] = validation_errors();
		}else{
			$config['upload_path']   = $this->config->item('upload_path');
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 1024;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if (empty($_FILES['image']['name'])){
				$data_arr = array(
					'name' => $data['name'],
					'price' => $data['price'],
					'desc' => $data['desc'],
					'date_update' => date("Y-m-d H:i:s"),
				);
				// Get product id
				$http_ref = strtoupper($_SERVER['HTTP_REFERER']);
				// Remove domain
				$http_ref = str_replace(strtoupper(base_url()), "", $http_ref);
				$http_ref = str_replace("PRODUCT/EDIT_PRODUCT", "", $http_ref);
				$http_ref = str_replace("/", "", $http_ref);
				$product_id = $http_ref;

				$result = $this->Product_model->update_product( $data_arr, $product_id );

				$return_arr['isError'] = FALSE;
				$return_arr['msg'] = "Success";
			}else{
				if ( !$this->upload->do_upload('image')) {
					$return_arr['isError'] = TRUE;
					$r = $this->upload->do_upload('image');
					echo "1";
					var_dump($r);
					$return_arr['msg'] = $this->upload->display_errors();
				}else {
					$pic_data = $this->upload->data();
					$data_arr = array(
						'name' => $data['name'],
						'price' => $data['price'],
						'desc' => $data['desc'],
						'pic_path' => $pic_data['file_name'],
						'date_update' => date("Y-m-d H:i:s"),
					);
					// Get product id
					$http_ref = strtoupper($_SERVER['HTTP_REFERER']);
					// Remove domain
					$http_ref = str_replace(strtoupper(base_url()), "", $http_ref);
					$http_ref = str_replace("PRODUCT/EDIT_PRODUCT", "", $http_ref);
					$http_ref = str_replace("/", "", $http_ref);
					$product_id = $http_ref;

					$result = $this->Product_model->update_product( $data_arr, $product_id );

					$return_arr['isError'] = FALSE;
					$return_arr['msg'] = "Success";
				}
			}
		}
		echo json_encode($return_arr);
	}

	public function api_delete(){
		$product_id = $this->security->xss_clean($this->input->post('product_id'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product id', 'trim|required|min_length[1]|xss_clean|greater_than[0]');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|xss_clean');

		$return_arr = array(
			'isError' => TRUE,
			'msg' => "System error(Code: 101)",
		);

		if ($this->form_validation->run() == FALSE){
			$return_arr['isError'] = TRUE;
			$return_arr['msg'] = validation_errors();
		}else{
			$update_arr = array(
				'status' => $status
			);
			$result = $this->Product_model->update_product( $update_arr, $product_id );
			if( $result === TRUE ){
				$return_arr['isError'] = FALSE;
				$return_arr['msg'] = 'Success';
			}
		}
		echo json_encode($return_arr);
	}

	// Get db record
	private function _get_product_list( $page, $record, $sort_by, $order ){
		// $page = get page number
		// $record = get number of record per page, def = 10
		if( $page === 1 ){
			$start_limit = 0;
		}else{
			$start_limit = (int) ($page - 1) * $record;
		}
		$product = $this->Product_model->get_product_list( $start_limit, $record, $sort_by, $order);
		return $product;
	}
}
