<!-- views/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOLOOO - <?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .main-content {
            margin-left: 280px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            margin-top: 56px;
            min-height: 100vh;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .sidebar {
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    width: 250px;
    z-index: 1000;
    margin-top: 0px; /* Tinggi navbar */
    overflow-y: auto;
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