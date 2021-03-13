<?php
    $conn = new mysqli("localhost" , "root", "", "test");
    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $result = array('error'=> false);
    $action = '';


    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action == 'read'){
        $sql = $conn->query("SELECT * FROM principles");
        $principles = array();
        while($row = $sql->fetch_assoc()){
            array_push($principles, $row);
        }
        $result['principles'] = $principles;        
    }
   
    if($action == 'create'){
        $value = isset($_POST['value']) ? $_POST['value'] : '';

        $sql = $conn->query("INSERT INTO principles (value) VALUES ('$value')");
        if($sql){
            $result['message'] = "The value was added successfully!";
           
        }else{
            $result['error'] = true;
            $result['message'] = "Failed to add the value";
        }
    };

    if($action == 'update'){
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $value = isset($_POST['value']) ? $_POST['value'] : '';

        $sql = $conn->query("UPDATE principles SET value='$value' WHERE id='$id'" );

        if($sql){
            $result['message'] = "The value was updated successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = 'Failed to update the value';
        }
    }


    if($action == 'delete'){
        $id = isset($_POST['id']) ? $_POST['id'] : '';

      
        $sql = $conn->query("DELETE FROM principles WHERE id='$id'");

        if($sql){
            $result['message'] = "The value was deleted successfully!";
        }else{
            $result['error'] = true;
            $result['message'] = 'Failed to delete the value';
        }
    }


    $conn->close();
    echo json_encode($result);

?>