<?php
// pages/print_transaction.php
session_start();
require_once '../configdb.php';

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$transaction_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($transaction_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM laporan WHERE id = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();
    
    if (!$transaction) {
        die("Transaksi tidak ditemukan");
    }
} else {
    die("ID transaksi tidak valid");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaksi #<?= $transaction['id'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .company-info {
            color: #666;
            font-size: 12px;
        }
        
        .transaction-info {
            margin-bottom: 30px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        
        .order-details {
            margin-top: 30px;
        }
        
        .order-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }
        
        .order-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #2e7d32;
            background-color: #e8f5e8;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        .payment-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12