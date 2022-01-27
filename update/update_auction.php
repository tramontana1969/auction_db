<!DOCTYPE html>
<html>
    <head>
        <title>Edit auction</title>
    </head>
    <body>
    <h3>Edit auction</h3>
    <?php
    include "../creds.php";
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM auction WHERE id = :id";
        $auction = $db->prepare($sql);
        $auction->execute(array(':id'=>$id));
        foreach ($auction as $data) {
            $date = $data['date'];
            $time = $data['time'];
            $place = $data['place'];
            $description = $data['description'];
        }
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='$id'/>";
        echo "<p>date: <input type='date' name='date' value='$date'></p>";
        echo "<p>time: <input type='time' name='time' value='$time'/></p>";
        echo "<p>place: <input type='text' name='place' value='$place'></p>";
        echo "<p>description: <input type='text' name='description' value='$description'></p>";
        echo "<input type='submit' value='Update'/>";
        echo "</form>";
    }
    elseif (isset($_POST['id']) && isset($_POST['date']) && isset($_POST['time']) &&
            isset($_POST['place']) && isset($_POST['description'])) {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $place = $_POST['place'];
        $description = $_POST['description'];
        $sql = "UPDATE auction SET date = :date, time = :time, place = :place, 
               description = :description WHERE id = :id";
        $update = $db->prepare($sql);
        $update->execute(
                array(
                    ':date'=>$date,
                    ':time'=>$time,
                    ':place'=>$place,
                    ':description'=>$description,
                    ':id'=>$id
                )
        );
        header('Location: ../auction.php');
    }
    ?>
    </body>
</html>