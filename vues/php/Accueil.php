<?php
header('Content-Type: text/html;charset=UTF-8');
header('Pragma: no-cache');

if(isset($_SESSION['login'])){
    $u = new UserControl();
    $user = $u->recupererPersonne($_SESSION['login']);
}else{
    $u = new VisiteurControl();

    header('location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="vues/js/jquery.js"></script>
    <title>Accueil</title>
</head>
<body>

</body>
</html>