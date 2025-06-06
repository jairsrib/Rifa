<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Rifa</title>
    <style>
        .premio-com-imagem {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .premio-com-imagem img {
            max-width: 100px;
            max-height: 100px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <h1>Informe a quantidade de bilhetes a ser gerados</h1>
        <label for="quantidade">Quantidade de bilhetes:</label>
        <input type="number" id="quantidade" name="quantidade" min="1" required>
        <br>
        <label for="nome">Nome da Campanha:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="premios">Prêmios da Rifa</label>

        <!-- Prêmio 1 -->
        <div class="messageBox">
            <div class="fileUploadWrapper">
                <label for="imgpremio1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 337 337" width="24" height="24">
                        <circle stroke-width="20" stroke="#6c6c6c" fill="none" r="158.5" cy="168.5" cx="168.5"></circle>
                        <path stroke-linecap="round" stroke-width="25" stroke="#6c6c6c" d="M167.759 79V259"></path>
                        <path stroke-linecap="round" stroke-width="25" stroke="#6c6c6c" d="M79 167.138H259"></path>
                    </svg>
                    <span class="tooltip">Adicionar imagem</span>
                </label>
                <input type="file" id="imgpremio1" name="imgpremio1" />
            </div>
            <input required placeholder="Prêmio 1" type="text" name="premio1" id="messageInput" />
        </div>

        <br>

        <!-- Prêmio 2 -->
        <div class="messageBox">
            <div class="fileUploadWrapper">
                <label for="file">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 337 337">
                        <circle
                            stroke-width="20"
                            stroke="#6c6c6c"
                            fill="none"
                            r="158.5"
                            cy="168.5"
                            cx="168.5"></circle>
                        <path
                            stroke-linecap="round"
                            stroke-width="25"
                            stroke="#6c6c6c"
                            d="M167.759 79V259"></path>
                        <path
                            stroke-linecap="round"
                            stroke-width="25"
                            stroke="#6c6c6c"
                            d="M79 167.138H259"></path>
                    </svg> <span class="tooltip">Add an image</span>
                </label>
                <input type="file" id="imgpremio2" name="imgpremio2" />
            </div>
            <input placeholder="Prêmio 2" type="text" name="premio2" id="messageInput" />
        </div>

        <br>

        <!-- Prêmio 3 -->
        <div class="messageBox">
            <div class="fileUploadWrapper">
                <label for="file">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 337 337">
                        <circle
                            stroke-width="20"
                            stroke="#6c6c6c"
                            fill="none"
                            r="158.5"
                            cy="168.5"
                            cx="168.5"></circle>
                        <path
                            stroke-linecap="round"
                            stroke-width="25"
                            stroke="#6c6c6c"
                            d="M167.759 79V259"></path>
                        <path
                            stroke-linecap="round"
                            stroke-width="25"
                            stroke="#6c6c6c"
                            d="M79 167.138H259"></path>
                    </svg>
                    <span class="tooltip">Add an image</span>
                </label>
                <input type="file" id="imgpremio3" name="imgpremio3" />
            </div>
            <input placeholder="Prêmio 3" type="text" name="premio3" id="messageInput" />
        </div>

        <br>
        <label for="valor">Valor da Rifa</label>
        <input type="number" id="valor" name="valor" min="0.01" step="0.01" required>
        <br>
        <button type="submit">Gerar Bilhetes</button>

        <h2>Bilhetes Gerados:</h2>
        <ul>

            <?php
            function salvarImagem($campo)
            {
                if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == 0) {
                    $tmp = $_FILES[$campo]['tmp_name'];
                    $nome = uniqid() . "-" . basename($_FILES[$campo]['name']);
                    $destino = "uploads/$nome";
                    if (!is_dir("uploads")) {
                        mkdir("uploads", 0777, true);
                    }
                    if (move_uploaded_file($tmp, $destino)) {
                        return $destino;
                    }
                }
                return null;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $quantidade = $_POST["quantidade"];

                // Salvar imagens
                $img1 = salvarImagem("imgpremio1");
                $img2 = salvarImagem("imgpremio2");
                $img3 = salvarImagem("imgpremio3");

                for ($i = 1; $i <= $quantidade; $i++) {
                    echo "<li>Bilhete #" . str_pad($i, 3, "0", STR_PAD_LEFT) . "</li>";
                    echo "<li>Nome da Campanha: " . htmlspecialchars($_POST["nome"]) . "</li>";

                    // Prêmio 1
                    echo "<li class='premio-com-imagem'><span>Prêmio 1: " . htmlspecialchars($_POST["premio1"]) . "</span>";
                    if ($img1) echo "<img src='$img1' alt='Imagem Prêmio 1'>";
                    echo "</li>";

                    // Prêmio 2
                    if (!empty($_POST["premio2"])) {
                        echo "<li class='premio-com-imagem'><span>Prêmio 2: " . htmlspecialchars($_POST["premio2"]) . "</span>";
                        if ($img2) echo "<img src='$img2' alt='Imagem Prêmio 2'>";
                        echo "</li>";
                    }

                    // Prêmio 3
                    if (!empty($_POST["premio3"])) {
                        echo "<li class='premio-com-imagem'><span>Prêmio 3: " . htmlspecialchars($_POST["premio3"]) . "</span>";
                        if ($img3) echo "<img src='$img3' alt='Imagem Prêmio 3'>";
                        echo "</li>";
                    }

                    echo "<li>Valor da Rifa: R$ " . number_format($_POST["valor"], 2, ',', '.') . "</li>";
                    echo "<hr>";
                }
            }
            ?>

        </ul>
    </form>
</body>

</html>