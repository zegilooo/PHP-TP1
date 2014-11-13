<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        .vincent {
            background-color: #FF9900;
        }
        .david {
            background-color: #00CCFF;
        }
        .thomas {
            background-color: #00FF33;
        }
        .christophe {
            background-color: #FFFF00;
        }
        .personne{
            background-color: #FF0000;
        }
        .container {
            width:950px;
            margin: 0 auto;
        }
        .annee {
            text-align:center;
        }
        td {
            text-align:right;
        }
    </style>
    <title>Planning Corvée Patates</title>
</head>
<body>
<?php
$prenoms=array("vincent","david","thomas","christophe");
$annees=array(2014,2015,2016,2017);
$defaultYearViewed = 2014;
if (!empty($_POST['annee'])){
    $defaultYearViewed = intval($_POST['annee']);
}
$dataFileName="tp1-data-".$defaultYearViewed.".txt";
if (!empty($_POST['ecriture'])){
    if($_POST['ecriture'] == '1'){
        for($i=0;$i<52;$i++){
            $personne [$i] = $_POST[$i] ;
        }
        $data = fopen($dataFileName,"w+");
        $implose = implode(';',$personne);
        fwrite($data,$implose);
        fclose($data);
    }
}
else if(is_file($dataFileName))
{
    $data = fopen($dataFileName,"r+");
    $personne=explode(";",fgets($data));
}
else
{
    for($i=0;$i<52;$i++){
        $personne [$i] = '' ;
    }
}
?>
<div class="container">
    <h1> Planning des corvées d'épluchage</h1>
    <form action="#" method="post" name="form0" id="form0">
        <p class="annee"><label>Année : <select name="annee" onchange="document.forms['form0'].submit();">
                    <?php foreach ($annees as $a){?>
                        <option value="<?php echo $a; ?>" <?php if ( $a==$defaultYearViewed) { echo "selected" ; } ?>><?php echo $a; ?></option>
                    <?php }?>
                </select></label>
    </form>
    </p>
    <?php
    $firstDay = mktime(0, 0, 0, 1, 0, $defaultYearViewed);
    $tampon = strtotime('first Sunday', $firstDay);
    $jours[0]= date('d/m/Y',$tampon);
    for ($i = 1;$i<52;$i++)
    {
        $tampon = strtotime('next Sunday', $tampon);
        $jours[$i] = date('d/m/Y',$tampon);
    }
    ?>
    <form action="#" method="post" name="form1" id="form1">
        <input name="annee" type="hidden" value="<?php echo $defaultYearViewed; ?>">
        <input name="ecriture" type="hidden" value="1">
        <table border='1' align='center'>
            <tr>
                <?php
                for ($i = 0;$i<52;$i++)
                {
                    echo "<td>";
                    ?>
                    <?php echo $jours[$i]; ?>
                    <select name=<?php echo "'".($i)."'" ; ?> class="<?php echo $personne[$i] ?>">
                        <option value="personne">personne</option>
                        <?php foreach ($prenoms as $p){?>
                            <option value="<?php echo $p; ?>" <?php if ( $personne[$i]==$p) { echo "selected" ; } ?>><?php echo $p; ?></option>
                        <?php }?>
                    </select>
                    <?php
                    echo "</td>";
                    if (($i+1) % 4 == 0) echo "</tr>\n<tr>";
                }
                ?>
            </tr>
        </table><div>
            <div align="center">
                <p>
                    <input type="submit" value="Valider le planning">
                </p>
            </div>
        </div>
    </form>
    <h2>Statistiques par ordre croissant</h2>
    <ol>
        <?php
        $compteur = array_count_values($personne);
        if(count($compteur)>1){
            asort($compteur);
            foreach ($compteur as $key => $value)
            {?>
                <li><?php echo $key; ?> : <?php echo $value; ?></li>
            <?php
            }
        } else {
            echo "Pas de statistiques pertinentes pour le moment ...";
        }?>
    </ol>
</div>
</body>
</html>