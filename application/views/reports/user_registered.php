<div class = "row">
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
    <div class="col-lg-10" bgcolor="red">
        <h3>Relatório de usuários</h3><br>
        <table>
            <tr>
                <td width='150px'>
                    Cadastrados
                </td>
                <td align='right'>
                    <?php echo $users[0]->count_users; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Associados
                </td>
                <td align='right'>
                    <?php echo $users[0]->count_associates; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Beneméritos
                </td>
                <td align='right'>
                    <?php echo $users[0]->count_benemerit; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Não associados
                </td>
                <td align='right'>
                    <?php echo $users[0]->count_non_associate; ?>
                </td>
            </tr>
        </table>
    </div>
</div>