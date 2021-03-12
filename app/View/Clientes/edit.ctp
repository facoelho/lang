<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Cliente'); ?>
<fieldset>
    <?php
    echo $this->Form->input('tipopessoa', array('id' => 'tipopessoaID', 'type' => 'select', 'options' => $tipopessoa, 'label' => 'Tipo de pessoa'));
    ?>
    <div id="frmJuridica">
        <?php
        echo $this->Form->input('cnpjCliente', array('id' => 'cnpjClienteID', 'label' => 'CNPJ', 'value' => $this->request->data['Cliente']['cnpj']));
        echo $this->Form->input('razaosocial', array('id' => 'razaosocialID', 'label' => 'Razao Social'));
        echo $this->Form->input('nomefantasia', array('id' => 'nomefantasiaID', 'label' => 'Nome Fantasia'));
        ?>
    </div>
    <div id="frmFisica">
        <?php
        echo $this->Form->input('cpfCliente', array('id' => 'cpfClienteID', 'label' => 'CPF', 'value' => $this->request->data['Cliente']['cpf']));
        echo $this->Form->input('nome', array('id' => 'nomeID', 'label' => 'Nome'));
        ?>
    </div>
    <?php
    echo $this->Form->input('telefoneCliente', array('id' => 'telefoneClienteID', 'label' => 'Telefone fixo', 'value' => $this->request->data['Cliente']['telefone']));
    echo $this->Form->input('email', array('id' => 'emailID', 'label' => 'Email'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<?php
$this->Js->get('#estadoID')->event(
        'change', $this->Js->request(
                array('controller' => 'Cidades', 'action' => 'buscaCidades', 'Cidade'), array('update' => '#cidadeID',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            )),
                )
        )
);
?>

<script>
    jQuery(document).ready(function() {
        document.getElementById('tipopessoaID').focus();
        $("#cnpjClienteID").mask("99.999.999/9999-99");
        $("#cpfClienteID").mask("999.999.999-99");
        $("#telefoneClienteID").mask("(99)99999999");

        $("#tipopessoaID").change(function() {
            if ($("#tipopessoaID").val() == 'J') {
                $("#frmJuridica").show();
                $("#frmFisica").hide();
                $("#cpfClienteID").val('');
                $("#nomeID").val('');
                $("#sobrenomeID").val('');
            }
            if ($("#tipopessoaID").val() == 'F') {
                $("#frmJuridica").hide();
                $("#frmFisica").show();
                $("#cnpjClienteID").val('');
                $("#razaosocialID").val('');
                $("#nomefantasiaID").val('');
            }
        });

        if ($("#tipopessoaID").val() == 'J') {
            $("#frmJuridica").show();
            $("#frmFisica").hide();
        } else {
            $("#frmJuridica").hide();
            $("#frmFisica").show();
        }
    });
</script>