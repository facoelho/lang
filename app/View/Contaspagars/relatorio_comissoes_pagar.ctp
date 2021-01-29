<?php
$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$total_recebido = 0;
$total_agenciador = 0;
$total_agenciador_individual = 0;
$total_locacao = 0;
$total_recepcao = 0;
$corretor_id = '';
?>
<div id="informacao_leads">
    <center><b><?php echo 'RELATÓRIO DE CONTAS A PAGAR'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Id'; ?></th>
        <th><?php echo 'Contrato'; ?></th>
        <th><?php echo 'Proprietário'; ?></th>
        <th><?php echo 'Inquilino'; ?></th>
        <th><?php echo 'Valor'; ?></th>
        <th><?php echo 'Comercial'; ?></th>
        <th><?php echo 'Administrativo'; ?></th>
        <th><?php echo 'Recepção'; ?></th>
        <th><?php echo 'Agenciador'; ?></th>
    </tr>
    <?php foreach ($contaspagars as $item): ?>
        <?php if ($corretor_id <> $item['Contaspagar']['corretor_id']) { ?>
            <?php if ($total_agenciador_individual > 0) { ?>
                <tr>
                    <td colspan="7"><?php echo ''; ?>&nbsp;</td>
                    <td><strong><font color="blue"><?php echo $corretor_nome; ?>&nbsp;</font></strong></td>
                    <td><strong><font color="blue"><?php echo number_format($total_agenciador_individual, 2, ',', '.'); ?>&nbsp;</font></strong></td>
                </tr>
                <?php $total_agenciador_individual = 0; ?>
            <?php } ?>
        <?php } ?>
        <tr>
            <td><?php echo h($item['Contaspagar']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['contrato']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['proprietario']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['inquilino']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Contaspagar']['valor'], 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(((($item['Contaspagar']['valor']) * 0.30) * 0.40), 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(((($item['Contaspagar']['valor']) * 0.30) * 0.40), 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(((($item['Contaspagar']['valor']) * 0.30) * 0.20), 2, ',', '.'); ?>&nbsp;</td>
            <?php if (!empty($item['Contaspagar']['corretor_id'])) { ?>
                <td><?php echo number_format((($item['Contaspagar']['valor']) * 0.20), 2, ',', '.'); ?>&nbsp;</td>
                <?php $total_agenciador = $total_agenciador + ($item['Contaspagar']['valor'] * 0.20); ?>
            <?php } else { ?>
                <td><?php echo number_format(0, 2, ',', '.'); ?>&nbsp;</td>
            <?php } ?>

            <?php $total_locacao = $total_locacao + (($item['Contaspagar']['valor'] * 0.30) * 0.40); ?>
            <?php $total_recepcao = $total_recepcao + (($item['Contaspagar']['valor'] * 0.30) * 0.20); ?>
            <?php $total_agenciador_individual = $total_agenciador_individual + (($item['Contaspagar']['valor']) * 0.20); ?>
            <?php $total_recebido = $total_recebido + $item['Contaspagar']['valor']; ?>
        </tr>

        <?php $corretor_nome = $item['Corretor']['nome']; ?>
        <?php $corretor_id = $item['Contaspagar']['corretor_id']; ?>

    <?php endforeach; ?>
    <?php if (!empty($corretor_id)) { ?>
        <tr>
            <td colspan="7"><?php echo ''; ?>&nbsp;</td>
            <td><strong><font color="blue"><?php echo $corretor_nome; ?>&nbsp;</font></strong></td>
            <td><strong><font color="blue"><?php echo number_format($total_agenciador_individual, 2, ',', '.'); ?>&nbsp;</font></strong></td>
        </tr>
        <?php $total_agenciador_individual = 0; ?>
    <?php } ?>
</table>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td><b><font color="green"><?php echo 'Total recebido: ' . number_format($total_recebido, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Comercial: ' . number_format($total_locacao, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Administrativo: ' . number_format($total_locacao, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Recepção: ' . number_format($total_recepcao, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Agenciador: ' . number_format($total_agenciador, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="blue"><?php echo 'Total EL: ' . number_format($total_recebido - (2 * $total_locacao) - $total_recepcao - $total_agenciador, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>