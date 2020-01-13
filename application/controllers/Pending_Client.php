<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_Client extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Pending Client';

	}
    //--> It only redirects to the manage pending client page
	public function index()
	{
        if(!in_array('viewPendingClient', $this->permission)) {
			redirect('dashboard', 'refresh');} 

		$this->render_template('pending_client/index', $this->data);
	}

	//--> retrieves information from database and displays specific info in the view 
	public function fetchPendingClientData()
	{
		$result = array('data' => array());

		$data = $this->model_pending_client->getPendingClientData();

		foreach ($data as $key => $value) {

			$buttons = '';

			if(in_array('createClient', $this->permission)) {
                $buttons .= '<a href="'.base_url('pending_client/addClient/'.$value['id']).'" class="btn btn-default"><i class="fa fa-plus"></i></a>';
            }

			if(in_array('updatePendingClient', $this->permission)) {
                $buttons .= '<a href="'.base_url('pending_client/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

            // if(in_array('deletePendingClient', $this->permission)) { 
            //     $buttons .= '<button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            // }

			$result['data'][$key] = array(			
				$value['companyName'],
				$value['trn'],
				$value['clientName'],
				$value['attempts'],
				$value['active'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function addClient($pending_client_id)
	{

	}

	public function update($pending_client_id)
    {
        if(!in_array('updatePendingClient', $this->permission) AND !in_array('viewPendingClient', $this->permission)) {
            redirect('dashboard', 'refresh');}

        if(!$pending_client_id) {redirect('dashboard', 'refresh');}

        $this->form_validation->set_rules('trn', 'trn', 'trim|required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


		if ($this->form_validation->run() == TRUE) 
		{


            //--> The directory where the documents are uploaded is the
            //    same as client register id.  If the user change the
            //    client register id, we must rename the directory

            // if ($this->input->post('directory') !=  $this->input->post('trn'))
            //     {$old_path = "./upload/documents/".$this->input->post('directory');
            //      $new_path = "./upload/documents/".$this->input->post('trn');
            //      rename($old_path, $new_path);
            //      //??? rename also the username of the user client
            //     }

            $data = array(
				'trn' => $this->input->post('trn'),
				'companyName' => $this->input->post('company_name'),
				'clientName' => $this->input->post('clientName'),
				'clientAddress' => $this->input->post('clientAddress'),
				'clientCounty' => $this->input->post('clientCounty'),
				'clientParish' => $this->input->post('clientParish'),
				'clientCity' => $this->input->post('clientCity'),
				'clientContact' => $this->input->post('clientContact'),
				'clientEmail' => $this->input->post('clientEmail'),
				'clientWebsite' => $this->input->post('clientWebsite'),
				'active' => $this->input->post('active'),
                //'directory' => $this->input->post('trn'),
            );

            $update = $this->model_pending_client->update($data, $pending_client_id);

			if($update == true) 
			{
                $msg_error = 'Successfully updated';
                $this->session->set_flashdata('success', $msg_error);
				redirect('pending_client/', 'refresh');
			}
			else 
			{
                $msg_error = 'Error occurred';
                $this->session->set_flashdata('error', $msg_error);
				redirect('pending_client/update/'.$pending_client_id, 'refresh');
			}
        }

        // --> We are in edit of the form, preparation of the drop down list
        //    and reading of the client data

        $client_data = $this->model_pending_client->getPendingClientData($pending_client_id);
        $this->data['client_data'] = $client_data;
        $this->render_template('pending_client/edit', $this->data);

    }

	//--> remove a pending client from the database
	public function remove()
	{
        if(!in_array('deletePendingClient', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $pending_client_id = $this->input->post('pending_client_id');

        $response = array();

        if($pending_client_id) {
            $delete = $this->model_pending_client->remove($pending_client_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the requirement information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
	}

}

?>