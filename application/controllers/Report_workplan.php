<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Print of a Workplan with all the information related to a specific customer 

class Report_workplan extends Admin_Controller
{
	public function __construct()
	{

		parent::__construct();

		$this->data['page_title'] = 'Report';
	}


	public function REP0W($id) //Display Individual Deliverables and their associated data (tasks and monitoring notes)
	{

		// Orientation (Landscape or Portrait, format, character, keepmargin, )
		// Orientation is not working here but works in AddPage('L')
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

		// Set some basic
		$pdf->SetHeaderMargin(13);
		$pdf->SetTopMargin(23);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$pdf->SetDisplayMode('real', 'default');

		// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
		$this->session->set_flashdata('report_code', 'REP0WP');

		// set font for the report
		$pdf->SetFont('dejavusans', '', 8);

		// Generate HTML table data from MySQL

		$template = array(
			'table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',
			'heading_row_start'   => '<tr bgcolor="rgb(235,235,235)">',
			'heading_row_end'     => '</tr>',
			'heading_cell_start'  => '',
			'heading_cell_end'    => '',
			'row_start'           => '<tr>',
			'row_end'             => '</tr>',
			'cell_start'          => '<td>',
			'cell_end'            => '</td>',
			'row_alt_start'       => '<tr>',
			'row_alt_end'         => '</tr>',
			'cell_alt_start'      => '<td>',
			'cell_alt_end'        => '</td>',
			'table_close'         => '</table>'
		);

		$this->table->set_template($template);


		// This shows the company name
		$REP0WC = $this->model_report->getReportWorkPlanCompany($id);
		// This shows the major deliverable
		$REP0WD = $this->model_report->getReportWorkPlanDeliverable($id);
		// This shows the tasks for the major deliverable
		$REP0WT = $this->model_report->getReportWorkPlanTask($id);
		// This shows the notes for the major deliverable
		$REP0WN = $this->model_report->getReportWorkPlanNote($id);



		//Below is the formating for report. 
		// 3 foreach are used as:
		//1. Major Deliverable only appears once. 
		//2. All notes created are not necesarily tied to a specific task, and can simply be 
		//    commentary related to workplan. 
		//3. Previous join method is not ideal as previous task and work notes appeared side by
		//   side. This gave the impression that a note was related to a speicific task.  This was not 
		//   case.

		$cell1 = array('data' => '<strong>Client</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1);

		foreach ($REP0WC as $rsw) : //Generates the company name

			$cell1 = array('data' => '');
			$this->table->add_row($cell1);

			$cell1 = array('data' => $rsw->company_name, 'width' => '100%');
			$this->table->add_row($cell1);

			$cell1 = array('data' => ''); // adds a blank row
			$this->table->add_row($cell1);

		endforeach;

		// This row is for the title of the Work plan report
		$cell1 = array('data' => '<strong>Major Deliverables</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1); // This is just a blank row to add space between title and content

		foreach ($REP0WD as $rsw) : // Major Deliverable

			$cell1 = array('data' => '');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Major Deliverables:&nbsp;&nbsp;</strong>' . $rsw->major_deliverable, 'width' => '50%');
			$cell2 = array('data' => '<strong>Start Date:&nbsp;&nbsp;</strong>' . $rsw->start_date, 'width' => '25%');
			$cell3 = array('data' => '<strong>End Date:&nbsp;&nbsp;</strong>' . $rsw->end_date, 'width' => '25%');
			$this->table->add_row($cell1, $cell2, $cell3);

			$cell1 = array('data' => ''); // adds a blank row
			$this->table->add_row($cell1);

		endforeach;

		$cell1 = array('data' => '<strong>Tasks</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1); // This is just a blank row to add space between title and content

		foreach ($REP0WT as $rst) : // Tasks

			$cell1 = array('data' => '');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Task:&nbsp;&nbsp;</strong>' . $rst->task, 'width' => '100%');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Entity:&nbsp;&nbsp;</strong>' . $rst->entity, 'width' => '50%');
			$cell2 = array('data' => '<strong>Responsible Officer:&nbsp;&nbsp;</strong>' . $rst->responsible_officer, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);


			$cell1 = array('data' => '<strong>Email:&nbsp;&nbsp;</strong>' . $rst->email, 'width' => '50%');
			$cell2 = array('data' => '<strong>Phone:&nbsp;&nbsp;</strong>' . $rst->phone, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => '<strong>Start Date:&nbsp;&nbsp;</strong>' . $rst->s_date, 'width' => '50%');
			$cell2 = array('data' => '<strong>End Date:&nbsp;&nbsp;</strong>' . $rst->e_date, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => ''); // adds a blank row
			$this->table->add_row($cell1);


		endforeach;

		$cell1 = array('data' => '<strong>Notes</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1); // This is just a blank row to add space between title and content


		foreach ($REP0WN as $rsn) : //Monitoring Notes

			$cell1 = array('data' => '');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Notes:&nbsp;&nbsp;</strong>' . $rsn->notes, 'width' => '100%');
			$this->table->add_row($cell1);

			$cell1 = array('data' => '<strong>Date Posted:&nbsp;&nbsp;</strong>' . $rsn->date, 'width' => '50%');
			$cell2 = array('data' => '<strong>Created by:&nbsp;&nbsp;</strong>' . $rsn->created_by, 'width' => '50%');
			$this->table->add_row($cell1, $cell2);

			$cell1 = array('data' => ''); // adds a blank row
			$this->table->add_row($cell1);
		endforeach;

		//  Generate the table in html format using the table class of codeigniter
		$html = $this->table->generate();

		// Add a page and change the orientation
		$pdf->AddPage('P');

		// Output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
		// (I - Inline, D - Download, F - File)
		$pdf->Output('Report_workplan.pdf', 'I');
	}

	//print the entire workplan with all the associated deliverables and tasks
	public function report_workplan($id)
	{
		// Orientation (Landscape or Portrait, format, character, keepmargin, )
		// Orientation is not working here but works in AddPage('L')
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

		// Set some basic
		$pdf->SetHeaderMargin(13);
		$pdf->SetTopMargin(23);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$pdf->SetDisplayMode('real', 'default');

		// Create a session variable to use the title in the header of tcpdf (library tcpdf / Pdf.php)
		$this->session->set_flashdata('report_code', 'REP0WP');

		// set font for the report
		$pdf->SetFont('dejavusans', '', 8);

		$template = array(
			'table_open'          => '<table border="1" cellpadding="4" cellspacing="0">',
			'heading_row_start'   => '<tr bgcolor="rgb(235,235,235)">',
			'heading_row_end'     => '</tr>',
			'heading_cell_start'  => '',
			'heading_cell_end'    => '',
			'row_start'           => '<tr>',
			'row_end'             => '</tr>',
			'cell_start'          => '<td>',
			'cell_end'            => '</td>',
			'row_alt_start'       => '<tr>',
			'row_alt_end'         => '</tr>',
			'cell_alt_start'      => '<td>',
			'cell_alt_end'        => '</td>',
			'table_close'         => '</table>'
		);

		$this->table->set_template($template);

		// This shows the company name
		$REP0WC = $this->model_report->getWorkPlanClientData($id);
		// This shows the major deliverable
		$REP0WD = $this->model_report->getReportWorkPlanDeliverables($id);


		// var_dump($REP0WD);


		$cell1 = array('data' => '<strong>Client</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1);

		$cell1 = array('data' => $REP0WC['company_name'], 'width' => '100%');
		$this->table->add_row($cell1);

		// This row is for the title of the Work plan report
		$cell1 = array('data' => '<strong>Major Deliverables</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
		$this->table->add_row($cell1); // This is just a blank row to add space between title and content

		foreach ($REP0WD as $rsw) : // Major Deliverable

			// This shows the tasks for the major deliverable
			$REP0WT = $this->model_report->getReportWorkPlanTask($rsw->id);

			$cell1 = array('data' => '<strong>Major Deliverable:&nbsp;&nbsp;</strong>' . $rsw->major_deliverable, 'width' => '50%');
			$cell2 = array('data' => '<strong>Start Date:&nbsp;&nbsp;</strong>' . $rsw->start_date, 'width' => '25%');
			$cell3 = array('data' => '<strong>End Date:&nbsp;&nbsp;</strong>' . $rsw->end_date, 'width' => '25%');
			$this->table->add_row($cell1, $cell2, $cell3);
			$cell1 = array('data' => '<strong>Task(s)</strong>', 'height' => '20', 'width' => '100%', 'bgcolor' => 'rgb(235,235,235)');
			$this->table->add_row($cell1);
			$count = 0;
			// var_dump($REP0WT);
			foreach ($REP0WT as $rst) : //Task for each deliverable
				$status_data = $this->model_status->getStatusData($rst->status);
				$cell1 = array('data' => ++$count . '.', 'width' => '5%');
				$cell2 = array('data' => $rst->task, 'width' => '35%');
				$cell3 = array('data' => $rst->s_date, 'width' => '20%');
				$cell4 = array('data' => $rst->e_date, 'width' => '20%');
				$cell5 = array('data' => $status_data['status_name'], 'width' => '20%');
				$this->table->add_row($cell1, $cell2, $cell3, $cell4, $cell5);
			endforeach;

		endforeach;

		//  Generate the table in html format using the table class of codeigniter
		$html = $this->table->generate();

		// Add a page and change the orientation
		$pdf->AddPage('P');

		// Output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Reset pointer to the last page
		$pdf->lastPage();

		// Close and output PDF document
		// (I - Inline, D - Download, F - File)
		$pdf->Output('Report_workplan.pdf', 'I');
	}
}
