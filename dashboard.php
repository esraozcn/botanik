<?php
include('includes/db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, name FROM serra WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$serras = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h2>Dashboard</h2>
    <ul class="list-group">
        <li class="list-group-item"><a href="add_serra.php">Sera Ekle</a></li>
        <li class="list-group-item"><a href="view_serra.php">Sera Görüntüle</a></li>
    </ul>
    <div class="mt-4">
        <h4>Seralarım</h4>
        <ul class="list-group">
            <?php foreach ($serras as $serra): ?>
                <li class="list-group-item">
                    <?php echo htmlspecialchars($serra['name']); ?>
                    <div class="float-right">
                        <a href="add_serra.php" class="btn btn-primary">Sera Ekle</a>
                        <a href="edit_serra.php?id=<?php echo $serra['id']; ?>" class="btn btn-sm btn-info">Düzenle</a>
                        <a href="delete_serra.php?id=<?php echo $serra['id']; ?>" class="btn btn-sm btn-danger">Sil</a>
                        <a href="view_serra.php" class="btn btn-info">Sera Görüntüle</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php include('includes/footer.php'); ?>
