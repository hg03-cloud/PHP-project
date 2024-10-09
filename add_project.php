<?php

session_start();


if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}


include_once 'connectdb.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = $_POST['phase'];
    $description = $_POST['description'];

    try {
       
        $stmt = $db->prepare("INSERT INTO projects (title, start_date, end_date, phase, description, uid) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $start_date, $end_date, $phase, $description, $_SESSION['uid']]);
       
        header("Location: add_project.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


$stmt_projects = $db->prepare("SELECT * FROM projects WHERE uid = :uid");
$stmt_projects->execute(['uid' => $_SESSION['uid']]);
$projects = $stmt_projects->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 800px;
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
        .project-list {
            margin-bottom: 20px;
        }
        .project-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .project-list th, .project-list td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .project-list th {
            background-color: #f2f2f2;
        }
        .logout {
            float: right;
            margin-top: -40px;
        }
        .edit-btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Project</h1>
        <div class="logout">
            <a href="index.php">Logout</a>
        </div>
        <div class="project-list">
            <h2>Current Projects</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Phase</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo $project['title']; ?></td>
                    <td><?php echo $project['start_date']; ?></td>
                    <td><?php echo $project['end_date']; ?></td>
                    <td><?php echo $project['phase']; ?></td>
                    <td><?php echo $project['description']; ?></td>
                    <td><a href="update_project.php?id=<?php echo $project['uid']; ?>" class="edit-btn">Edit</a></td>

                </tr>
                <?php endforeach; ?>
            </table>
            <h2>New Project</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <label for="phase">Phase:</label>
            <select id="phase" name="phase" required>
                <option value="design">Design</option>
                <option value="development">Development</option>
                <option value="testing">Testing</option>
                <option value="deployment">Deployment</option>
                <option value="complete">Complete</option>
            </select>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            <input type="submit" value="Add Project">
        </form>
    </div>
</body>
</html>
