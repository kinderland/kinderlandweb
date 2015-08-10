<?php
$myfile = fopen($path, "r") or die("Unable to open file!");
$file = fread($myfile, filesize($path));
?>
<div class="col-lg-9">
    <div class="row">
        <div class="col-lg-8">
            <table width="100%">
                <tr>
                    <td>
                        <?php
                        echo "<pre>";
                        print_r($file);
                        echo "</pre>";
                        ?>
                    </td>

                </tr>
            </table>
        </div>
    </div>
    <hr class="footer-hr" />
</div>
<?php fclose($myfile); ?>