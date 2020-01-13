<?php $this->layout = 'naoLogado'; ?>
<?php
echo $this->Html->image("/img/logo_medio.png", array("alt" => "Imobiliária Eduardo Lang", "title" => "Imobiliária Eduardo Lang"));
?>
<div id="linha" style="float:right;">
    <?php echo $this->Html->image("/img/ligue.png", array("alt" => "Telefones de contato", "title" => "Telefones de contato")); ?>
</div>
<br>
<br>
<div id="linha" style="padding-top:2%; border-top:3px solid #ffcb05">
</div>
<?php echo $this->Form->create('Caracteristica'); ?>
<fieldset>
    <div class="operacao" style="margin-left:10%;position: absolute;float:left;color:#ffcb05">
        <div id="caracteristicas">
            <label><h3><u><b>Operação</b></u></h3></label><br>
            <?php foreach ($operacaotipos as $key => $oper) : ?>
                <?php echo $this->Form->input('operacao.' . $key, array('id' => 'operacaoID', 'type' => 'checkbox', 'label' => $oper, 'checked' => false)); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="tipoimovel" style="margin-left:35%;position:absolute;float:left;color:#ffcb05">
        <div id="caracteristicas">
            <label><h3><u>Tipo de imóvel</u></h3></label><br>
            <?php foreach ($imoveltipos as $key => $tipo) : ?>
                <?php echo $this->Form->input('tipoimovel.' . $key, array('id' => $key, 'type' => 'checkbox', 'label' => $tipo, 'checked' => false, 'value' => $key, 'onclick' => 'myfunction(this)')); ?>
            <?php endforeach; ?>
            <div id="formTipoImovelOutro">
                <?php echo $this->Form->input('outro', array('id' => 'outro', 'label' => false)); ?>
            </div>
        </div>
    </div>
    <div class="dormitorios" style="margin-left:70%;position:relative;float:left;color:#ffcb05">
        <div id="caracteristicas">
            <label><h3><u>Dormitórios</u></h3></label><br>
            <?php foreach ($dormitorios as $key => $dorm) : ?>
                <?php echo $this->Form->input('dormitorio.' . $key, array('id' => $key, 'type' => 'checkbox', 'label' => $dorm, 'checked' => false)); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="imovelsituacao" style="margin-left:10%;position:absolute;float:left;margin-top:240px;color:#ffcb05">
        <div id="caracteristicas">
            <label><h3><u>Situação</u></h3></label><br>
            <?php foreach ($imovelsituacaos as $key => $situacao) : ?>
                <?php echo $this->Form->input('situacao.' . $key, array('id' => 'fichaID', 'type' => 'checkbox', 'label' => $situacao, 'checked' => false)); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="mediavalor" style="margin-left:37%;position:relative;float:left;color:#ffcb05">
        <div id="caracteristicas">
            <label><h3><u>Média de valor</u></h3></label><br>
            <?php echo "<div style='color#fed51b;'>" . $this->Form->input('valor_max', array('id' => 'valorID', 'type' => 'text', 'label' => false)); ?>
        </div>
    </div>
    <?php echo $this->Form->input('nome', array('id' => 'nome', 'type' => 'hidden', 'value' => $nome)); ?>
    <?php echo $this->Form->input('email', array('id' => 'email', 'type' => 'hidden', 'value' => $email)); ?>
    <?php if (empty($nome)) { ?>
        <div class="contato" style="margin-left:0%;position:relative;color:#ffcb05">
            <?php echo "<div style='color#fed51b;'>" . $this->Form->input('celular', array('id' => 'celular', 'required' => true, 'type' => 'text', 'placeholder' => 'Celular do cliente', 'label' => false)) . $this->Form->input('emailaux', array('id' => 'emailaux', 'required' => true, 'type' => 'text', 'placeholder' => 'E-mail do cliente', 'label' => false)) . $this->Form->input('nomeaux', array('id' => 'nomeaux', 'required' => true, 'type' => 'text', 'placeholder' => 'Nome do cliente', 'label' => false)); ?>
        </div>
    <?php } ?>
    <center><?php echo $this->Form->end(__('Enviar características')); ?></center>

</fieldset>

<script type="text/javascript">
    function myfunction(obj) {
        if (obj.id == 4) {
            if (obj.checked) {
                $("#formTipoImovelOutro").show();
            } else {
                $("#formTipoImovelOutro").hide();
                $("#outro").val('');
            }
        }
    }
    jQuery(document).ready(function() {
        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        $("#formTipoImovelOutro").hide();
    });
</script>