<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
?>
<br>
<br>
<?php echo $this->Form->create('Empresa', array('type' => 'file')); ?>
<fieldset>
    <?php
    echo $this->Form->input('razaosocial', array('label' => 'Razão social'));
    echo $this->Form->input('nomefantasia', array('label' => 'Nome fantasia'));
    echo $this->Form->input('cnpjEmpresa', array('id' => 'cnpjEmpresa', 'label' => 'CNPJ', 'type' => 'text', 'value' => $this->request->data['Empresa']['cnpj']));
    echo $this->Form->input('inscEstadualEmpresa', array('id' => 'inscEstadualEmpresa', 'label' => 'Inscrição estadual', 'type' => 'text', 'value' => $this->request->data['Empresa']['inscestadual']));
    echo $this->Form->input('inscMunicipalEmpresa', array('id' => 'inscMunicipalEmpresa', 'label' => 'Inscrição municipal', 'type' => 'text', 'value' => $this->request->data['Empresa']['inscmunicipal']));
    echo $this->Form->input('email', array('label' => 'E-mail'));
    echo $this->Form->input('homepage');
    echo $this->Form->input('logoempresa', array('type' => 'file','class' => 'file','label' => 'Logo da empresa (retrato 110x120) ou (paisagem 200x120)'));
    echo $this->Form->input('cnpj', array('type' => 'hidden'));
    echo $this->Form->input('inscestadual', array('type' => 'hidden'));
    echo $this->Form->input('inscmunicipal', array('type' => 'hidden'));
    echo $this->Form->input('img_foto', array('type' => 'hidden'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Editar')); ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $("#cnpjEmpresa").mask("999.999.999/9999-99");
        $("#inscEstadualEmpresa").mask("999/9999999");
        $("#inscMunicipalEmpresa").mask("999/9999999");
    });
</script>
