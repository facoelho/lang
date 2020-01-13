<div id="formulario">
    <?php echo $this->Form->create('Contato', array('action' => 'send', 'type'=>'file')); ?>
    <table style="border:none;">
        <tr>
            <td>Remetente</td>
            <td><?php echo $this->Form->input('Contato.remetente', array('id' => 'remetente', 'label' => false, 'value' => 'Eduardo Lang Imóveis', 'readonly' => true, 'maxlength' => 100, 'size' => 40)); ?></td>
        </tr>
        <tr>
            <td>Telefone</td>
            <td><?php echo $this->Form->input('Contato.telefone', array('id' => 'telefone', 'label' => false, 'value' => '(53) 3225-5088',  'readonly' => true, 'maxlength' => 100, 'size' => 40)); ?></td>
        </tr>
        <tr>
            <td>Estabelecimento</td>
            <td><?php echo $this->Form->input('Contato.estabelecimento', array('id' => 'estabelecimento', 'label' => false, 'value' => 'Eduardo Lang Imóveis', 'readonly' => true, 'maxlength' => 100, 'size' => 40)); ?></td>
        </tr>
<!--        <tr>
            <td>Anexo</td>
            <td><?php echo $this->Form->input('anexo', array('type' => 'file','class' => 'file', 'label' => 'Anexo')); ?></td>
        </tr>-->
        <tr>
            <td>E-mail</td>
            <td><?php echo $this->Form->input('Contato.email', array('title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Selecione os clientes', 'type' => 'textarea', 'multiple' => true, 'style' => 'height: 600px;')); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><br><?php echo $this->Form->end('Enviar e-mail'); ?></td>
        </tr>
    </table>
</div>