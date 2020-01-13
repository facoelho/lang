<?php

/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$contato = $this->Session->read('contato');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <title><?php echo 'Eduardo Lang | E-mail Contato'; ?></title>
    </head>
    <body>
    <br><br>
    <center><?php echo $this->Html->image("/img/lang_grande.png", array("alt" => "Logo", "title" => "Logo"));?></center>
    <br>
    <p>
    <font size="2" face="Verdana">
        <center>
            Olá <?php echo $contato[0].', tudo bem?'; ?>
            <br><br>
            Há um tempo, você entrou em contato com a Imobiliária Eduardo Lang, e gostaríamos de saber
            se você já encontrou o imóvel que procurava?
            <br><br>
            Se ainda não encontrou, acesse a nossa ferramenta e rápidamente você nos informa as características do imóvel que esta buscando!!!
        </center>
    </font>
</p>
<br><br>
<center><?php echo $this->Html->link($this->Html->image("botoes/busca_imovel.png", array("alt" => "Informe as características do imóvel", "title" => "Informe as características do imóvel")), array('controller' =>'Imovelcaracteristicas', 'action' => 'caracteristicas', $contato[0], $contato[1]), array('escape' => false, 'target' => '_blank')); ?></center>
<br><br>
<center><?php echo $this->Html->link($this->Html->image("botoes/sem_interesse.png", array("alt" => "Não tenho mais interesse", "title" => "Não tenho mais interesse")), array('action' => 'sem_interesse'), array('escape' => false, 'target' => '_blank')); ?></center>
<br><br>
<center><?php echo $this->Html->image("botoes/contato.png"); ?></center>
</body>
</html>