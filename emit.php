<?php
$host="localhost"; $db="site_carteira"; $user="root"; $pass="";
try{ $pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass); $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);}
catch(PDOException $e){ die(json_encode(['success'=>false,'msg'=>"Erro na conexão: ".$e->getMessage()])); }
?>
