<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Workplan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Work Plan';
    }

    public function index()
    {
        if (!in_array('viewWorkPlan
            ', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('workplan/index', $this->data);
    }




    // THE UPDATE AND PRINT ICONS ARE HERE

    public function fetchWorkPlanData($id)
    {
        $result = array('data' => array());


        $data = $this->model_workplan->getWorkPlanData_TA($id);

        foreach ($data as $key => $value) {


            $buttons = '';

            if (in_array('updateWorkPlan', $this->permission)) {
                $buttons .= '<a href="' . base_url('workplan/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteWorkPlan', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }


            if (in_array('viewWorkPlan', $this->permission)) {
                $buttons .= '<a href="' . base_url('report_workplan/REP0W/' . $value['id']) . '"target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
            }


            $result['data'][$key] = array(
                $value['major_deliverable'],
                $value['start_date'],
                $value['end_date'],
                $buttons
            );
        } // /foreach
        echo json_encode($result);
    }

    public function fetchWorkPlanDataExpansion($id)
    {
        $result = array('data' => array());


        $data = $this->model_workplan->getWorkPlanData_TA($id);



        foreach ($data as $key => $value) {


            $buttons = '';

            if (in_array('updateWorkPlan', $this->permission)) {
                $buttons .= '<a href="' . base_url('workplan/update/' . $value['id']) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteWorkPlan', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }


            if (in_array('viewWorkPlan', $this->permission)) {
                $buttons .= '<a href="' . base_url('report_workplan/REP0W/' . $value['id']) . '"target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
            }


            $result['data'][$key] = array(
                $value['major_deliverable'],
                $value['start_date'],
                $value['end_date'],
                $value['task'],
                $value['entity'],
                $value['res_off'],
                $buttons
            );
        } // /foreach
        echo json_encode($result);
    }


    public function create()
    {
        if (!in_array('createWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('major_deliverable', 'Major Deliverable', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'EndDate', 'required');



        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');


        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'client_id' => $this->session->client_id,
                'ta_id' => $this->session->technical_advice_id,
                'major_deliverable' => $this->input->post('major_deliverable'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'updated_by' => $this->session->user_id,
            );

            $workplan_id = $this->model_workplan->create($data);
            if ($workplan_id == false) {
                $msg_error = 'Error occurred';
                $this->session->set_flashdata('error', $msg_error);
                redirect('workplan/create', 'refresh');
            } else {
                redirect('workplan/update/' . $workplan_id, 'refresh');
            }
            $this->render_template('workplan/create', $this->data);
        } else {
            // false case     
            // $this->data['workplan'] = $this->model_workplan->getCurrentWorkPlan();  
            $this->render_template('workplan/create', $this->data);
        }
    }

    public function update($id)
    {
        if (!in_array('updateWorkPlan', $this->permission) and !in_array('viewWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        if (!$id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('major_deliverable', 'Major Deliverable', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');

        if ($this->form_validation->run() == TRUE) {
            $wkplan_data = array(
                'major_deliverable' => $this->input->post('major_deliverable'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
            );

            $update = $this->model_workplan->update($wkplan_data, $id);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('workplan/update/' . $this->session->workplan_id, 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('workplan/update/' . $this->session->workplan_id, 'refresh');
            }
        } else {
            $result = array();
            $data_wkplan = $this->model_workplan->getWorkPlanData($id);
            $result['workplan'] = $data_wkplan;
            $this->data['wkplan_data'] = $result;
            $this->render_template('workplan/edit', $this->data);
        }
    }

    public function remove()
    {
        if (!in_array('deleteWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $id = $this->input->post('workplan_id');

        $response = '';
        $response = array();

        if ($id) {
            $delete = $this->model_workplan->remove($id);
            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the Work Plan";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }
        echo json_encode($response);
    }

    //--> Functions related to the workplan task
    public function fetchWorkPlanTaskData($id)
    {
        $result = array('data' => array());
        $data = $this->model_workplan->getWorkPlanTaskData($id);
        foreach ($data as $key => $value) {

            $category_data = $this->model_category->getCategoryData($value['category_id']);
            $status_data = $this->model_status->getWorkPlanStatusById($value['status']);

            $buttons = '';

            if (in_array('updateWorkPlan', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editTask(' . $value['id'] . ')" data-toggle="modal" data-target="#editModalTask"><i class="fa fa-pencil"></i></button>';
            }
            if (in_array('deleteWorkPlan', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModalTask"><i class="fa fa-trash"></i></button>';
            }
            $result['data'][$key] = array(
                $value['task'],
                $category_data['name'],
                $value['s_date'],
                $value['e_date'],
                $status_data['name'],
                $buttons
            );
        } // /foreach
        echo json_encode($result);
    }

    public function addWorkPlanTask()
    {
        if (!in_array('createWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('task', 'Task', 'trim|required');
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');

        $response = array();

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'wid' => $this->session->workplan_id,
                'task' => $this->input->post('task'),
                'category_id' => $this->input->post('category'),
                'entity' => $this->input->post('entity'),
                'responsible_officer' => $this->input->post('responsible_officer'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                's_date' => $this->input->post('s_date'),
                'e_date' => $this->input->post('e_date'),
                'status' => $this->input->post('status')
            );

            $create = $this->model_workplan->createTask($data);

            if ($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function fetchWorkPlanTaskDataById($id)
    {
        if ($id) {
            $data = $this->model_workplan->getWorkPlanTaskById($id);
            echo json_encode($data);
        }
    }

    public function updateWorkPlanTask($id)
    {
        if (!in_array('updateWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $response = array();
        if ($id) {
            $this->form_validation->set_rules('edit_task', 'Task', 'trim|required');
            $this->form_validation->set_rules('edit_category', 'Task', 'trim|required');
            $this->form_validation->set_rules('edit_status', 'Task', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'wid' => $this->session->workplan_id,
                    'task' => $this->input->post('edit_task'),
                    'category_id' => $this->input->post('edit_category'),
                    'entity' => $this->input->post('edit_entity'),
                    'responsible_officer' => $this->input->post('edit_responsible_officer'),
                    'email' => $this->input->post('edit_email'),
                    'phone' => $this->input->post('edit_phone'),
                    's_date' => $this->input->post('edit_s_date'),
                    'e_date' => $this->input->post('edit_e_date'),
                    'status' => $this->input->post('edit_status')
                );

                $update = $this->model_workplan->updateTask($data, $id);

                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully updated';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updating the information';
                }
            }  //end form validation is true
            else   //form validation is false
            {
                $response['successa'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        }  //else no id
        else {
            $response['successb'] = false;
            $response['messages'] = 'Error please refresh the page again';
        }

        echo json_encode($response);
    }

    public function removeTask()
    {
        if (!in_array('deleteWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $task_id = $this->input->post('task_id');

        $response = '';
        $response = array();

        if ($task_id) {
            $delete = $this->model_workplan->removeTask($task_id);
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

    //--> Functions related to the workplan monitoring notes
    public function fetchMonitoringNotes($id)
    {
        $result = array('data' => array());
        $data = $this->model_workplan->getMonitoringNotes($id);
        foreach ($data as $key => $value) {
            $buttons = '';

            // if (in_array('updateWorkPlan', $this->permission)) {
            //     $buttons .= '<button type="button" class="btn btn-default" onclick="editTask(' . $value['id'] . ')" data-toggle="modal" data-target="#editModalTask"><i class="fa fa-pencil"></i></button>';
            // }
            $result['data'][$key] = array(
                $value['notes'],
                $value['date'],
                $value['created_by']
            );
        } // /foreach
        echo json_encode($result);
    }

    public function createMonitoringNote()
    {
        if (!in_array('createWorkPlan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('monitoring_note', 'Nonitoring Note', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">', '</p>');
        $response = array();

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'wid' => $this->session->workplan_id,
                'notes' => $this->input->post('monitoring_note'),
                'created_by' => $this->session->user_id
            );

            $create = $this->model_workplan->createMonitoringNote($data);

            if ($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }
}
