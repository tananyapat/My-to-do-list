<?php
    $errors = "";
    $db = mysqli_connect('Localhost','root','tanakorn55140239','mytodolist');
    $totasks = mysqli_query($db, "SELECT * FROM totasks");
    $check = array();

    while ($Result = mysqli_fetch_array($totasks)){
        array_push($check,$Result["task"]);
    }

    if(isset($_POST['submit'])){
        $task = $_POST['task'];

        if(empty($task)) {
            $errors = "!!!ENTER YOUR WORD!!!";
        }else {
            if(in_array($_POST['task'],$check)){
                $errors = "!!!Duplicate Word!!!";
            }
            else{
                mysqli_query($db,"INSERT INTO totasks (task) VALUES ('$task')");
                header('location: index.php');
            }
        }
    }

    if (isset($_GET['del_task'])){
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM totasks WHERE id = $id");
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    
	<title>My to do list</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fruktur&family=Griffy&family=Indie+Flower&family=Lobster&display=swap" rel="stylesheet">
    
</head>

<body class='web-body'>

    <video autoplay muted loop id="myVideo" class='vdo'>
        <source src="videoplayback.mp4" type="video/mp4">
    </video>

    <div class="page-detail">

        <div class="heading">
            <h2 class='header-mytodolist'>My to do list</h2>
        </div>

        <form method="POST" action="index.php" class="input_form">
            <?php if(isset($errors)) { ?>
                <p class='alert'><?php echo $errors; ?></p>
            <?php } ?>

            <input type="text" name="task" class="task_input" placeholder="Enter your word"/>
            <div class='btn-flex'>
                <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
                <span onclick="sortList()" class="sort_btn">Sort</span>
            </div>
        </form>

        <ul id="myUL">
            <?php $totasks = mysqli_query($db, "SELECT * FROM totasks");
            while ($row = mysqli_fetch_array($totasks)) { ?>               
                <li class="task"><?php echo $row['task']; ?>
                    <span class="delete">
                        <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a>
                    </span>
                </li>
                
            <?php }?>
        </ul>
    </div>      
        
<script src="func.js"></script>
</body>
</html>