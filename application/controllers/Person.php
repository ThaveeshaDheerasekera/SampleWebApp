<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('PersonModel');
    }

	public function index()
	{
		$this->load->model('PersonModel');
        $this->data['people'] = $this->PersonModel->getPeople();
        $this->load->view('NameDisplay', $this->data);
	}

    public function person() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $firstName = $this->input->post('firstName');
            $lastName = $this->input->post('lastName');
            $address = $this->input->post('address');
            $telephone = $this->input->post('telephone');

            $data = $this->PersonModel->createPerson($firstName, $lastName, $address, $telephone);
            echo json_encode($data);
        }
        
        elseif ($this->input->server('REQUEST_METHOD') == 'GET') {
            $personID = $this->input->get('personID');
            $deletedPerson = $this->PersonModel->deletePerson($personID);
            echo json_encode($deletedPerson);
        }
    }
    
    public function user() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            
            $personID = $this->input->post('personID');
            $firstName = $this->input->post('firstName');
            $lastName = $this->input->post('lastName');
            $address = $this->input->post('address');
            $telephone = $this->input->post('telephone');

            $data = $this->PersonModel->updatePerson($personID, $firstName, $lastName, $address, $telephone);
            echo json_encode($data);
        }
        
        elseif ($this->input->server('REQUEST_METHOD') == 'GET') {
            $personID = $this->input->get('personID');
            $editPerson = $this->PersonModel->getPerson($personID);
            echo json_encode($editPerson);
        }
    }
}
