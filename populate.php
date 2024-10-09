<?php

include_once 'connectdb.php';

try {
 
    $db->exec("INSERT INTO users (username, password, email) VALUES
        ('user1', '".password_hash('password1', PASSWORD_DEFAULT)."', 'user1@example.com'),
        ('user2', '".password_hash('password2', PASSWORD_DEFAULT)."', 'user2@example.com')");

   
    $db->exec("INSERT INTO projects (title, start_date, end_date, description, phase, uid) VALUES
        ('Project 1', '2024-04-01', '2024-05-01', 'Description of Project 1', 'design', 1),
        ('Project 2', '2024-04-15', '2024-06-01', 'Description of Project 2', 'development', 2),
        ('Project 3', '2024-05-01', '2024-07-01', 'Description of Project 3', 'testing', 1),
        ('Project 4', '2024-06-01', '2024-08-01', 'Description of Project 4', 'deployment', 2),
        ('Project 5', '2024-07-01', '2024-09-01', 'Description of Project 5', 'complete', 1)");
    
    echo "Test data inserted successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
