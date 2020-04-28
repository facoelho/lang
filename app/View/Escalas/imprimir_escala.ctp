<?php $this->layout = 'naoLogado'; ?>

<?php
//$participantes = array('Alice Gonzales', 'Antonio Lima', 'Bento', 'Dudu Lang', 'Eduardo Foster', 'Luciano Salbego', 'Michele Knabach', 'Micheli Pedra', 'Papola', 'Paulo Jr', 'Rafael Paiva', 'Rosa Amélia');
//setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
//date_default_timezone_set('America/Sao_Paulo');
$cont = 0;
$i = 1;
$numerodias = 1;
$data = $dtinicio;
$string = 'SatSun';
?>

<div id="informacao_leads">
    <h3><center><b><?php echo 'Escala: ' . $mes . '-' . $ano; ?></b></center></h3>
</div>

<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Dia'; ?></th>
        <th><?php echo 'Corretor'; ?></th>
    </tr>
    <?php
    $numParticipantes = sizeof($participantes);
    while ($diafim >= $numerodias) {
        $diasemana = strftime('%a', strtotime($numerodias . '-' . substr($dtinicio, 5, 2) . '-' . substr($dtinicio, 0, 4)));
        $pos = strpos($string, $diasemana);
        if ($pos === false) {
            $nome = $participantes[rand(0, $numParticipantes - 1)];
            foreach ($participantes as $chave => $corretor) :
                if ($nome == $corretor) {
                    unset($participantes[$chave]);
                }
            endforeach;
            ?>
            <tr>
                <td><?php echo '<b>' . substr($data, 8, 2) . '/' . substr($data, 5, 2) . '</b>'; ?>&nbsp;</td>
                <td><?php echo $nome; ?>&nbsp;</td>
            </tr>

            <?php
            $participantes = array_values($participantes);
            $numParticipantes = sizeof($participantes);
            if (empty($participantes)) {
                $participantes = $participantes_aux;
            }
            ?>
            <?php
            $nome = $participantes[rand(0, $numParticipantes - 1)];
            foreach ($participantes as $chave => $corretor) :
                if ($nome == $corretor) {
                    unset($participantes[$chave]);
                }
            endforeach;
            ?>
            <tr>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo $nome; ?>&nbsp;</td>
            </tr>
            <?php
            ?>
            <?php
            $participantes = array_values($participantes);
            $numParticipantes = sizeof($participantes);
            if (empty($participantes)) {
                $participantes = $participantes_aux;
            }
            ?>
            <tr>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo '<b>' . '2º Turno' . '</b>'; ?>&nbsp;</td>
            </tr>
            <?php
            $nome = $participantes[rand(0, $numParticipantes - 1)];
            foreach ($participantes as $chave => $corretor) :
                if ($nome == $corretor) {
                    unset($participantes[$chave]);
                }
            endforeach;
            ?>
            <tr>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo $nome; ?>&nbsp;</td>
            </tr>
            <?php
            ?>
            <?php
            $participantes = array_values($participantes);
            $numParticipantes = sizeof($participantes);
            if (empty($participantes)) {
                $participantes = $participantes_aux;
            }
            ?>
            <?php
            $nome = $participantes[rand(0, $numParticipantes - 1)];
            foreach ($participantes as $chave => $corretor) :
                if ($nome == $corretor) {
                    unset($participantes[$chave]);
                }
            endforeach;
            ?>
            <tr>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo $nome; ?>&nbsp;</td>
            </tr>
            <?php
            ?>
            <?php
            $participantes = array_values($participantes);
            $numParticipantes = sizeof($participantes);
            if (empty($participantes)) {
                $participantes = $participantes_aux;
            }
            ?>
            <tr>
                <td><?php echo ''; ?>&nbsp;</td>
                <td><?php echo ''; ?>&nbsp;</td>
            </tr>
        <?php } ?>
        <?php
        $numerodias++;
        $data = date('Y-m-d', strtotime("+1 days", strtotime($data)));
        ?>
    <?php } ?>
</table>