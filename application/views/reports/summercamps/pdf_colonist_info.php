<?php
foreach ($report as $colonist) {
    ?>
    <div class="row">
        <div class="col-lg-12 middle-content">
            <div class="row">
                <h2><?= $colonist['colonist']->fullname ?></h2>
                <strong>Sexo:</strong><?php
                if ($colonist['colonist']->gender == 'M') {
                    echo "Masculino";
                } else {
                    echo "Feminino";
                }
                ?><br>
                <strong>Data nascimento: </strong><?= date("d/m/Y", strtotime($colonist['summercamp']->birth_date)); ?><br>
                <strong>Número Quarto: </strong><?= $colonist['summercamp']->room_number ?><br>
                <strong>Ano escolar: </strong><?= $colonist['summercamp']->school_year ?><br>
                <strong>Telefone(s): </strong> <?= $colonist['colonist']->phone1 ?> -- <?= $colonist['colonist']->phone2 ?><br>
                <br>
                <strong>Colega de quarto 1:</strong><?= $colonist['summercamp']->roommate1 ?><br>
                <strong>Colega de quarto 2:</strong><?= $colonist['summercamp']->roommate2 ?><br>
                <strong>Colega de quarto 3:</strong><?= $colonist['summercamp']->roommate3 ?><br>
                <br>

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
                                <strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> -- <?= $colonist[$key]->phone2 ?><br>
                                <strong>E-mail): </strong> <?= $colonist[$key]->email ?><br>
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
                                <strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> -- <?= $colonist[$key]->phone2 ?><br>
                                <strong>E-mail): </strong> <?= $colonist[$key]->email ?><br>
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
                    <strong>E-mail): </strong> <?= $colonist[$key]->email ?><br>
                    <?php
                }
                ?>
                <strong>----------------------------------------------------------------------------------------------------------------------------</strong>
            </div>
        </div>
    </div>
    <?php
}
