<table width="100%">
     <?php 
            if($type == "Listagem de Quarto") { ?>
    <tr>
        <td align="center">
       
            	<h1><?= $summercamp ?></h1></td>
    </tr>
    <tr>
        <td align="center">
            <h1>Cadastros dos Colonistas</h1>
        </td>
    </tr>
    <tr>
        <td align="center">
            <h3><?= $time ?></h3>
        </td>
     </tr>
     <tr>
        <td align="center">
        <br>
            <h1><?= $room ?></h1>
        </td>
     </tr>
           <?php  } else if($type == "Listagem de Inscrições") {?>
      <tr>
      	<td align="center">
            <h1><?= $type ?></h1>
        </td>
    </tr>
    <tr>
        <td align="center">
            <h3><?= $time ?></h3>
        </td>
    </tr>
    <tr>
        <td align="center">
            <?php
            if ($filtros) {
                echo "<br><h3>Filtros utilizados:</h3>";
                foreach ($filtros as $filtro) {
                    echo $filtro . "<br>";
                }
            } else {
                echo "<br><br><br><br>";
            }
            ?>
        </td>
    </tr>
    <?php }?>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
foreach ($report as $colonist) {
    ?>
    <div class="row">
        <div class="col-lg-12 middle-content">
            <div class="row">
                <h2><?= $colonist['colonist']->fullname ?></h2>
                <strong>Sexo: </strong><?php
                if ($colonist['colonist']->gender == 'M') {
                    echo "Masculino";
                    $amigo = "Amigo";
                } else {
                    echo "Feminino";
                    $amigo = "Amiga";
                }
                ?><br>
                <strong>Data nascimento: </strong><?= date("d/m/Y", strtotime($colonist['summercamp']->birth_date)); ?><br>
                <strong>Escola: </strong><?= $colonist['summercamp']->school_name ?><br>
                <strong>Ano escolar: </strong><?= $colonist['summercamp']->school_year ?><br>
                <strong>Número Quarto: </strong><?= $colonist['summercamp']->room_number ?><br>
                <strong>Telefone(s): </strong> <?= $colonist['colonist']->phone1 ?> -- <?= $colonist['colonist']->phone2 ?><br>
                <br>
                <?php if($type == "Listagem de Quarto") {} else if($type == "Listagem de Inscrições"){?>
                <strong><?= $amigo ?> 1: </strong><?= $colonist['summercamp']->roommate1 ?><br>
                <strong><?= $amigo ?> 2: </strong><?= $colonist['summercamp']->roommate2 ?><br>
                <strong><?= $amigo ?> 3: </strong><?= $colonist['summercamp']->roommate3 ?><br>
                <br>
                <?php }?>

                <table>
                    <tr>
                        <td>
                            <?php
                            $key = 'father';
                            $person = 'Pai';
                            if ($colonist[$key]) {
                                ?>
                                <h3><?= $person ?>:</h3>
                                <strong>Nome: </strong><?= $colonist[$key]->fullname ?><br>
                                <strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?><br>
                                <strong>E-mail: </strong> <?= $colonist[$key]->email ?><br>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $key = 'mother';
                            $person = 'Mãe';
                            if ($colonist[$key]) {
                                ?>
                                <h3><?= $person ?>:</h3>
                                <strong>Nome: </strong><?= $colonist[$key]->fullname ?><br>
                                <strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?><br>
                                <strong>E-mail: </strong> <?= $colonist[$key]->email ?><br>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>

                </table>

                <?php
                $key = 'responsable';
                $person = 'Responsável';
                if ($colonist[$key]) {
                    ?>
                    <h3><?= $person ?>:</h3>
                    <strong>Nome: </strong><?= $colonist[$key]->fullname ?><br>
                    <strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> -- <?= $colonist[$key]->phone2 ?><br>
                    <strong>E-mail: </strong> <?= $colonist[$key]->email ?><br>
                    <?php
                }
                ?>
                <strong>----------------------------------------------------------------------------------------------------------------------------</strong>
            </div>
        </div>
    </div>
    <?php
}
