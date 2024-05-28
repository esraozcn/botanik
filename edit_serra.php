<?php
include('includes/db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $plants = $_POST['plants'];
    $conditions = $_POST['conditions'];

    $stmt = $conn->prepare("UPDATE serra SET name = ?, plants = ?, conditions = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $name, $plants, $conditions, $id, $user_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $stmt = $conn->prepare("SELECT id, name, plants, conditions FROM serra WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $serras = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h2>Sera Düzenle</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="id">Sera Seç</label>
            <select class="form-control" id="id" name="id" required>
                <?php foreach ($serras as $serra): ?>
                    <option value="<?php echo $serra['id']; ?>"><?php echo $serra['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
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
        <div class="form-group mt-3">
            <a href="delete_serra.php?id=<?php echo $id; ?>" class="btn btn-danger">Sil</a>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>
