<?php

//echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank'));
echo $this->Form->create('Relatorio', array('escape' => false)); ?>
<fieldset>
    <?php
    echo $this->Form->input('desempenho_id', array('id' => 'desempenhoID', 'options' => $desempenhos, 'type' => 'select', 'label' => 'Período desempenho' , 'empty'=>' -- Selecione o período do desempenho -- '));
    echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'type' => 'select', 'label' => 'Selecione o corretor', 'empty'=>' -- Selecione o corretor -- '));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Validar')); ?>

<?php
$this->Js->get('#desempenhoID')->event(
        'change', $this->Js->request(
                array('controller' => 'Corretors', 'action' => 'buscaCorretors', 'Corretor'), array('update' => '#corretorID',
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