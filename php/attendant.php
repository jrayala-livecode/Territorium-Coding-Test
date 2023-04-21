<?php 

class MusicFestivalAttendant {
    private $name;
    private $email;
    private $age;
    private $gender;
    private $nationality;
    private $ticketType;
    private $id;
    private $pdo;

    public function __construct($postData, $pdo) {
        $this->name = $this->sanitize($postData['name']);
        $this->email = $this->sanitize($postData['email']);
        $this->age = $this->sanitize($postData['age']);
        $this->gender = $this->sanitize($postData['gender']);
        $this->nationality = $this->sanitize($postData['nationality']);
        $this->ticketType = $this->sanitize($postData['ticketType']);

        $this->pdo = $pdo;
    }

    private function sanitize($input) {
        // Remove HTML tags
        $output = strip_tags($input);

        // Remove non-alphanumeric characters
        $output = preg_replace("/[^a-zA-Z0-9]/", "", $output);

        // Escape quotes
        $output = addslashes($output);

        // Return sanitized input
        return $output;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAge() {
        return $this->age;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getNationality() {
        return $this->nationality;
    }

    public function getTicketType() {
        return $this->ticketType;
    }

    public function update() {
        // Update the database with the current object data
        
        $stmt = $this->pdo->prepare('UPDATE attendants SET name = :name, email = :email, age = :age, gender = :gender, nationality = :nationality, ticket_type = :ticketType WHERE id = :id');
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':ticketType', $this->ticketType);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function getAttendantById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM attendants WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        $attendant = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$attendant) {
            return false;
        }
    
        $this->id = $attendant['id'];
        $this->name = $attendant['name'];
        $this->email = $attendant['email'];
        $this->age = $attendant['age'];
        $this->gender = $attendant['gender'];
        $this->nationality = $attendant['nationality'];
        $this->ticketType = $attendant['ticket_type'];
    
        return true;
    }

    public function create()
    {
        // Insert a new record into the database with the current object data
        
        $stmt = $this->pdo->prepare('INSERT INTO attendants (name, email, age, gender, nationality, ticket_type) VALUES (:name, :email, :age, :gender, :nationality, :ticketType)');
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':ticketType', $this->ticketType);
        $stmt->execute();
        
        // Set the object ID to the ID of the newly created record
        $this->id = $this->pdo->lastInsertId();
    }

    public function delete() {
        // Delete the current object's record from the database
        $stmt = $this->pdo->prepare('DELETE FROM attendants WHERE id = :id');
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }


}


?>