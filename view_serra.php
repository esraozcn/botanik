<?php
include('includes/db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $conn->prepare("SELECT users.username, serra.name, serra.plants, serra.conditions 
                        FROM serra 
                        JOIN users ON serra.user_id = users.id
                        WHERE users.username LIKE ? OR serra.name LIKE ?");
$search_param = "%" . $search . "%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
$serras = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h2>Sera Görüntüle</h2>
    <form method="get" action="">
        <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Kullanıcı adı veya sera adı ara" value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Ara</button>
    </form>
    <div class="mt-4">
        <?php if (count($serras) > 0): ?>
            <ul class="list-group">
                <?php foreach ($serras as $serra): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($serra['username']); ?></strong>: <?php echo htmlspecialchars($serra['name']); ?>
                        <p><?php echo htmlspecialchars($serra['plants']); ?></p>
                        <p><?php echo htmlspecialchars($serra['conditions']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Sonuç bulunamadı.</p>
        <?php endif; ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
</head>
<body>
    <a href="https://github.com/esraozcn">GitHub Hesabım</a>
</body>
</html>