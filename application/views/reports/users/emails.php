<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10 middle-content">
        <h3>Histórico de emails</h3>
        <br>
        <?php
        if (isset($emails) && count($emails) > 0) {
            ?>
            <table class="table table-condensed table-hover">
                <tr>
                    <th>Data e hora</th>
                    <th>Mensagem</th>
                    <th>Entregue com sucesso</th>
                </tr>
                <?php
                foreach ($emails as $email) {
                    ?>
                    <tr>
                        <td><?= date_format(date_create($email->date_sent), 'd/m/y H:i') ?></td>
                        <td><?= $email->content ?></td>
                        <td>
                            <?php
                            if ($email->successfully_sent)
                                echo 'Sim';
                            else
                                echo "Não";
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        <?php } else { ?>
            <h3> Nenhuma e-mail até o momento.</h3>
        <?php } ?>

    </div>
</div>