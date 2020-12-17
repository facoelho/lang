<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$valor_corretor = 0;
$valor_total = 0;
$corretors = '';
?>
<div id="informacao_leads">
    <center><b><?php echo 'RELATÓRIO DE CONTAS A RECEBER'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Id'; ?></th>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Vendedor'; ?></th>
        <th><?php echo 'Comprador'; ?></th>
        <th><?php echo 'Valor'; ?></th>
    </tr>
    <?php foreach ($negociacaos as $item): ?>
        <?php
        $cont_corretor = $this->requestAction('/Contasrecebers/numero_corretors', array('pass' => array($item['Negociacao']['id'])));
        ?>
        <?php
        $corretors = $this->requestAction('/Contasrecebers/busca_corretors', array('pass' => array($item['Negociacao']['id'])));
        ?>
        <?php if ($corretor_id <> $item['Corretor']['id']) { ?>
            <?php if ($valor_corretor > 0) { ?>
                <tr>
                    <td colspan="4"><?php echo ''; ?>&nbsp;</td>
                    <td><b><font color="blue"><?php echo number_format($valor_corretor, 2, ',', '.'); ?>&nbsp;</b></td>
                </tr>
            <?php } ?>
            <?php $valor_corretor = 0; ?>
        <?php } ?>
        <tr>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>
            <td><?php echo $corretors; ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
            <td><?php echo number_format(($item['Negociacao']['valor_proposta'] / $cont_corretor), 2, ',', '.'); ?>&nbsp;</td>
            <?php $valor_corretor = $valor_corretor + ($item['Negociacao']['valor_proposta'] / $cont_corretor); ?>
        </tr>
        <?php $corretor_id = $item['Corretor']['id']; ?>
        <?php $valor_total = $valor_total + ($item['Negociacao']['valor_proposta'] / $cont_corretor); ?>
    <?php endforeach; ?>
    <td colspan="4"><?php echo ''; ?>&nbsp;</td>
    <td><b><font color="blue"><?php echo number_format($valor_corretor, 2, ',', '.'); ?>&nbsp;</b></td>
</table>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td><b><font color="blue"><?php echo 'Total final: ' . number_format($valor_total, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>