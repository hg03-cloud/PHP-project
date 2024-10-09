<?php

session_start();


if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}


include_once 'connectdb.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = $_POST['phase'];
    $description = $_POST['description'];

    try {
        
        $stmt = $db->prepare("UPDATE projects SET title=?, start_date=?, end_date=?, phase=?, description=? WHERE uid=?");
        $stmt->execute([$title, $start_date, $end_date, $phase, $description, $id]);
        
        header("Location: add_project.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

  
    $stmt_project = $db->prepare("SELECT * FROM projects WHERE uid = ?");
    $stmt_project->execute([$project_id]);
    $project = $stmt_project->fetch();
} else {
    
    header("Location: add_project.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Project</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $project['uid']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $project['title']; ?>" required>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $project['start_date']; ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $project['end_date']; ?>">
            <label for="phase">Phase:</label>
            <select id="phase" name="phase" required>
                <option value="design" <?php if ($project['phase'] == 'design') echo 'selected'; ?>>Design</option>
                <option value="development" <?php if ($project['phase'] == 'development') echo 'selected'; ?>>Development</option>
                <option value="testing" <?php if ($project['phase'] == 'testing') echo 'selected'; ?>>Testing</option>
                <option value="deployment" <?php if ($project['phase'] == 'deployment') echo 'selected'; ?>>Deployment</option>
                <option value="complete" <?php if ($project['phase'] == 'complete') echo 'selected'; ?>>Complete</option>
            </select>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50"><?php echo $project['description']; ?></textarea>
            <input type="submit" value="Update Project">
        </form>
    </div>
</body>
</html>
