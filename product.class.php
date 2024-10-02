<?php
require_once "database.class.php";

class Product{

    public $name;
    public $category;
    public $price;
    public $availability;
    public $id;
    
    protected $db;

    function __construct()
    {
        $this->db = new Database;
    }

    function add() {
        $sql = "INSERT INTO product(name, category, price, availability, id) VALUES (:name, :category, :price, :availability, :id )";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(":name", $this->name);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":price", $this->price);
        $query->bindParam(":availability", $this->availability);
        $query->bindParam(":id", $this->id);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
//         function showAll()
//         {

//             $sql = "SELECT * FROM product ORDER BY name ASC";


//             $query = $this->db->connect()->prepare($sql);
//             $data = null;

//             if ($query->execute()) {
//                 $data = $query->fetchAll();
//             }
//             return $data;
//    }    

    
    function edit(){
            $sql = "UPDATE product SET name = :name, category = :category, price = :price, availability = :availability WHERE id = :id;";

            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':name', $this->name);
            $query->bindParam(':category', $this->category);
            $query->bindParam(':price', $this->price);
            $query->bindParam(':availability', $this->availability);
            $query->bindParam(':id', $this->id);

            return $query->execute();
        }

    function delete($id) {
    
        $sql = "DELETE FROM product WHERE id = :id;";
    
        $query = $this->db->connect()->prepare($sql);
    
        $query->bindParam(':id', $id);
    
        return $query->execute();
    }
    
    
    function showAll($keyword, $category) {
        // Corrected SQL syntax: the % wildcard is part of the parameter
        $sql = "SELECT * FROM product WHERE name LIKE '%' :keyword '%' AND category LIKE '%' :category '%' ORDER BY name ASC";
    
        // Prepare the SQL statement
        $query = $this->db->connect()->prepare($sql);
    
        // Add wildcards to the parameters
        // $keyword = "%$keyword%";
        // $category = "%$category%";
    
        // Bind parameters with wildcards included
        $query->bindParam(":keyword", $keyword);
        $query->bindParam(":category", $category);
    
        // Execute the query and fetch data
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(); // Fetch all results into the $data array
        }
        return $data;
    }
    

    function fetchRecord($recordID) {
        $sql = "SELECT * FROM product WHERE id = :recordID;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':recordID', $recordID);

        $data = null;

        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }
}
