<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PersonModel extends CI_Model {

	public function getPeople() {
		$this->db->select('*');
        $this->db->from('Person');

        $query = $this->db->get();
        return $query->result();

        $num_data_returned = $this->db->num_rows();

        if($num_data_returned < 1) {
            echo 'There is no data in the database';
            exit();
        }
	}

    public function createPerson($firstName, $lastName, $address, $telephone) {
        $this->db->set('firstName', $firstName);
        $this->db->set('lastName', $lastName);
        $this->db->set('address', $address);
        $this->db->set('telephone', $telephone);
        $this->db->insert('Person');
    }
    
    public function deletePerson($personID) {
//        $query = "DELETE FROM Person WHERE personID = $personID";
        $this->db->where('personID', $personID);
        $this->db->delete('Person');
//        $this->db->query($query);
    }
    
    public function getPerson($personID) {
        $this->db->where('personID', $personID);
        $query = $this->db->get('Person');
        
        if ($query->result()) {
            $result = $query->result();
            
            foreach ($result as $row) {
                $users[$row->personID] = array($row->firstName, $row->lastName, $row->address, $row->telephone);
            }
            
            return $users;
        }
    }
    
    public function updatePerson($personID, $firstName, $lastName, $address, $telephone) {
        $this->db->where('personID', $personID);
        $this->db->set('firstName', $firstName);
        $this->db->set('lastName', $lastName);
        $this->db->set('address', $address);
        $this->db->set('telephone', $telephone);
        $this->db->update('Person');
    }
}
