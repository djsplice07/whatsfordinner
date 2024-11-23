<?php
require 'db.php';

$query = $_GET['q'] ?? '';
$suggestions = [];

if (!empty($query)) {
    $stmt = $pdo->prepare("
        SELECT DISTINCT food_type_subcategory
        FROM restaurants
        WHERE food_type_subcategory LIKE :query
    ");
    $stmt->execute(['query' => "%$query%"]);

    while ($row = $stmt->fetch()) {
        $keywords = array_map('trim', explode(',', $row['food_type_subcategory']));
        foreach ($keywords as $keyword) {
            if (stripos($keyword, $query) !== false && !in_array($keyword, $suggestions)) {
                $suggestions[] = $keyword;
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($suggestions);
