<style>
	span {
		font-size: 12px;
	}
</style>

<table width="100%">

 	<tr>
        <td align="center">
       
            	<h1><?= $summercamp; ?></h1></td>
    </tr>
</table>
    
     <tr>
        <td align="center">
       <?php if($coordinators!=null){?>
            	<h1><?= 'Coordenadores:'; ?></h1></td>
    </tr>
    <?php foreach($coordinators as $coordinator) {?>
    <div class="row">
		        <div class="col-lg-12 middle-content">
		            <div class="row">
		                <h3><strong><?=$coordinator->fullname; ?></strong></h3>
		                </div>
		                </div>
		                </div>
	<?php }} if($doctor!=null){?>
      <tr>
        <td align="center">
       
            	<h1><?= 'Médico:'; ?></h1></td>
    </tr>
    <div class="row">
		        <div class="col-lg-12 middle-content">
		            <div class="row">
		                <h3><strong><?=$doctor->fullname; ?></strong></h3>
		                </div>
		                </div>
		                </div>
		<?php } if($monitors!=null){?>                
	 <tr>
        <td align="center">
       
            	<h1><?= 'Monitores/Auxiliares:'; ?></h1></td>
    </tr>
    <?php foreach($monitors as $monitor) {?>
    <div class="row">
		        <div class="col-lg-12 middle-content">
		            <div class="row">
		                <h3><strong><?=$monitor->fullname; ?></strong></h3>
		                </div>
		                </div>
		                </div>
	<?php }}?>