<style>
	span {
		font-size: 12px;
	}
</style>

<table width="100%">
     <?php 
            if($type == "Cadastros" || $type == "Simples" || $type == "Documentos") { ?>
    <tr>
        <td align="center">
       
            	<h1><?= $summercamp ?></h1></td>
    </tr>
    <?php if($type == "Cadastros" || $type == "Documentos"){?>
    <tr>
        <td align="center">
            <h1><?php if($type == "Cadastros"){?>Cadastros dos Colonistas<?php } else {?>Documentos dos Colonistas<?php }?></h1>
        </td>
    </tr>
    <tr>
        <td align="center">
            <h3><?= $time ?></h3>
        </td>
     </tr>
     <?php }?>
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
<br><br><br><br><br><br><br><br><br>
<?php $colunistsNumber = 1;
foreach ($report as $colonist) {
    ?>
    <div class="row">
        <div class="col-lg-12 middle-content">
            <div class="row">
            <br>
                <span><strong><?= $colonist['colonist']->fullname ?></strong></span><br/>
                <span><strong>Sexo: </strong><?php
                if ($colonist['colonist']->gender == 'M') {
                    echo "Masculino";
                    $amigo = "Amigo";
                } else {
                    echo "Feminino";
                    $amigo = "Amiga";
                }
                ?></span><br />
                <span><strong>Data nascimento: </strong><?= date("d/m/Y", strtotime($colonist['summercamp']->birth_date)); ?></span><br />
                <span><strong>Escola: </strong><?= $colonist['summercamp']->school_name ?></span><br>
                <span><strong>Ano escolar: </strong><?= $colonist['summercamp']->school_year ?></span><br>
                <span><strong>Número Quarto: </strong><?= $colonist['summercamp']->room_number ?></span><br>
                <span><strong>Telefone(s): </strong> <?= $colonist['colonist']->phone1 ?> -- <?= $colonist['colonist']->phone2 ?></span><br>
                <br>
                <?php if($type == "Cadastros") {} else if($type == "Listagem de Inscrições"){?>
                <span><strong><?= $amigo ?> 1: </strong><?= $colonist['summercamp']->roommate1 ?></span><br>
                <span><strong><?= $amigo ?> 2: </strong><?= $colonist['summercamp']->roommate2 ?></span><br>
                <span><strong><?= $amigo ?> 3: </strong><?= $colonist['summercamp']->roommate3 ?></span><br>
               
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
                                <span><strong><?= $person ?>:</strong></span><br>
                                <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
                                <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?></span><br>
                                <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
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
                                <span><strong><?= $person ?>:</strong></span><br>
                                <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
                                <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?></span><br>
                                <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
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
                    <span><strong><?= $person ?>:</strong></span><br>
                    <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
                    <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> -- <?= $colonist[$key]->phone2 ?></span><br>
                    <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
   <?php $colunistsNumber++; if($colunistsNumber == 3) { $colunistsNumber = 0; ?>
    <p style="page-break-before: always"></p>
    <?php }?>
    <?php
}
