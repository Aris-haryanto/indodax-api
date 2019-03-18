<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TradeController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->library('sendapi');
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function index() {

		$csrf = array(
	            'name' => $this->security->get_csrf_token_name(),
	            'hash' => $this->security->get_csrf_hash()
	    );

		$this->load->template('home', array('data' => $this->sendapi->post('getInfo'),
												'pending' => $this->checkOpenOrders(),
												'csrf' => $csrf,
												'error' => $this->session->flashdata('error'),
											));
	}

	public function checkOpenOrders() {
		$data = array(
						'pair' => '',
					);

		return $this->sendapi->post('openOrders', $data);
	}

	public function cancelOrder() {
		$data = array(
						'pair' => $this->input->get('pair'),
						'order_id' => $this->input->get('order_id'),
						'type' => $this->input->get('type'),
					);
		
		$this->sendapi->post('cancelOrder', $data);

		return redirect('/');
	}

	public function trading() {
		$idr = 0;
		$btc = 0;
		if($this->input->post('type') === 'buy'){
			$idr = $this->input->post('amount');
		}else{
			$btc = $this->input->post('amount');
		}
		$data = array(
						'pair' => $this->input->post('pair'), //btc_idr
						'type' => $this->input->post('type'), //sel/buy
						'price' => $this->input->post('price'), //price coinnya
						'idr' => $idr, //jumlah idrnya kalo mau beli bitcoin
						'btc' => $btc, //jumlah bitcoinnya kalo mau jual
					);
		
		$response = $this->sendapi->post('trade', $data);
		if($response['success'] === 0){
			$this->session->set_flashdata('error', $response['error']);
		}

		return redirect('/');
	}

}
