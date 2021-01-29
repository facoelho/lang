<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
$despesa = $this->Session->read('despesa');
$mensagem = $this->Session->read('mensagem');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <title><?php echo 'Sistema consultores Freedom'; ?></title>
    </head>
    <body>
        <h2><strong><?php echo 'Motivo: ' . $mensagem[0][0]['observacao']; ?></strong></h2>
    <br>
    <p>
        <strong> Id: </strong>
        <?php echo $despesa['Despesa']['id']; ?>
        <br>
        <strong> Consultor: </strong>
        <?php echo $despesa['User']['nome'] . ' ' . $despesa['User']['sobrenome']; ?>
        <br>
        <strong> Tipo de despesa: </strong>
        <?php echo $despesa['Tipodespesa']['descricao']; ?>
        <br>
        <?php if ($despesa['Despesa']['tipodespesa_cod'] == 'C') { ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Veículo: ' . substr($despesa['Placa']['placa'], 0, 3) . '-' . substr($despesa['Placa']['placa'], 3, 4) . ' / ' . $despesa['Placa']['descricao']; ?>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Combustível: ' . $despesa['Combustivel']['descricao']; ?>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Valor litro(R$): ' . number_format($despesa['Despesa']['valorlitro'], 2, ',', '.'); ?>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Odômetro(KM): ' . $despesa['Despesa']['odometro']; ?>
            <br>
        <?php } ?>
        <?php if ($despesa['Despesa']['formapagamento_cod'] == 'C') { ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Pagamento: ' . $despesa['Formapagamento']['descricao'] . ' / ' . 'xxxx.xxxx.xxxx.' . $despesa['Cartao']['numero']; ?>
        <?php } elseif ($despesa['Despesa']['formapagamento_cod'] == 'D') { ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Pagamento: ' . $despesa['Formapagamento']['descricao']; ?>
        <?php } ?>
        <br>
        <br>
        <strong> Descrição: </strong>
        <?php echo $despesa['Despesa']['descricao']; ?>
        <br>
        <strong> Valor total despesa: </strong>
        <?php echo number_format($despesa['Despesa']['valor'], 2, ',', '.'); ?>
        <br>
        <strong> Valor pessoal: </strong>
        <?php echo number_format($despesa['Despesa']['valor_pessoal'], 2, ',', '.'); ?>
        <br>
        <?php if (!empty($despesa['Despesa']['dtpagamento'])) { ?>
            <strong> Pagamento: </strong>
            <?php echo $despesa['Despesa']['dtpagamento']; ?>
        <?php } else { ?>
            <?php $parcelas = $this->requestAction('/Despesas/busca_parcelas', array('pass' => array($despesa['Despesa']['id']))); ?>
        <table border="0" style ="width:20%">
            <tr>
                <th colspan="2">Parcelas:</th>
            </tr>
            <?php foreach ($parcelas as $key => $item) : ?>
                <tr>
                    <td><?php echo $item['DespesaVencimento']['pagamento']; ?></td>
                    <td><?php echo number_format($item['DespesaVencimento']['valor'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php } ?>
</p>
<br>
<p>
    <?php if ($despesa['Despesa']['tipodespesa_cod'] == 'H') { ?>
        <strong> Entrada: </strong>
        <?php echo $despesa['Despesa']['dtentrada']; ?>
        <br>
        <strong> Saída: </strong>
        <?php echo $despesa['Despesa']['dtsaida']; ?>
    <?php } ?>
    <br>
    <strong> CNPJ no recibo: </strong>
    <?php if ($despesa['Despesa']['recibo_cnpj'] == 'S') { ?>
        <?php echo 'Sim'; ?>
    <?php } else { ?>
        <?php echo 'Não'; ?>
    <?php } ?>
    <br>
    <?php if (empty($despesa['Despesa']['origem_id'])) { ?>
        <strong> Isenção despesa: </strong>
        <?php if ($despesa['Despesa']['isencao_limite'] == 'S') { ?>
            <?php echo 'Sim'; ?>
        <?php } else { ?>
            <?php echo 'Não'; ?>
        <?php } ?>
        <br>
    <?php } ?>
    <strong> Cidade: </strong>
    <?php echo $despesa['Cidade']['nome']; ?>
    <br>
    <strong> Modificação: </strong>
    <?php echo $despesa['Despesa']['modified']; ?>
    <br>
    <strong> Observação: </strong>
    <?php echo $despesa['Despesa']['obs']; ?>
    <br>
</p>
<br>
<h3><strong><?php echo 'Para corrigir acesse: ' . 'https://swext.freedom.ind.br/cake/Despesas/edit/' . $despesa['Despesa']['id']; ?></strong></h3>
</body>
</html>