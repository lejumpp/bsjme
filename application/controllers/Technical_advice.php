<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Technical_advice extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Program Management';
        $this->data['active_tab'] =  $this->input->get('tab') ?: 'technical_advice';
        $this->log_module = 'Program Management';
    }


    //--> It only redirects to the manage technical advice page

    public function index()
    {
        if (!in_array('viewTechnicalAdvice', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['consultant'] = $this->model_user->getActiveConsultant();
        $this->data['activity'] = $this->model_activity->getActiveActivity();

        $this->render_template('technical_advice/index', $this->data);
    }

    //--> It fetches the technical advice data from the technical advice table
    //    This function is called from the datatable ajax function

    public function fetchTechnicalAdviceData()
    {

        $result = array('data' => array());


        //--> For the Profile Consultant, we read only the consultation where they are consultant

        if ($this->session->profile == 3) {
            $consultant = $this->session->user_id;
        } else {
            $consultant = $this->input->get('consultant') ?: NULL;
        }

        if ($consultant <> "all") {
            $consultant = '"' . $consultant . '"';
        }

        $activity = $this->input->get('activity') ?: NULL;

        //--> If the profile is a reader only, he can see all the consultations
        //    but will have only access to the print of the consultation
        if ($this->session->profile == 6) {
            $consultant = 'all';
        }


        //--> If the Profile is a Client, we must read only the consultation of the client
        //    The client trn is the username given to the client to access the system  
        //    If not we will read all the consultation depending on the security given (consultant or coordinator) 

        if ($this->session->profile == 4) {
            $trn = "'" . $this->session->username . "'";
            $data = $this->model_technical_advice->getTechnicalAdviceClient($this->session->client_id);
        } else {

            $data = $this->model_technical_advice->getTechnicalAdviceByConsultant($consultant, $activity);
        }
        foreach ($data as $key => $value) {
            //Retrieve client information such as client name/ business name
            $client_data = $this->model_client->getClientDataById($value['client_id']);

            $program_data = $this->model_program->getProgramData($value['program_id']);

            //--> Prepare the list of consultants to view in the datatable

            $consultant = json_decode($value['consultant_id']);

            $consultant_list = '';
            //--> Get the name of each consultant
            if (!$consultant == null) {
                $count = 0;
                foreach ($consultant as $k => $v) {
                    $consultant_data = $this->model_user->getConsultantData($consultant[$k]);
                    if ($count > 0) {
                        $consultant_list = $consultant_list . ' | ' . $consultant_data['name'];
                    } else {
                        $consultant_list = $consultant_list . ' ' . $consultant_data['name'];
                    }
                    $count++;
                }
            }


            $buttons = '';

            if (in_array('updateTechnicalAdvice', $this->permission)) {
                $buttons .= '<a href="' . base_url('technical_advice/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }
            if (in_array('deleteTechnicalAdvice', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            if (in_array('viewTechnicalAdvice', $this->permission)) {
                // $buttons .= '<a href="'.base_url('technical_advice/timeline/'.$value['id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
                // $buttons .= '<a href="'.base_url('report_consultation/REP0I/'.$value['id']).'" target="_blank"  class="btn btn-default"><i class="fa fa-print"></i></a>';
            }

            $activity = '';

            switch ($value['activity_id']) {
                case '1':
                    $activity = '<span class="label label-success">' . $value['activity_name'] . '</span>';
                    break;
                case '2':
                    $activity = '<span class="label label-warning">' . $value['activity_name'] . '</span>';
                    break;
                case '3':
                    $activity = '<span class="label label-danger">' . $value['activity_name'] . '</span>';
                    break;
            }

            $result['data'][$key] = array(
                $program_data['name'],
                $client_data['company_name'],
                $consultant_list,
                $activity,
                $value['date_created'],
                $buttons
            );
        } // /foreach
        echo json_encode($result);
    }

    public function fetchTechnicalAdvicelient($client_id)
    {
        $result = array('data' => array());
        $data = $this->model_technical_advice->getTechnicalAdviceClient($client_id);
        foreach ($data as $key => $value) {
            $client_data = $this->model_client->getClientDataById($value['client_id']);
            $program_data = $this->model_program->getProgramData($value['program_id']);
            //--> Prepare the list of consultants to view in the datatable
            $consultant = json_decode($value['consultant_id']);
            $consultant_list = '';
            // Get the name of each consultant
            if (!$consultant == null) {
                foreach ($consultant as $k => $v) {
                    $consultant_data = $this->model_user->getConsultantData($consultant[$k]);
                    $consultant_list = $consultant_list . ' ' . $consultant_data['name'];
                }
            }
            $activity = '';

            switch ($value['activity']) {
                case '1':
                    $activity = '<span class="label label-success">' . $value['activity_name'] . '</span>';
                    break;
                case '2':
                    $activity = '<span class="label label-warning">' . $value['activity_name'] . '</span>';
                    break;
                case '3':
                    $activity = '<span class="label label-danger">' . $value['activity_name'] . '</span>';
                    break;
            }
            $buttons = '';
            if (in_array('updateTechnicalAdvice', $this->permission)) {
                $buttons .= '<a href="' . base_url('technical_advice/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteTechnicalAdvice', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-standard="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            // if (in_array('viewTechnicalAdvice', $this->permission)) {
            //     $buttons .= '<a href="' . base_url('report_consultation/REP0I/' . $value['id']) . '" target="_blank"  class="btn btn-default"><i class="fa fa-print"></i></a>';
            // }
            $result['data'][$key] = array(
                $client_data['company_name'],
                $consultant_list,
                $program_data['name'],
                $activity,
                $value['date_created'],
                $buttons
            );
        } //foreach
        echo json_encode($result);
    }

    public function create($id = null)
    {
        if (!in_array('createTechnicalAdvice', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('client', 'Client/Company', 'trim|required');
        $this->form_validation->set_rules('activity', 'Activity', 'trim|required');
        $this->form_validation->set_rules('program', 'Program', 'trim|required');
        $this->form_validation->set_rules('date_created', 'Creation Date', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');

        if ($this->form_validation->run() == TRUE) {
            // true case, we create the new technical advice
            $data = array(
                'client_id' => $this->input->post('client'),
                'consultant_id' => json_encode($this->input->post('consultant')),
                'program_id' => $this->input->post('program'),
                'activity' => $this->input->post('activity'),
                'date_created' => $this->input->post('date_created'),
                'date_begin' => $this->input->post('date_begin'),
                'date_ended' => $this->input->post('date_end'),
                'work_scope' => $this->input->post('work_scope'),
                'updated_by' => $this->session->user_id,
            );
            $technical_advice_id = $this->model_technical_advice->create($data);
            if ($technical_advice_id == false) {
                $msg_error = 'Error occurred in the creation of the technical advice';
                $this->session->set_flashdata('error', $msg_error);
                redirect('technical_advice/create', 'refresh');
            } else {
                //--> Log Action
                $this->model_log->create(array(
                    'user_id' => $this->session->user_id,
                    'module' => $this->log_module,
                    'action' => 'Create',
                    'subject_id' => $technical_advice_id,
                    'client_id' => $this->input->post('client'),
                    'consultation_id' => null,
                    'ta_id' => $technical_advice_id,
                    'remark' => 'Create Technical Advice ' . $technical_advice_id,
                    'attributes' => $data
                ));

                //The create return the consultation_id if it's successful
                // and we can go to the edit pages to continue the treatment of the consultation

                redirect('technical_advice/', 'refresh');
            }
        }

        //--> We are in the preparation of the form and we prepare
        //    the drop-down list needed in the create form
        $this->data['client'] = $this->model_client->getClientData();
        $this->data['activity'] = $this->model_activity->getActiveActivity();
        $this->data['consultant'] = $this->model_user->getActiveConsultant();
        $this->data['program'] = $this->model_program->getActiveProgram();
        //This is for adding a technical advice to the client, coming from the client edit
        $this->data['fromClient'] = $id;

        $this->render_template('technical_advice/create', $this->data);
    }

    public function remove()
    {
        if (!in_array('deleteTechnicalAdvice', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $ta_id = $this->input->post('ta_id');

        $response = '';
        $response = array();

        if ($ta_id) {
            //--> Get the old data before deleting
            //$old_data = $this->model_technical_advice->getTechnicalAdviceData($ta_id);
            $delete = $this->model_technical_advice->remove($ta_id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
                //--> Log Action
                //  $this->model_log->create(array(
                //     'user_id' => $this->session->user_id,
                //     'module' => $this->log_module,
                //     'action' => 'Delete',
                //     'subject_id' => $ta_id,
                //     'client_id' => null,
                //     'consultation_id' => null,
                //     'ta_id' => $ta_id,
                //     'remark' => 'Delete Technical Advice '.$client_id,
                //     'attributes' => $old_data
                // ));
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while deleting the information';
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';
        }

        echo json_encode($response);
    }

    public function update($technical_advice_id)
    {
        //--> the profile having viewConsultation can see the information but cannot update

        if (!in_array('updateTechnicalAdvice', $this->permission) and !in_array('viewTechnicalAdvice', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if (!$technical_advice_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('client', 'Client/Company', 'trim|required');
        $this->form_validation->set_rules('activity', 'Activity', 'trim|required');
        $this->form_validation->set_rules('program', 'Program', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');

        //--->  Validation of the form
        if ($this->form_validation->run() == TRUE) {
            //true case 
            $data = array(
                'client_id' => $this->input->post('client'),
                'consultant_id' => json_encode($this->input->post('consultant')),
                'program_id' => $this->input->post('program'),
                'activity' => $this->input->post('activity'),
                'date_created' => $this->input->post('date_created'),
                'date_begin' => $this->input->post('date_begin'),
                'date_ended' => $this->input->post('date_end'),
                'work_scope' => $this->input->post('work_scope'),
                'updated_by' => $this->session->user_id,
            );
            $update = $this->model_technical_advice->update($data, $technical_advice_id);
            if ($update == true) {
                $msg_error = 'Successfully updated';
                $this->session->set_flashdata('success', $msg_error);
                //--> Log Action to be placed here
                redirect('technical_advice/update/' . $technical_advice_id . "?tab=technical_advice", 'refresh');
            } else {
                $msg_error = 'Error occurred';
                $this->session->set_flashdata('error', $msg_error);
                // redirect('technical_advice/update/' . $technical_advice_id . "?tab=technical_advice", 'refresh');
            }
        }
        //--> We are in edit of the form, preparation of the drop down list
        //    and reading of the technical advice data
        $technical_advice_data = $this->model_technical_advice->getTechnicalAdviceData($technical_advice_id);
        $this->data['technical_advice_data'] = $technical_advice_data;

        //  Here the data for consultant , activity and consultant is loadded
        $this->data['client'] = $this->model_client->getClientData();
        $this->data['activity'] = $this->model_activity->getActiveActivity();
        $this->data['program'] = $this->model_program->getActiveProgram();
        $this->data['consultant'] = $this->model_user->getActiveConsultant();
        $this->data['document_type'] = $this->model_document_type->getActiveDocumentType();
        $this->data['document_class'] = $this->model_document_class->getActiveDocumentClass();
        $this->render_template('technical_advice/edit', $this->data);
    }

    //-----------------------------------------------------------------------------------------------------
    //--                                                                                                 --
    //--                                        D O C U M E N T                                          --
    //--                                                                                                 --
    //-----------------------------------------------------------------------------------------------------


    //--> It fetches the document data from the document table
    //    This function is called from the datatable ajax function

    public function fetchConsultationDocument($id)
    {
        $result = array('data' => array());

        $data = $this->model_technical_advice->getTechnicalAdviceDocument($id);

        foreach ($data as $key => $value) {

            $link = base_url('upload/documents/' . $value['directory'] . '/' . $value['doc_name']);
            $doc_link = '<a href="' . $link . '" target="_blank" >' . ($value['doc_name']) . '</a>';

            $buttons = '';
            if (in_array('viewDocument', $this->permission)) {
                $buttons .= '<a href="' . $link . '" target="_blank" class="btn btn-default"><i class="fa fa-search"></i></a>';
            }

            if (in_array('deleteDocument', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeDocument(' . $value['id'] . ')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></button>';
            }


            $result['data'][$key] = array(
                $doc_link,
                $value['document_type_name'],
                $value['document_class_name'],
                $value['doc_size'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }



    //    This function is invoked from another function to upload the documents into the assets folder
    //    of the client

    public function uploadDocument()
    {

        if (!in_array('updateDocument', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $directory = $this->session->directory;
        $config['upload_path'] = './' . $directory;
        $config['allowed_types'] = 'gif|jpg|png|pdf|xls|xlsx|docx|doc|pptx';
        $config['max_size'] = '4000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('consultation_document')) {
            $msg_error = 'This type of document is not allowed or the document is too large.';
            $this->session->set_flashdata('warning', $msg_error);
            redirect('client/update/' . $this->session->client_id, 'refresh');
        } else {
            //---> Create the document in the table document

            $data = array(
                'client_id' => $this->session->client_id,
                'ta_id' => $this->session->technical_advice_id,
                'doc_size' => $this->upload->data('file_size'),
                'doc_type' => $this->upload->data('file_type'),
                'doc_name' => $this->upload->data('file_name'),
                'document_type_id' => $this->input->post('document_type'),
                'document_class_id' => $this->input->post('document_class'),
                'updated_by' => $this->session->user_id,
            );

            $document_id = $this->model_technical_advice->createDocument($data);

            if ($document_id == true) {
                //--->  Upload the document
                $data = array('upload_data' => $this->upload->data());
                redirect('technical_advice/update/' . $this->session->technical_advice_id . "?tab=document", 'refresh');
            } else {
                $msg_error = 'Error occurred';
                $this->session->set_flashdata('error', $msg_error);
                redirect('technical_advice/', 'refresh');
            }
        }
    }



    public function removeDocument()
    {
        if (!in_array('deleteDocument', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $document_id = $this->input->post('document_id');
        $response = array();

        if ($document_id) {
            //--> Get the link of the document for deleting the document on the directory
            $document_data = $this->model_consultation->getDocument($document_id);
            $doc_link = '/upload/documents/' . $document_data['directory'] . '/' . $document_data['doc_name'];
            unlink(FCPATH . $doc_link);
            //--> Delete the document in the document table
            $delete = $this->model_consultation->removeDocument($document_id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while deleting the information';
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';
        }

        echo json_encode($response);
    }
}
