<?php
echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank'));
//echo $this->Form->create('Relatorio', array('escape' => false));
?>
<fieldset>
    <?php
    echo $this->Form->input('origen_id', array('id' => 'origenID', 'options' => $origens, 'type' => 'select', 'label' => 'Mídia de origem', 'empty' => ' -- Selecione a Mídia de origem -- '));
    echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'type' => 'select', 'label' => 'Selecione o corretor', 'empty' => ' -- Selecione o corretor -- '));
    echo $this->Form->input('sem_atendimento', array('id' => 'sem_atendimentoID', 'options' => $options, 'label' => 'Leads sem atendimento', 'empty' => ' -- Selecione uma opção -- '));
    echo $this->Form->input('sem_contato', array('id' => 'sem_contatoID', 'options' => $options, 'label' => 'Leads sem contato', 'empty' => ' -- Selecione uma opção -- '));
    echo $this->Form->input('ficha', array('id' => 'fichaID', 'options' => $options, 'label' => 'Leads com ficha', 'empty' => ' -- Selecione uma opção -- '));
    echo $this->Form->input('sem_interesse', array('id' => 'sem_interesseID', 'options' => $options, 'label' => 'Leads sem interesse', 'empty' => ' -- Selecione uma opção -- '));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Validar')); ?>

<?php
$this->Js->get('#origenID')->event(
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