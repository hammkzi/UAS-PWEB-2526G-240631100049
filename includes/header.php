<?php
// includes/header.php
// File header yang digunakan di semua halaman (include/require)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Sistem Pendataan Buku</title>
    <link rel="stylesheet" href="<?= $basePath ?? '' ?>assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">📚 Sistem Pendataan Buku</div>
    <ul class="nav-links">
        <li><a href="<?= $basePath ?? '' ?>index.php">🏠 Beranda</a></li>
        <li><a href="<?= $basePath ?? '' ?>daftar.php">📋 Daftar Buku</a></li>
        <li><a href="<?= $basePath ?? '' ?>tambah.php">➕ Tambah Buku</a></li>
    </ul>
</nav>

<main class="container">
