<body>
    <div class="main-container-report">
        <div class = "row">
            <div class="col-lg-10" bgcolor="red">
                <table>
                    <tr>
                        <th align="right" width='200px'>
                            Cadastrados
                        </th>
                        <td width="60px" align='right'>
                            <?php echo $users[0]->count_users; ?>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" >
                            Sócios contribuintes
                        </th>
                        <td align='right'>
                            <?php echo $users[0]->count_associates; ?>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" >
                            Sócios beneméritos
                        </th>
                        <td align='right'>
                            <?php echo $users[0]->count_benemerit; ?>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" >
                            Não associados
                        </th>
                        <td align='right'>
                            <?php echo $users[0]->count_non_associate; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>