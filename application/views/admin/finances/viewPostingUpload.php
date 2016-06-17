
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css"
              rel="stylesheet" />
      <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
              rel="stylesheet" />
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

    </head>
    <?php
    if (count($errors) > 0) {
        $all_errors = implode('', $errors);
        echo '<script type="text/javascript">alert("Os seguintes erros foram encontrados: \n' . $all_errors . '"); </script>';
    }
    ?>

    <div class="col-lg-10">
        <h4>Se algum documento já foi enviado, um novo envio de documento substituirá o anterior.
            </br>
            Apenas o último documento enviado será considerado.</h4>
        <form enctype="multipart/form-data" action="<?= $this->config->item('url_link'); ?>admin/updatePostingUpload?upload_id=<?php echo $upload_id; ?>" method="POST">
            <br>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
            <input type="hidden" name="has_upload" value="<?php
            if ($upload_id> 0)
             {
                echo "1";
            } else {

                echo "0";
            }
            ?>">
            <input type="hidden" name="document_id" value="<?php echo $document_id; ?>">
            <input type="hidden" name="portions" value="<?php echo $portions; ?>">
            Escolha um arquivo para enviar, aceitamos apenas arquivos .pdf, jpg, .jpeg e .png de até 2MB.
            <br>
            <input  type="file" name="uploadedfile" class="btn btn-primary"/> 
            <br />
            <div class="col-lg-2" >
                <input type="submit"  value="Enviar documento" class="btn btn-primary"/>
            </div>
        </form>
        <button style="margin-top:-15px" class="btn btn-warning" onclick="window.location.href = '<?= $this->config->item('url_link') ?>reports/postingExpenses'"> Voltar</button>
        <br>
        <br>
        <?php if ($upload_id > 0) { ?>
            <a target="_blank" href="<?= $this->config->item('url_link'); ?>admin/verifyPostingExpense?upload_id=<?php echo $upload_id;?>">
                <button class="btn btn-primary">
                    Visualizar último documento enviado
                </button> </a>

        <?php } ?> 






    </div>
</html>
