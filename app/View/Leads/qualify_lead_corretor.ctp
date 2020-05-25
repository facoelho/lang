<?php
$this->layout = 'naoLogado';
?>
<?php echo '<b>Origem: </b>' . $leads[0]['Origen']['descricao']; ?>
<br><br>
<?php echo '<b>Corretor: </b>' . $leads[0]['Corretor']['nome']; ?>
<br><br>
<?php echo $this->Form->create('Lead'); ?>
<?php echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'type' => 'hidden', 'value' => $leads[0]['Corretor']['id'])); ?>
<table cellpadding="0" border="0" style ="width:100%;">
    <tr>
        <th><?php echo 'Cliente'; ?></th>
        <th colspan="13"><?php echo ''; ?></th>
    </tr>
    <?php foreach ($leads as $item): ?>
        <tr>
            <td><?php echo $item['Cliente']['nome'] . '<br>' . $item['Cliente']['email'] . '<br>' . $item['Cliente']['telefone'] . '<br>' . '<b>' . 'Importado: ' . '</b>' . date('d/m/Y', strtotime($item['Importacaolead']['created'])) . '<br>' . '<b>' . 'Atualizado: ' . '</b>' . (!empty($item['Lead']['dt_alteracao']) ? date('d/m/Y', strtotime($item['Lead']['dt_alteracao'])) : ''); ?></td>

            <?php if ($item['Lead']['sem_atendimento'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('sem_atendimento.' . $item['Lead']['id'], array('id' => 'sem_atendimentoID', 'type' => 'checkbox', 'label' => 'S/atend', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('sem_atendimento.' . $item['Lead']['id'], array('id' => 'sem_atendimentoID', 'type' => 'checkbox', 'label' => 'S/atend', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['fone'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('fone.' . $item['Lead']['id'], array('id' => 'foneID', 'type' => 'checkbox', 'label' => 'Fone', 'checked' => true)) . $this->Form->input('fone_tentativas.' . $item['Lead']['id'], array('id' => 'fone_tentativasID', 'type' => 'text', 'label' => false, 'value' => $item['Lead']['fone_tentativas'], 'placeholder' => 'Nº', 'style' => 'height: 16px;width:25px;')); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('fone.' . $item['Lead']['id'], array('id' => 'foneID', 'type' => 'checkbox', 'label' => 'Fone', 'checked' => false)) . $this->Form->input('fone_tentativas.' . $item['Lead']['id'], array('id' => 'fone_tentativasID', 'type' => 'text', 'label' => false, 'value' => $item['Lead']['fone_tentativas'], 'placeholder' => 'Nº', 'style' => 'height: 16px;width:25px;')); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['whats'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('whats.' . $item['Lead']['id'], array('id' => 'whatsID', 'type' => 'checkbox', 'label' => 'Whats', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('whats.' . $item['Lead']['id'], array('id' => 'whatsID', 'type' => 'checkbox', 'label' => 'Whats', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['sem_contato'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('sem_contato.' . $item['Lead']['id'], array('id' => 'sem_contatoID', 'type' => 'checkbox', 'label' => 'S/contato', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('sem_contato.' . $item['Lead']['id'], array('id' => 'sem_contatoID', 'type' => 'checkbox', 'label' => 'S/contato', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['material_enviado'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('material_enviado.' . $item['Lead']['id'], array('id' => 'material_enviadoID', 'type' => 'checkbox', 'label' => 'Material enviado', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('material_enviado.' . $item['Lead']['id'], array('id' => 'material_enviadoID', 'type' => 'checkbox', 'label' => 'Material enviado', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['email'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('email.' . $item['Lead']['id'], array('id' => 'emailID', 'type' => 'checkbox', 'label' => 'Email', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('email.' . $item['Lead']['id'], array('id' => 'emailID', 'type' => 'checkbox', 'label' => 'Email', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['sem_interesse'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('sem_interesse.' . $item['Lead']['id'], array('id' => 'sem_interesseID', 'type' => 'checkbox', 'label' => 'S/interesse', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('sem_interesse.' . $item['Lead']['id'], array('id' => 'sem_interesseID', 'type' => 'checkbox', 'label' => 'S/interesse', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['ficha'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('ficha.' . $item['Lead']['id'], array('id' => 'fichaID', 'type' => 'checkbox', 'label' => 'Ficha', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('ficha.' . $item['Lead']['id'], array('id' => 'fichaID', 'type' => 'checkbox', 'label' => 'Ficha', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['preco'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('preco.' . $item['Lead']['id'], array('id' => 'precoID', 'type' => 'checkbox', 'label' => 'Preço', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('preco.' . $item['Lead']['id'], array('id' => 'precoID', 'type' => 'checkbox', 'label' => 'Preço', 'checked' => false)); ?></td>
            <?php } ?>
            <?php if ($item['Lead']['localizacao'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('localizacao.' . $item['Lead']['id'], array('id' => 'localizacaoID', 'type' => 'checkbox', 'label' => 'Localiz', 'checked' => true)) . $this->Form->input('imoveltipo_id.' . $item['Lead']['id'], array('id' => 'imoveltipoID', 'options' => $imoveltipos, 'type' => 'select', 'label' => false, 'value' => $item['Lead']['imoveltipo_id'], 'empty' => '-- Tipo de imóvel --', 'style' => 'width: 80px;font-size:12px')) . $this->Form->input('bairro_preferencial_id.' . $item['Lead']['id'], array('id' => 'bairroID', 'options' => $bairros, 'type' => 'select', 'label' => false, 'value' => $item['Lead']['bairro_preferencial_id'], 'empty' => '-- Bairro preferencial --', 'style' => 'width: 80px;font-size:12px')); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('localizacao.' . $item['Lead']['id'], array('id' => 'localizacaoID', 'type' => 'checkbox', 'label' => 'Localiz', 'checked' => false)) . $this->Form->input('imoveltipo_id.' . $item['Lead']['id'], array('id' => 'imoveltipoID', 'options' => $imoveltipos, 'type' => 'select', 'label' => false, 'value' => $item['Lead']['imoveltipo_id'], 'empty' => '-- Tipo de imóvel --', 'style' => 'width: 80px;font-size:12px')) . $this->Form->input('bairro_preferencial_id.' . $item['Lead']['id'], array('id' => 'bairroID', 'options' => $bairros, 'type' => 'select', 'label' => false, 'value' => $item['Lead']['bairro_preferencial_id'], 'empty' => '-- Bairro preferencial --', 'style' => 'width: 80px;font-size:12px')); ?></td>
            <?php } ?>

            <?php if ($item['Lead']['compra'] == 'S') { ?>
                <td align="center"><?php echo $this->Form->input('compra.' . $item['Lead']['id'], array('id' => 'compraID', 'type' => 'checkbox', 'label' => 'Compra', 'checked' => true)); ?></td>
            <?php } else { ?>
                <td align="center"><?php echo $this->Form->input('compra.' . $item['Lead']['id'], array('id' => 'compraID', 'type' => 'checkbox', 'label' => 'Compra', 'checked' => false)); ?></td>
            <?php } ?>
            <?php echo $this->Form->input('id.' . $item['Lead']['id'], array('id' => 'clienteID', 'type' => 'hidden', 'value' => $item['Cliente']['id'])); ?>
        </tr>
        <td colspan="4"></td>
        <td colspan="12"><font size="1"><?php echo $this->Form->input('obs.' . $item['Lead']['id'], array('id' => 'obsID', 'type' => 'textarea', 'label' => false, 'value' => $item['Lead']['obs'], 'placeholder' => 'Observação', 'style' => 'height: 60px;')); ?></font></td>
    <?php endforeach; ?>
</table>
<?php echo $this->Form->end(__('Salvar')); ?>
<p>
    <?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers(array('first' => 4, 'last' => 4)) . "| </p>";
    } else {
        echo $this->Paginator->counter('{:count}') . " registros encontrados.";
    }
    ?>
</p>
