<!DOCTYPE html>
<html>
    <head>
        <title>Edit customer</title>
    </head>
    <body>
    <h3>Edit customer</h3>
    <?php
    include "../creds.php";
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM customer WHERE id = :id";
        $customer = $db->prepare($sql);
        $customer->execute(array(':id'=>$id));
        foreach ($customer as $data) {
            $name = $data['name'];
        }
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='$id'/>";
        echo "<input type='text' name='name' value='$name'/>";
        echo "<input type='submit' value='Update'/>";
        echo "</form>";
    }
    elseif (isset($_POST['id']) && isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sql = "UPDATE customer SET name = :name WHERE id = :id";
        $update = $db->prepare($sql);
        $update->execute(array(':name'=>$name, ':id'=>$id));
        header('Location: ../customer.php');
    }
    ?>
    </body>
</html>