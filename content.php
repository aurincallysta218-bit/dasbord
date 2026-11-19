
<?php

$page = $_GET['page'] ?? 'dashboard';

$halaman = [
    'dashboard' => 'pages/dashboard.php',
    'produk'    => 'pages/produk.php',
    'orders'    => 'pages/orders.php',
    'customers' => 'pages/customers.php',
    'addproduct'=> 'pages/formaddproduct.php',
    'editproduct' => 'pages/formeditproduct.php'
];

if (isset($halaman[$page])) {
    $file = __DIR__ . '/' . $halaman[$page];

    if (file_exists($file)) {
        require $file;
    } else {
        echo "<h2>File halaman belum dibuat</h2>";
    }
} else {
    echo "<h2>Halaman tidak ditemukan</h2>";
}

?>
