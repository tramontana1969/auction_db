<!DOCTYPE html>
<html>
    <head>
        <title>Edit seller</title>
    </head>
    <body>
    <h3>Edit seller</h3>
    <?php
    include "../creds.php";
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM seller WHERE id = :id";
        $seller = $db->prepare($sql);
        $seller->execute(array(':id'=>$id));
        foreach ($seller as $data) {
            $name = $data['name'];
        }
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<p>name: <input type='text' name='name' value='$name'/></p>";
        echo "<input type='submit' value='Update'/>";
        echo "</form>";
    }
    elseif (isset($_POST['id']) && isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sql = "UPDATE seller SET name = :name WHERE id = :id";
        $update = $db->prepare($sql);
        $update->execute(array(':name'=>$name, ':id'=>$id));
        header('Location: ../seller.php');
    }
    ?>
    </body>
</html>