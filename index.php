<?php
// Definir quais valores de botão são válidos
$buttonsValues = [1, 2, 3, '+', 4, 5, 6, '-', 7, 8, 9, '*', 'C', 0, '.', '/', '=', '<<'];

// Se o valor recebido do botão clicado é válido, então associá-lo à variável valor atual
$currentValue = '';
if (isset($_POST['button']) && in_array($_POST['button'], $buttonsValues)) {
    $currentValue = $_POST['button'];
}
// Se os valores recebidos anteriormente estão de acordo com a expressão regular dada, acrescentá-los na variável valores anteriores.
$previousValues = '';
if (isset($_POST['previousValues']) && preg_match('~^(?:[\d.-]+[*/+-]?)+$~', $_POST['previousValues'], $value)) {
    $previousValues = $value[0];
}
// Concatenar valores anteriores com o valor atual e associar o resultado na variável display.
$display = $previousValues . $currentValue;
// Se o valor recebido atual for igual a C, limpar o display.
if ($currentValue == 'C') {
    $display = '';
    // Se o valor recebido atual for igual a <<, apagar os 3 últimos caracteres do display, pois o << também é adicionado 
} elseif ($currentValue == '<<') {
    $display = substr($display, 0, -3);
    // Se o valor recebido atual for igual a = e se os valores anteriores corresponderem à expressão regular, fazer o cálculo com a função eval.   
} elseif ($currentValue == '=' && preg_match('~^\-?\d*\.?\d+(?:[*/+-]\d*\.?\d+)*$~', $previousValues)) {
    $display = eval("return $previousValues;");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <h1 class="title">Calculadora</h1>
    <form class="calculator" method="POST">
        <!-- Mostrar os valores pressionados e o resultado no display da calculadora -->
        <input class="displayCalculator" name="displayCalculator" readonly type="text" value="<?php echo $display; ?>">
        <div class="caculatorButtons">
            <button name="button" value="C" class="clear-button">C</button>
            <button name="button" value="<<"> << </button>
            <button name="button" value="/" class="operator">/</button>
            <button name="button" value="7">7</button>
            <button name="button" value="8">8</button>
            <button name="button" value="9">9</button>
            <button name="button" value="*" class="operator">*</button>
            <button name="button" value="4">4</button>
            <button name="button" value="5">5</button>
            <button name="button" value="6">6</button>
            <button name="button" value="-" class="operator">-</button>
            <button name="button" value="1">1</button>
            <button name="button" value="2">2</button>
            <button name="button" value="3">3</button>
            <button name="button" value="+" class="operator">+</button>
            <button name="button" value="0">0</button>
            <button name="button" value=".">.</button>
            <button name="button" value="=" class="operator equal">=</button>
        </div>
        </main>

        <!-- Armazenar os valores anteriores neste input temporariamente -->
        <?php echo "<input type=\"hidden\" name=\"previousValues\" value=\"$display\">"; ?>

</body>

</html>