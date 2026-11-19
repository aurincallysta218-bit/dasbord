<?php

if (isset($_POST['Hapus'])) {

    $id = $_GET['id'];

    include 'koneksi.php';

    $query = "DELETE FROM produk WHERE `produk`.`id_produk` = '$id'";

    mysqli_query($dbconnect, $query);

    header("location:index.php?page=produk");
    

}

?>