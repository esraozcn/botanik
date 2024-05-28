<?php
include('includes/db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $plants = $_POST['plants'];
    $conditions = $_POST['conditions'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO serra (user_id, name, plants, conditions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $name, $plants, $conditions);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h2>Sera Ekle</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Sera Adı</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="plants">Bitkiler</label>
            <textarea class="form-control" id="plants" name="plants" required></textarea>
        </div>
        <div class="form-group">
            <label for="conditions">Bakım Koşulları</label>
            <textarea class="form-control" id="conditions" name="conditions" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>
