<?php
// pages/print_transaksi.php
session_start();
require_once '../configdb.php';

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// PERBAIKAN: Gunakan string untuk ID transaksi
$transaction_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($transaction_id)) {
    $stmt = $conn->prepare("SELECT * FROM laporan WHERE id_transaksi = ?");
    $stmt->bind_param("s", $transaction_id);
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
    <title>Print Transaksi</title>
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
            color: #333;
            font-size: 20px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        .payment-badge {
            display: inline-block;
            border-radius: 15px;
            font-size: 12px;
        }

        @media print {    
        @page {
            @top-center {
                content: ""; 
            }
            @bottom-center {
                content: ""; 
            }
        }
    }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">BOLOOO</div>
        <div class="company-info">
            Sate Solo Pak Komar
        Jl. Sukapura No.76, Cipagalo, Kec. Bojongsoang<br>
        Kabupaten Bandung | Telp: (021) 555-1234<br>
            www.bolooo-resto.com | info@bolooo-resto.com
        </div>
    </div>

    <div class="transaction-info">
        <table class="info-table">
            <tr>
                <td>ID Transaksi</td>
                <td>: <?= $transaction['id_transaksi'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Transaksi</td>
                <td>: <?= date('d/m/Y H:i', strtotime($transaction['tanggal_transaksi'])) ?></td>
            </tr>
            <tr>
                <td>Nama Pelanggan</td>
                <td>: <?= htmlspecialchars($transaction['nama_pelanggan'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <?= htmlspecialchars($transaction['email'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td>: 
                    <span class="payment-badge bg-<?= $transaction['metode_pembayaran'] == 'cash' ? 'success' : 'info' ?>">
                        <?= $transaction['metode_pembayaran'] ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="order-details">
        <div class="order-title">Detail Pesanan</div>
        <div class="order-content"><?= htmlspecialchars($transaction['pesanan'], ENT_QUOTES, 'UTF-8') ?></div>
    </div>

    <div class="total-section">
        <div class="total-amount">
            Total: Rp <?= number_format($transaction['total_harga'], 0, ',', '.') ?>
        </div>
    </div>

    <div class="footer"></div>

    <script>
        document.title = " ";

        window.addEventListener('load', function() {
            window.print();
        });
        
        window.addEventListener('afterprint', function() {
            window.close();
        });
        
        window.print();
    </script>
</body>
</html>