<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$total_recebido = 0;
$total_el = 0;
$total_corretor = 0;
$total_corretor_individual = 0;
$total_gerente_individual = 0;
$total_coordenador_individual = 0;
$total_ti_individual = 0;
$total_gerente = 0;
$total_ti = 0;
$total_coordenador = 0;
$corretor = '';
$nome = '';
?>
<div id="informacao_leads">
    <center><b><?php echo 'RELATÓRIO DE CONTAS A RECEBER'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Negociação'; ?></th>
        <th><?php echo 'Tipo Pessoa'; ?></th>
        <th><?php echo 'Vendedor'; ?></th>
        <th><?php echo 'CPF/CNPJ'; ?></th>
        <th><?php echo 'Tipo Pessoa'; ?></th>
        <th><?php echo 'Comprador'; ?></th>
        <th><?php echo 'CPF/CNPJ'; ?></th>
        <th><?php echo 'Ref'; ?></th>
        <th><?php echo 'Unid'; ?></th>
        <th><?php echo 'Valor imóvel'; ?></th>
        <th><?php echo 'Comissão'; ?></th>
        <th><?php echo 'NF EL'; ?></th>
    </tr>
    <?php foreach ($contasrecebers as $item): ?>
        <tr>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>

            <?php //Cliente vendedor ?>
            <?php if (!empty($item['Negociacao']['cliente_vendedor_id'])) { ?>
                <?php if ($item['Clientevendedor']['tipopessoa'] == 'F') { ?>
                    <td><?php echo 'Fisica'; ?>&nbsp;</td>
                    <td><?php echo h($item['Clientevendedor']['nome']); ?>&nbsp;</td>
                    <td><?php
                        echo substr($item['Clientevendedor']['cpf'], 0, 3) . "." .
                        substr($item['Clientevendedor']['cpf'], 3, 3) . "." .
                        substr($item['Clientevendedor']['cpf'], 6, 3) . "-" .
                        substr($item['Clientevendedor']['cpf'], 9, 2);
                        ?>&nbsp;
                    </td>
                <?php } elseif ($item['Clientevendedor']['tipopessoa'] == 'J') { ?>
                    <td><?php echo 'Jurídica'; ?>&nbsp;</td>
                    <td><?php echo h($item['Clientevendedor']['razaosocial']); ?>&nbsp;</td>
                    <td><?php
                        echo substr($item['Clientevendedor']['cnpj'], 0, 2) . "." .
                        substr($item['Clientevendedor']['cnpj'], 2, 3) . "." .
                        substr($item['Clientevendedor']['cnpj'], 5, 3) . "/" .
                        substr($item['Clientevendedor']['cnpj'], 8, 4) . "-" .
                        substr($item['Clientevendedor']['cnpj'], 12, 2);
                        ?>&nbsp;
                    </td>
                <?php } ?>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>

            <?php //Cliente comprador ?>
            <?php if (!empty($item['Negociacao']['cliente_comprador_id'])) { ?>
                <?php if ($item['Clientecomprador']['tipopessoa'] == 'F') { ?>
                    <td><?php echo 'Fisica'; ?>&nbsp;</td>
                    <td><?php echo h($item['Clientecomprador']['nome']); ?>&nbsp;</td>
                    <td><?php
                        echo substr($item['Clientecomprador']['cpf'], 0, 3) . "." .
                        substr($item['Clientecomprador']['cpf'], 3, 3) . "." .
                        substr($item['Clientecomprador']['cpf'], 6, 3) . "-" .
                        substr($item['Clientecomprador']['cpf'], 9, 2);
                        ?>&nbsp;
                    </td>
                <?php } elseif ($item['Clientecomprador']['tipopessoa'] == 'J') { ?>
                    <td><?php echo 'Jurídica'; ?>&nbsp;</td>
                    <td><?php echo h($item['Clientecomprador']['razaosocial']); ?>&nbsp;</td>
                    <td><?php
                        echo substr($item['Clientecomprador']['cnpj'], 0, 2) . "." .
                        substr($item['Clientecomprador']['cnpj'], 2, 3) . "." .
                        substr($item['Clientecomprador']['cnpj'], 5, 3) . "/" .
                        substr($item['Clientecomprador']['cnpj'], 8, 4) . "-" .
                        substr($item['Clientecomprador']['cnpj'], 12, 2);
                        ?>&nbsp;
                    </td>
                <?php } ?>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>
            <td><?php echo h($item['Negociacao']['referencia']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['unidade']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Negociacao']['valor_imovel'], 2, ',', '.'); ?>&nbsp;</td>
            <?php if ($item['Negociacaocorretor']['corretor_id'] <> 7) { ?>
                <td><?php echo number_format($item['Contasrecebermov']['valorparcela'], 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela']) - (($item['Contasrecebermov']['valorparcela'] * $item['Corretor']['perc_comissao'])), 2, ',', '.'); ?>&nbsp;</td>
            <?php } else { ?>
                <td><?php echo number_format(($item['Negociacao']['valor_imovel'] * 0.06), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format(($item['Negociacao']['valor_imovel'] * 0.06), 2, ',', '.'); ?>&nbsp;</td>
            <?php } ?>
        </tr>
    <?php endforeach; ?>
</table>