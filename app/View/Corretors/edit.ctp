<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Corretor'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome', array('label' => 'Nome', 'type' => 'text'));
    echo $this->Form->input('email', array('label' => 'E-mail', 'type' => 'text'));
    echo $this->Form->input('perc_comissao', array('id' => 'perc_comissaoID', 'type' => 'text', 'label' => 'Perc. comissão'));
    if ($this->request->data['Corretor']['gerencia'] == 'S') {
        echo $this->Form->input('gerencia', array('id' => 'gerenteID', 'options' => $opcoes, 'type' => 'select', 'label' => 'Gerente', 'value' => 'S'));
    } else {
        echo $this->Form->input('gerencia', array('id' => 'gerenteID', 'options' => $opcoes, 'type' => 'select', 'label' => 'Gerente', 'value' => 'N'));
    }
    ?>
    <div id="formGerente">
        <?php
        echo $this->Form->input('gerente_equipe', array('id' => 'corretorID', 'options' => $corretors, 'type' => 'select', 'label' => 'Selecione o gerente'));
        ?>
    </div>
</fieldset>
<?php echo $this->Form->end(__('Editar')); ?>

<script type="text/javascript">

    jQuery(document).ready(function() {

        $("#perc_comissaoID").maskMoney({showSymbol: false, decimal: ".", precision: 2})

        if ($("#gerenteID").val() == 'S') {
            $("#formGerente").hide();
        } else if ($("#gerenteID").val() == 'N') {
            $("#formGerente").show();
        }

        $("#gerenteID").change(function() {
            if ($("#gerenteID").val() == 'S') {
                $("#formGerente").hide();
            } else if ($("#gerenteID").val() == 'N') {
                $("#formGerente").show();
            }
        });
    });
</script>