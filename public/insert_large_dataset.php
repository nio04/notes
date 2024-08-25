<?php
session_start();

set_time_limit(0);

ob_start();

$servername = "localhost";
$username = "nishat";
$password = "1234";
$dbname = "notes";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, description, keywords, attachment) VALUES (:user_id, :title, :description, :keywords, :attachment)");

  $pdo->beginTransaction();

  $numRecords = 1000000;
  $batchSize = 1000;

  for ($i = 1; $i <= $numRecords; $i++) {
    $user_id = $_SESSION['user']->id;
    $title = "unique note title $i";
    $description = "unique note description $i";
    $keywords = "keywords $i";
    $attachment = "first_blog.jpg";

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':keywords', $keywords);
    $stmt->bindParam(':attachment', $attachment);

    $stmt->execute();

    if ($i % $batchSize == 0) {
      $pdo->commit();

      ob_flush();

      echo "Committed notes for $i<br>";
      $pdo->beginTransaction();
    }
  }

  $pdo->commit();
  echo "<br>Finalized notes insertion of $numRecords";

  ob_flush();
  header("Location: /");
  exit;
} catch (PDOException $e) {
  $pdo->rollBack();
  ob_flush();
  echo "Failed: " . $e->getMessage();
}
