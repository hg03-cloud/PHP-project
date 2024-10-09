<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Projects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .project {
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }
        .project h2 {
            margin-top: 0;
        }
        .project p {
            margin: 5px 0;
        }
        .button-container {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .button-container a {
            margin-right: 10px;
            text-decoration: none;
        }
        .button-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 8px;
            margin-right: 10px;
        }
        .search-container input[type="submit"],
        .search-container button {
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .search-container input[type="submit"]:hover,
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <a href="login.php"><button>Login</button></a>
            <a href="register.php"><button>Register</button></a>
        </div>
        <h1>List of Projects</h1>
        
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="search-container">
            <input type="text" name="search_title" placeholder="Search by Title">
            <input type="text" name="search_start_date" placeholder="Search by Start Date (YYYY-MM-DD)">
            <input type="submit" value="Search">
            <button type="button" onclick="clearFilter()">Clear Filter</button>
        </form>
        
        <?php
        
        include_once 'connectdb.php';

   
        try {
         
            if (isset($_GET['search_title']) && isset($_GET['search_start_date'])) {
                $search_title = $_GET['search_title'];
                $search_start_date = $_GET['search_start_date'];

                $stmt = $db->prepare("SELECT * FROM projects WHERE title LIKE ? AND start_date LIKE ?");
                $stmt->execute(["%$search_title%", "%$search_start_date%"]);
            } else {
               
                $stmt = $db->query('SELECT * FROM projects');
            }
            
            $projects = $stmt->fetchAll();

            if (count($projects) > 0) {
                foreach ($projects as $project) {
                    echo '<div class="project">';
                    echo '<h2>' . $project['title'] . '</h2>';
                    echo '<p><strong>Start Date:</strong> ' . $project['start_date'] . '</p>';
                    echo '<p><strong>End Date:</strong> ' . $project['end_date'] . '</p>';
                    echo '<p><strong>Phase:</strong> ' . $project['phase'] . '</p>';
                    echo '<p>' . $project['description'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No projects found.</p>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
    <script>
        function clearFilter() {
            document.querySelector('input[name="search_title"]').value = '';
            document.querySelector('input[name="search_start_date"]').value = '';
            document.querySelector('.search-container').submit(); 
        }
    </script>
</body>
</html>
