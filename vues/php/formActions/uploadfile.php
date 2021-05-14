<?php
$conn=new PDO('mysql:host=localhost; dbname=gestion_licences', 'root', '') or die(mysqli_error());
if(isset($_POST['submit'])!=""){
    $name=$_FILES['file']['name'];
    $size=$_FILES['file']['size'];
    $type=$_FILES['file']['type'];
    $temp=$_FILES['file']['tmp_name'];
    $fname = date("YmdHis").'_'.$name;
    $chk = $conn->query("SELECT * FROM  files where name = '$name' ")->rowCount();
    if($chk){
        $i = 1;
        $c = 0;
        while($c == 0){
            $i++;
            $reversedParts = explode('.', strrev($name), 2);
            $tname = (strrev($reversedParts[1]))."_".($i).'.'.(strrev($reversedParts[0]));
            $chk2 = $conn->query("SELECT * FROM  files where name = '$tname' ")->rowCount();
            if($chk2 == 0){
                $c = 1;
                $name = $tname;
            }
        }
    }
    echo $temp;
    $move =  move_uploaded_file($temp,"../upload/".$fname);
    if($move){
        //insertion à voir
        $id_soc = $_GET['ids'];
        $query=$conn->query("insert into files(name,fname, id_societe)values('$name','$fname', '$id_soc')");
        if($query){
            header("location: ../../../index.php?action=seConnecter&select=InfoClient&id_societe_select=".$_GET['ids']);
        }else{
            global $vues;
            $_SESSION['erreur'] = "Insertion impossible";
            require_once($vues['Erreur']);
        }
    }
}

?>