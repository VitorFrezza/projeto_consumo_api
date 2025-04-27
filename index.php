<?php

$apiUrl = "https://servicodados.ibge.gov.br/api/v2/censos/nomes/ranking";

// Faz a requisição para a API do IBGE
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, "C:\\xampp\\php\\extras\\ssl\\cacert.pem");
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$dados = json_decode($response, true);
$nomes = $dados[0]["res"] ?? []; // Pega a lista de nomes

$rankingSolicitado = $_GET["ranking"] ?? null;
$resultado = null;

// Procura o nome com o ranking informado
if ($rankingSolicitado) {
    foreach ($nomes as $item) {
        if ($item["ranking"] == $rankingSolicitado) {
            $resultado = $item;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Consulta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Resultado da Consulta</h1>

    <?php if ($rankingSolicitado): ?>
        <h2>Ranking #<?= htmlspecialchars($rankingSolicitado) ?></h2>
        <?php if ($resultado): ?>
            <ul>
                <li><strong>Nome:</strong> <?= htmlspecialchars($resultado["nome"]) ?></li>
                <li><strong>Ranking:</strong> <?= htmlspecialchars($resultado["ranking"]) ?></li>
                <li><strong>Frequência:</strong> <?= htmlspecialchars($resultado["frequencia"]) ?></li>
            </ul>
        <?php else: ?>
            <p>Nenhum nome encontrado para esse ranking.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Ranking não informado.</p>
    <?php endif; ?>

    <p><a href="consulta_nome.php">Voltar</a></p>

</body>
</html>
