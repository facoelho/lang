<?php
$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <center><b><?php echo 'PERCENTUAL DE APROVEITAMENTO DA EQUIPE'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<br>
<?php $chart_div = 'chart_div'; ?>

<?php $column_chart_barras->div($chart_div); ?>

<div id="<?php echo $chart_div ?>">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>
<?php $descricao = $this->requestAction('/Leads/busca_nome_empreendimento', array('pass' => array($origen_id))); ?>
<center><b><?php echo $descricao; ?></b></center>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>