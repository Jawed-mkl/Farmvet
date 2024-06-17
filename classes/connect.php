<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "farmvet";
    private $con; // Define the property to hold the connection

    function __construct() {
        $this->con = $this->connect();
    }

    function connect() {
        $this->con = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }
        return $this->con;
    }

    function read($query) {
        $result = $this->con->query($query);
        if (!$result) {
            return false;
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    function save($query) {
        $result = $this->con->query($query);
        return $result ? true : false;
    }

    function update($query, $params, $types) {
        if (!$this->con) {
            $this->con = $this->connect();
        }

        $stmt = $this->con->prepare($query);
        if ($stmt === false) {
            return false;
        }

        // Check if the number of parameters matches the number of placeholders
        if (count($params) !== strlen($types)) {
            return false; // Mismatch in the number of params and types
        }

        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}

?>
