<!-- views/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOLOOO - <?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Tambahkan atau modifikasi ini di pages/css/style.css */

body {
    /* Anda bisa menetapkan warna dasar body jika belum ada */
    /* background-color: #e9ecef;  Contoh warna latar body yang sedikit abu-abu */
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px; /* Sesuaikan dengan lebar sidebar Anda */
    height: 100vh; /* Tinggi penuh viewport */
    background-color: #343a40; /* Warna latar sidebar (gelap) */
    padding-top: 1rem; /* Padding atas di dalam sidebar */
    z-index: 1030;
    overflow-y: auto;
    transition: width 0.3s ease;
}

#main-content {
    margin-left: 250px; /* HARUS SAMA DENGAN LEBAR .sidebar */
    width: calc(100% - 250px);
    padding: 0; /* Padding akan diatur oleh .container-fluid di dalamnya atau elemen lain */
    transition: margin-left .3s ease, width .3s ease;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: #f4f6f9; /* Warna Latar Belakang Utama Konten - Sedikit Abu-abu */
                                /* Sebelumnya mungkin putih atau tidak terdefinisi,
                                   sehingga sama dengan default body atau card */
}

/* Kontainer utama di dalam #main-content untuk halaman spesifik */
#main-content > .container-fluid {
    padding: 1.5rem; /* Padding untuk konten halaman */
    flex-grow: 1;
}

/* Styling untuk Card agar menonjol dari latar belakang #main-content */
#main-content .card {
    background-color: #ffffff; /* Warna Latar Card - Putih Cerah */
    border: none; /* Hilangkan border default jika ada, shadow akan memberi kedalaman */
    border-radius: 0.5rem; /* Sudut yang sedikit lebih bulat */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); /* Shadow yang lebih lembut dan menyebar */
                                            /* Sebelumnya mungkin menggunakan .shadow-sm Bootstrap,
                                               ini memberikan kustomisasi lebih */
    margin-bottom: 1.5rem; /* Memberi jarak antar card jika bertumpuk vertikal */
}

/* Jika Anda ingin header card memiliki style berbeda (opsional) */
#main-content .card .card-header {
    background-color: #f8f9fa; /* Warna header card yang sedikit berbeda */
    border-bottom: 1px solid #e9ecef;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
}

#main-content .card .card-title {
    margin-bottom: 1rem; /* Jarak antara judul card dan konten chart/isi */
    font-size: 1.1rem;
    font-weight: 500;
    color: #495057;
}

/* Untuk sidebar yang bisa diciutkan (jika Anda implementasikan) */
.sidebar.collapsed {
    width: 80px; /* Lebar saat diciutkan */
}

.sidebar.collapsed + #main-content {
    margin-left: 80px;
    width: calc(100% - 80px);
}

.footer {
    background-color: #ffffff; /* Footer bisa putih atau sama dengan #main-content */
    padding: 1rem 1.5rem;
    border-top: 1px solid #dee2e6;
    text-align: center;
    margin-top: auto; /* Kunci untuk sticky footer dengan flexbox */
}

/* Pastikan navbar di dalam #main-content tidak memiliki margin yang mengganggu */
#main-content .navbar {
    background-color: #ffffff; /* Warna Navbar */
    box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Shadow halus untuk navbar */
    /* Pastikan tidak ada margin bawah yang berlebihan dari navbar jika ada */
    margin-bottom: 0; /* Hapus margin bawah jika ada, padding .container-fluid akan memberi jarak */
}

        .main-content {
            margin-left: 280px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            margin-top: 56px;
            min-height: 100vh;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .navbar {
    position: fixed;
    top: 0;
    left: 280px; /* Sesuaikan dengan lebar sidebar */
    right: 0;
    z-index: 1000;
    padding-left: 1rem;
    padding-right: 1rem;
}
        
        .dropdown-menu {
            font-size: 0.95rem;
        }
        
        .profile-picture {
            transition: transform 0.3s ease;
        }
        
        .profile-picture:hover {
            transform: scale(1.05);
        }

        .alert {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideIn 0.3s ease-out;
        }

        .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
    cursor: pointer;
}

.badge {
    font-size: 0.85em;
    padding: 0.5em 0.75em;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.table th {
    white-space: nowrap;
}
.table td {
    vertical-align: middle;
}

.table th a {
    text-decoration: none;
    color: inherit;
}

.table th a:hover {
    color: #0d6efd;
}

.pagination .page-link {
    min-width: 90px;
    text-align: center;
}
.pagination .page-item.active .page-link {
    border-color: #0d6efd;
}

.modal-detail-img {
    max-width: 150px;
    border: 3px solid #dee2e6;
    padding: 2px;
}
.navbar-brand {
    font-size: 1.5rem;
    font-weight: 600;
}

.img-thumbnail {
    border: 2px solid #dee2e6;
    padding: 2px;
}

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        @media (max-width: 768px) {
            .sidebar {
        margin-top: 0;
        z-index: 1050;
    }
    
    .navbar {
        left: 0;
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .offcanvas-start {
        width: 250px;
    }
        }
    </style>
</head>
<body>