<?php

$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i') ; ?></b>
</div>
<p><h2><center><b><?php echo $origen[0][0]['descricao']; ?></b></h2></center></p>
<br>
<?php $piechart->div('chart_div'); ?>

<div id="chart_div">
    <?php echo $this->GoogleCharts->createJsChart($piechart); ?>
</div>