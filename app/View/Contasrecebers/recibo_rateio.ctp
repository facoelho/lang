<?php $this->layout = 'naoLogado'; ?>
<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.UTF-8', 'portuguese');
//date_default_time_set('America/Sao_Paulo');
?>
<p>
<table border="0" style ="width:90%">
    <tr>
        <td align="left"><b>REALCE IMOVEIS LTDA</b></td>
    </tr>
    <tr>
<!--            <td align="left"><b>CNPJ:</b><?php //echo '94.132.024/0002-29';                                    ?></td>
        <td align="center"><?php //echo 'CC: ENGENHARIA FINEP BASKET CUSTOM';                                    ?></td>-->
        <td><?php echo ''; ?></td>
        <td><?php echo ''; ?></td>
    </tr>
    <tr>
        <td></td>
        <td align="center"><?php echo ''; ?></td>
        <td align="center"><?php echo strftime('%B de %Y', strtotime(date($func['Infomensalfuncionario']['datafechamento']))); ?></td>
    </tr>
    <tr>
        <td align="left"><b>Funcionario: </b> <?php echo 'Maryana Belloni'; ?></td>
    </tr>
</table>
<table border = "1" style = "width:90%">
    <tr>
        <td colspan = "1" align = "left"><b>Descrição</b></td>
        <td colspan = "1" align = "right"><b>Total</b></td>
    </tr>
    <tr>
        <td colspan = "1" align = "left"><?php echo 'PREMIAÇÃO'; ?> </td>
        <td colspan = "1" align = "right"><?php echo number_format($func['Infomensalfuncionario']['anueniovalor'], 2, ', ', '.'); ?> </td>
    </tr>
</table>
<br><br><br><br>
<table border = "0" style = "width:90%">
    <tr>
        <th></th>
        <th></th>
        <th colspan = "1" align = "left">Declaro ter recebido a importância líquida discriminada neste recibo</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th>___/___/___</th>
        <th>_________________________________</th>
    </tr>
    <tr>
        <th></th>
        <th colspan = "1" align = "center">Data</th>
        <th colspan = "1" align = "center">Assinatura do Funcionário</th>
    </tr>
</table>

<br><br><br>

<tr>
    <th><?php echo '----------------------------------------------------------------------------------------------------'; ?> </th>
</tr>

<br><br><br>

<table border="0" style ="width:90%">
    <tr>
        <td align="left"><b> <?php echo 'FREEDOM VEICULOS ELETRICOS LTDA' ?> </b></td>
    </tr>
    <tr>
<!--            <td align="left"><b>CNPJ:</b><?php //echo '94.132.024/0002-29';                                    ?></td>
        <td align="center"><?php //echo 'CC: ENGENHARIA FINEP BASKET CUSTOM';                                    ?></td>-->
        <td><?php echo ''; ?></td>
        <td><?php echo ''; ?></td>
    </tr>
    <tr>
        <td></td>
        <td align="center"><?php echo 'Mensalista'; ?></td>
        <td align="center"><?php echo strftime('%B de %Y', strtotime(date($func['Infomensalfuncionario']['datafechamento']))); ?></td>
    </tr>
    <tr>
        <td align="left"><b>Funcionario: </b> <?php echo 'Maryana Belloni'; ?></td>
    </tr>
</table>
<table border = "1" style = "width:90%">
    <tr>
        <td colspan = "1" align = "left"><b>Descrição</b></td>
        <td colspan = "1" align = "right"><b>Total</b></td>
    </tr>
    <tr>
        <td colspan = "1" align = "left"><?php echo 'PREMIAÇÃO'; ?> </td>
        <td colspan = "1" align = "right"><?php echo number_format(0, 2, ', ', '.'); ?> </td>
    </tr>
</table>
<br><br><br>
<table border = "0" style = "width:90%">
    <tr>
        <th></th>
        <th></th>
        <th colspan = "1" align = "left">Declaro ter recebido a importância líquida discriminada neste recibo</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th>___/___/___</th>
        <th>_________________________________</th>
    </tr>
    <tr>
        <th></th>
        <th colspan = "1" align = "center">Data</th>
        <th colspan = "1" align = "center">Assinatura do Funcionario</th>
    </tr>
</table>
</p>
<?php echo "<div style='page-break-before:always;'>&nbsp</div>"; ?>