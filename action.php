<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=vuedb", "root", "");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

switch($received_data->action){
    case 'login':
        $query = "
        SELECT * FROM tbl_sample 
        WHERE first_name = '".$received_data->firstName."' 
        AND password = '".md5($received_data->password)."'
        ";
      
        $statement = $connect->prepare($query);
    
        $statement->execute();
    
        $result = $statement->fetchAll();
    
        foreach($result as $row)
        {
            $data['id'] = $row['id'];
            $data['first_name'] = $row['first_name'];
            $data['last_name'] = $row['last_name'];
            
        }
        if(!empty($data['id'])){
            $data['status'] = 200;
            $data['id'] = md5($data['id']);
        }else{
            $data['status'] = '';
        }
       
    
        echo json_encode($data);
    break;

    case 'fetchall':
        $query = "
        SELECT * FROM tbl_sample 
        ORDER BY id DESC
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        while($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
        $data[] = $row;
        }
        echo json_encode($data);
    break;

    case 'insert':
        $data = array(
            ':first_name' => $received_data->firstName,
            ':last_name' => $received_data->lastName,
            ':password' => md5($received_data->password)
           );
          
           $query = "
           INSERT INTO tbl_sample 
           (first_name, last_name, password) 
           VALUES (:first_name, :last_name, :password)
           ";
          
           $statement = $connect->prepare($query);
          
           $statement->execute($data);
           $output = array(
            'message' => 'Data Inserted'
           );
          
           echo json_encode($output);
    break;

    case 'fetchSingle':
        $query = "
        SELECT * FROM tbl_sample 
        WHERE id = '".$received_data->id."'
        ";

        $statement = $connect->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        foreach($result as $row)
        {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
        }

        echo json_encode($data);
    ;
    
    case 'update':
        $data = array(
            ':first_name' => $received_data->firstName,
            ':last_name' => $received_data->lastName,
            ':id'   => $received_data->hiddenId,
            ':password' => md5($received_data->password)
           );
          
        $query = "
           UPDATE tbl_sample 
           SET first_name = :first_name, 
           last_name = :last_name,
           password = :password
           WHERE id = :id
           ";
          
        $statement = $connect->prepare($query);
          
        $statement->execute($data);
          
        $output = array(
            'message' => 'Data Updated'
           );
          
        echo json_encode($output);
    break;

    case 'delete':
        $query = "
        DELETE FROM tbl_sample 
        WHERE id = '".$received_data->id."'
        ";

        $statement = $connect->prepare($query);

        $statement->execute();

        $output = array(
        'message' => 'Data Deleted'
        );

        echo json_encode($output);
    break;

    case 'Insere_publicacao':
        $data = array(
            ':title' => $received_data->title,
            ':description' => $received_data->description,
            ':id_category' => $received_data->category,
            ':status' => $received_data->status
           );
          
           $query = "
           INSERT INTO tbl_news 
           (title, description, id_category, status) 
           VALUES (:title, :description, :id_category, :status)
           ";
        
           $statement = $connect->prepare($query);
           
           $statement->execute($data);
         
           $output = array(
            'message' => 'Noticia cadastrada com sucesso'
           );
          
           echo json_encode($output);
    break;

}


?>