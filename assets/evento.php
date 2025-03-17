<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = htmlspecialchars($_POST["titulo"]);
    $telefone = htmlspecialchars($_POST["telefone"]);
    $descricao = htmlspecialchars($_POST["descricao"]);
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];

    // Diretório para salvar imagens
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $arquivoNome = $_FILES["arquivo"]["name"];
    $arquivoTemp = $_FILES["arquivo"]["tmp_name"];
    $arquivoDestino = $uploadDir . basename($arquivoNome);
    $uploadOk = 1;

    // Verifica se o arquivo foi enviado
    if (!empty($arquivoNome)) {
        $fileType = strtolower(pathinfo($arquivoDestino, PATHINFO_EXTENSION));

        // Permitir apenas imagens JPG, JPEG e PNG
        $allowedTypes = ["jpg", "jpeg", "png"];
        if (!in_array($fileType, $allowedTypes)) {
            echo "Apenas arquivos JPG, JPEG e PNG são permitidos.<br>";
            $uploadOk = 0;
        }

        // Tamanho máximo do arquivo (5MB)
        if ($_FILES["arquivo"]["size"] > 5 * 1024 * 1024) {
            echo "O arquivo é muito grande (máximo 5MB).<br>";
            $uploadOk = 0;
        }

        // Se todas as verificações passarem, mover o arquivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($arquivoTemp, $arquivoDestino)) {
                $imagemURL = $arquivoDestino;
            } else {
                echo "Erro ao enviar a imagem.<br>";
                $imagemURL = "";
            }
        } else {
            $imagemURL = "";
        }
    } else {
        $imagemURL = "";
    }

    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Convite Gerado</title>
        <link rel='stylesheet' href='style.css'>
        <style>
            .convite {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .convite img {
                max-width: 100%;
                border-radius: 10px;
                margin-top: 10px;
            }
            .back-button {
                display: block;
                margin: 20px auto;
                padding: 10px;
                background: #007bff;
                color: white;
                text-align: center;
                text-decoration: none;
                border-radius: 5px;
                width: 150px;
            }
        </style>
    </head>
    <body>
        <div class='convite'>
            <h1>$titulo</h1>
            <p><strong>Descrição:</strong> $descricao</p>
            <p><strong>Telefone:</strong> $telefone</p>
            <p><strong>Data de Início:</strong> $inicio</p>
            <p><strong>Data de Término:</strong> $fim</p>";

    if (!empty($imagemURL)) {
        echo "<img src='$imagemURL' alt='Imagem do convite'>";
    }

    echo "<br><a href='evento.html' class='back-button'>Voltar</a>
        </div>
    </body>
    </html>";
}
?>
