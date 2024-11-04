<?php
require 'conexao.php';

// Consulta para obter todos os vídeos cadastrados
$sql = "SELECT * FROM videos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para transformar o link do YouTube em formato embed e extrair o ID do vídeo
function getVideoId($link) {
    if (strpos($link, 'youtube.com') !== false) {
        parse_str(parse_url($link, PHP_URL_QUERY), $params);
        return $params['v'] ?? null;
    } elseif (strpos($link, 'youtu.be') !== false) {
        return substr(parse_url($link, PHP_URL_PATH), 1);
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Vídeos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       body {
    margin: 0;
    padding: 0;
    background: #1e3a8a; /* Azul escuro */
    font-family: 'Arial', sans-serif;
    color: #fff;
}

h1 {
    margin-top: 20px;
    color: #ffffff;
    text-align: center;
}

.container {
    max-width: 1200px;
    margin: auto;
}

.card {
    margin: 20px;
    background-color: #ffffff;
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-body {
    padding: 15px;
    text-align: center;
}

.card-title {
    font-size: 1.2rem;
    color: #1e3a8a; /* Azul escuro */
}

.btn-primary {
    background-color: #4ade80; /* Verde claro */
    border: none;
    border-radius: 5px;
    color: #1e3a8a; /* Azul escuro */
    font-weight: bold;
    padding: 10px 20px;
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
}

.btn-primary:hover {
    background-color: #ffffff;
    color: #4ade80;
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Lista de Vídeos</h1>
        <div class="row">
            <?php foreach ($videos as $video): ?>
                <?php $videoId = getVideoId($video['link']); ?>
                <?php if ($videoId): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="https://img.youtube.com/vi/<?php echo $videoId; ?>/hqdefault.jpg" alt="Thumbnail do vídeo">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($video['nome']); ?></h5>
                                <a href="<?php echo htmlspecialchars($video['link']); ?>" class="btn btn-primary" target="_blank">Assistir</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
