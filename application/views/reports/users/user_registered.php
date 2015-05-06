<body>
    <div class="main-container">
        <div class = "row">
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
                            Sócios contribuintes
                        </td>
                        <td align='right'>
                            <?php echo $users[0]->count_associates; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sócios beneméritos
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
    </div>
</body>