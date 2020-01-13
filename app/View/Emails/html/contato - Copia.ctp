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
    <center><a href="http://www.eduardolangimoveis.com.br"><img src="http://www.imobiliariaeduardolang.com.br/gestao/img/lang_grande.png"></a></center>
    <br>
    <p>
    <font size="2" face="Verdana">
        <center>
            Olá <?php echo $contato[0].', tudo bem?'; ?>
            <br><br>
            Em algum momento, você entrou em contato com a Imobiliária Eduardo Lang, e gostaríamos de saber,
            você já encontrou o imóvel que procurava?
            <br><br>
            Se ainda não encontrou, acesse a nossa ferramenta e em <b>menos de 1 minuto</b> você nos informa as características do imóvel que está buscando!!!
        </center>
    </font>
</p>
<br>
<br>
<center><a href="http://www.imobiliariaeduardolang.com.br/gestao/Caracteristicas/caracteristicas/<?php echo $contato[0].','.$contato[1]?>"><img src="http://www.imobiliariaeduardolang.com.br/gestao/img/botoes/busca_imovel.png" alt="Informe as características do imóvel" width=350 height=50></a></center>
<br>
<br>
<center><a href="http://www.imobiliariaeduardolang.com.br/gestao/Unsubscribes/unsubscribe/<?php echo $contato[1]?>"><img src="http://www.imobiliariaeduardolang.com.br/gestao/img/botoes/sem_interesse.png" alt="Não tenho mais interesse" width=250 height=40></a></center>
<br>
<br>
<center><img src="http://www.imobiliariaeduardolang.com.br/gestao/img/botoes/contato.png"></center>
</body>
<?php //  die(); ?>
</html>