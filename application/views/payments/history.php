<div class="row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10 middle-content">
        <h3>Histórico de doações</h3>
        <br>
        <?php
        if (isset($donations) && count($donations) > 0) {
            ?>

            <table class="table table-condensed table-hover">
                <tr>
                    <th>Data e hora</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
                <?php
                foreach ($donations as $donation) {
                    ?>
                    <tr>
                        <td><?= date_format(date_create($donation->date_created), 'd/m/y H:i') ?></td>
                        <td><?= $donation->donation_type ?>
                        	<?php 
                                if(isset($donation->extra)){
                                    foreach($donation->extra as $extra){
                                		echo $extra;
                                	}
                                }
							?>
                        </td>
                        <td><?= $donation->donated_value ?></td>
                        <td><?= $donation->donation_status ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            ?>
            <h3>
                Nenhuma doação efetuada até o momento.
            </h3>
            <?php
        }
        ?>

    </div>
</div>