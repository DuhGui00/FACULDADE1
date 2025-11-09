<?php
// Bloco de Processamento PHP
// Verifica se a página foi acessada via POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Se não for um POST, redireciona para o formulário
    header('Location: index.html');
    exit;
}

// 1. Coletar e limpar dados básicos (usando htmlspecialchars para segurança)
$nome = htmlspecialchars($_POST['nome']);
$email = htmlspecialchars($_POST['email']);
$telefone = htmlspecialchars($_POST['telefone']);
$nascimento = htmlspecialchars($_POST['nascimento']);
$idade = htmlspecialchars($_POST['idade']);

// 2. Coletar dados de 'Educação' e 'Competências' (preservando quebras de linha)
$educacao = nl2br(htmlspecialchars($_POST['educacao']));
$competencias = nl2br(htmlspecialchars($_POST['competencias']));

// 3. Coletar dados dinâmicos de 'Experiências'
$experiencias = [];
if (isset($_POST['exp_cargo']) && is_array($_POST['exp_cargo'])) {
    foreach ($_POST['exp_cargo'] as $key => $cargo) {
        $empresa = htmlspecialchars($_POST['exp_empresa'][$key]);
        $periodo = htmlspecialchars($_POST['exp_periodo'][$key]);
        $descricao = nl2br(htmlspecialchars($_POST['exp_descricao'][$key]));

        if (!empty($cargo) && !empty($empresa)) {
            $experiencias[] = [
                'cargo' => $cargo,
                'empresa' => $empresa,
                'periodo' => $periodo,
                'descricao' => $descricao
            ];
        }
    }
}

// 4. Iniciar a Geração do Currículo (HTML)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo de <?= $nome ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="cv-page">

    <div class="container text-center py-3 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg">
            🖨️ Baixar / Imprimir Currículo
        </button>
        <a href="index.html" class="btn btn-secondary btn-lg">Voltar ao Formulário</a>
    </div>

    <div class="cv-container" id="cv-para-imprimir">
        <header class="cv-header">
            <h1><?= $nome ?></h1>
            <p>Email: <?= $email ?> | Telefone: <?= $telefone ?> | Idade: <?= $idade ?> anos</p>
        </header>

        <section class="cv-section">
            <h2>🎓 Educação</h2>
            <p><?= $educacao ?></p>
        </section>

        <section class="cv-section">
            <h2>💼 Experiências Profissionais</h2>
            <?php if (empty($experiencias)): ?>
                <p>Nenhuma experiência profissional informada.</p>
            <?php else: ?>
                <?php foreach ($experiencias as $exp): ?>
                    <div class="exp-item">
                        <h4><?= $exp['cargo'] ?></h4>
                        <p class="mb-1"><strong><?= $exp['empresa'] ?></strong> | <?= $exp['periodo'] ?></p>
                        <p><?= $exp['descricao'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <section class="cv-section">
            <h2>🛠️ Competências e Habilidades</h2>
            <p><?= $competencias ?></p>
        </section>
    </div>

</body>
</html>