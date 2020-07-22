<?php $this->layout = 'naoLogado'; ?>
<?php $mesano = ''; ?>
<?php $entradas = 0; ?>
<?php $saidas = 0; ?>
<?php $lucro = 0; ?>
<?php $retiradas = 0; ?>
<?php $saldo = 0; ?>
<?php $saldo_final = 0; ?>
<?php $cont = 0; ?>
<br><br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Mês/Ano'; ?></th>
        <th><?php echo 'Tipo'; ?></th>
        <th><?php echo 'Valor'; ?></th>
    </tr>
    <?php foreach ($result as $key => $item): ?>
        <?php if ($mesano <> $item[0]['mesano']) { ?>
            <?php if ($cont > 0) { ?>
                <tr>
                    <td><?php echo ''; ?></td>
                    <td><b><?php echo 'Saldo'; ?></b></td>
                    <td><b><?php echo number_format((($entradas - $saidas) - $retiradas), 2, ",", "."); ?></b></td>
                </tr>
                <?php $saldo_final = $saldo_final + ($saldo + (($entradas - $saidas) - $retiradas)); ?>
                <?php $entradas = 0; ?>
                <?php $saidas = 0; ?>
                <?php $saldo = 0; ?>
                <?php $retiradas = 0; ?>
            <?php } ?>
            <tr>
                <td><b><?php echo $item[0]['mesano']; ?></b></td>
                <td colspan="3"><?php echo ''; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td><?php echo ''; ?>&nbsp;</td>
            <?php if ($item[0]['tipo'] == 'Entradas') { ?>
                <?php $entradas = $item[0]['valor']; ?>
                <td><?php echo $item[0]['tipo']; ?>&nbsp;</td>
            <?php } elseif ($item[0]['tipo'] == 'Saidas') { ?>
                <?php $saidas = $item[0]['valor']; ?>
                <td><?php echo $item[0]['tipo']; ?>&nbsp;</td>
            <?php } elseif ($item[0]['tipo'] == 'Retiradas') { ?>
                <td><?php echo $item[0]['tipo']; ?>&nbsp;</td>
                <?php $retiradas = $item[0]['valor']; ?>
            <?php } ?>
            <td><?php echo number_format($item[0]['valor'], 2, ",", "."); ?>&nbsp;</td>
        </tr>
        <?php if ($item[0]['tipo'] == 'Saidas') { ?>
                <!--<tr>-->
                    <!--<td><?php // echo '';   ?></td>-->
                    <!--<td><?php // echo 'Lucro';   ?></td>-->
                    <!--<td><?php // echo number_format($entradas - $saidas, 2, ",", ".");   ?></td>-->
            <!--</tr>-->
        <?php } ?>
        <?php $mesano = $item[0]['mesano']; ?>
        <?php $cont++; ?>
    <?php endforeach; ?>
<!--    <tr>
<td><?php // echo '';   ?></td>
<td><?php // echo 'Lucro';   ?></td>
<td><?php // echo number_format($entradas - $saidas, 2, ",", "");   ?></td>
</tr>-->
    <tr>
        <td><?php echo ''; ?></td>
        <td><b><?php echo 'Saldo'; ?></b></td>
        <td><b><?php echo number_format((($entradas - $saidas) - $retiradas), 2, ",", "."); ?></b></td>
    </tr>
    <?php $saldo_final = $saldo_final + ($saldo + (($entradas - $saidas) - $retiradas)); ?>
    <?php $entradas = 0; ?>
    <?php $saidas = 0; ?>
    <?php $saldo = 0; ?>
    <tr>
        <td colspan="3"><?php echo ''; ?></td>
    </tr>
    <tr>
        <td><?php echo ''; ?></td>
        <td><b><?php echo 'Saldo final'; ?></b></td>
        <td><b><?php echo number_format($saldo_final, 2, ",", "."); ?></b></td>
    </tr>
</table>
<br><br>

<?php $column_chart_linha->div('chart_div_linha'); ?>
<?php $column_chart_barras->div('chart_div'); ?>
<div id="chart_div_linha">
    <?php $this->GoogleCharts->createJsChart($column_chart_linha); ?>
</div>
<div id="chart_div">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>