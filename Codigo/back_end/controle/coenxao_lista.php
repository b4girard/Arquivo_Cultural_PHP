<?php
$idLista = intval($_GET['id'] ?? 0);
if ($idLista <= 0) {
    die("Lista inválida!");
}
?>