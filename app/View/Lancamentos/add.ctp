<br>
<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('controller' => 'Caixas', 'action' => 'index'), array('escape' => false));
?>
<br>
<br>
<?php echo $this->Form->create('Lancamento'); ?>
<fieldset>
    <?php
    echo $this->Form->input('dtcaixa', array('id' => 'dtcaixaID', 'type' => 'text', 'readonly', 'label' => 'Data do lançamento', 'value' => $caixa[0]['Caixa']['dtcaixa']));
    echo $this->Form->input('descricao');
    echo $this->Form->input('categorias_pai', array('id' => 'categorias_paiID', 'type' => 'select', 'options' => $categorias_pai, 'label' => 'Categoria pai', 'empty' => '-- Selecione a categoria pai --'));
    echo $this->Form->input('categoria_id', array('id' => 'categoriaID', 'type' => 'select', 'label' => 'Categorias'));
    echo $this->Form->input('valor', array('id' => 'valorID', 'type' => 'text', 'label' => 'Valor do lançamento'));
    echo $this->Form->input('empresa_id', array('type' => 'hidden', 'value' => $empresa_id));
    ?>
</fieldset>
<?php echo $this->Form->end(__('SALVAR')); ?>

<script type="text/javascript">

    jQuery(document).ready(function() {

        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: "", precision: 2});

        if (window.location.host !== 'localhost') {
            $("#categorias_paiID").change(function() {
                $.ajax({async: true,
                    data: $("#categorias_paiID").serialize(),
                    dataType: "html",
                    success: function(data, textStatus) {
                        $("#categoriaID").html(data);
                    },
                    type: "post",
                    url: "http://www.imobiliariaeduardolang.com.br/gestao\/Categorias\/buscaCategorias\/Lancamento\/" + $("#categorias_paiID option:selected").val()
                });
            });
        } else {
            $("#categorias_paiID").change(function() {
                $.ajax({async: true,
                    data: $("#categorias_paiID").serialize(),
                    dataType: "html",
                    success: function(data, textStatus) {
                        $("#categoriaID").html(data);
                    },
                    type: "post",
                    url: "\/lang\/Categorias\/buscaCategorias\/Lancamento\/" + $("#categorias_paiID option:selected").val()
                });
            });
        }
    });
</script>
