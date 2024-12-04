<?php
include('includes/post_functions.php'); // Inclui o arquivo PHP para usar suas funções

// Verificar se há uma consulta de pesquisa
if (isset($_GET['q'])) {
    $query = $_GET['q'];

    // Prepara a consulta SQL para buscar posts que contenham a string de pesquisa
    $sql = "SELECT * FROM posts WHERE content LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchQuery);
    $searchQuery = "%" . $query . "%";
    $stmt->execute();
    $result = $stmt->get_result();

    // Exibir os resultados da pesquisa
    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            echo '
                <div class="post">
                    <div class="post-content">
                        <div class="post-header">
                            <h3>' . htmlspecialchars($post['username']) . '</h3>
                            <h6> - ' . htmlspecialchars($post['created_at']) . '</h6>
                        </div>
                        <p>' . htmlspecialchars($post['content']) . '</p>
                    </div>
                </div>
            ';
        }
    } else {
        echo '<p>Nenhum post encontrado.</p>';
    }
}


// Página atual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Verificando a página mínima e máxima
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Calculando o limite de posts para a consulta
$offset = ($page - 1) * $postsPerPage;

// Definindo os limites de exibição de páginas (mostrando no máximo 3 páginas por vez)
$maxLinks = 3;
$startPage = max(1, $page - floor($maxLinks / 2)); // página inicial do bloco de links
$endPage = min($totalPages, $startPage + $maxLinks - 1); // página final do bloco de links
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Fórum</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    <br><br>

    <div class="container">
        <h1>Panel de Administración</h1>

        <!-- Botão para abrir a Modal de Gerenciamento de Tags -->
        <div class="container">
            <div class="section_bt">
                <button onclick="openModal()">Gestionar Etiquetas</button>
            </div>



            <!-- Posts Section -->
            <div class="header-container">
                <h2 class="PR">Publicaciones <span class="gear">⚙️</span></h2>
            </div>

            <?php foreach ($recentPosts as $post): ?>
                <div class="post">
                    <div class="post-content">
                        <div class="post-header">
                            <h3><?= $post['username']; ?></h3>
                            <h6> - <?= $post['created_at']; ?></h6>
                        </div>
                        <p><?= $post['content']; ?></p>
                    </div>

                    <!-- Formulário para editar o post -->
                    <div class="form-container">
                        <!-- Formulário para editar o post -->
                        <form action="admin.php" method="POST" class="form-item">
                            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                            <textarea name="content" rows="4" placeholder="Editar conteúdo"><?= $post['content']; ?></textarea>
                            <br>
                            <button type="submit" name="edit_post">Guardar Cambios</button>
                            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                            <button type="submit" name="delete_post" style="background-color: red;">Borrar Post</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Modal de Edição de Tags -->
        <div id="tagsModal" class="modal">
            <div class="modal-content-admin">
                <h2>Gestionar Etiquetas</h2>
                <?php foreach ($tags as $tag): ?><br>
                    <div class="tag">
                        <p><strong>Tag ID:</strong> <?= $tag['id']; ?></p>
                        <p><strong>Nome:</strong> <?= $tag['name']; ?></p>

                        <!-- Formulário para editar a tag -->
                        <form action="admin.php" method="POST" class="edit-form">
                            <input type="hidden" name="tag_id" value="<?= $tag['id']; ?>">
                            <input class="content" type="text" name="tag_name" value="<?= $tag['name']; ?>"
                                placeholder="Novo nome da tag" required>
                            <button type="submit" name="edit_tag" style="margin-top: 10px;">Guardar Cambios</button>
                        </form>
                    </div>
                <?php endforeach; ?><br>
            </div>
        </div>

        <!-- Navegação de Páginas -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <!-- Setas de navegação para a página anterior -->
                <a href="?page=1" class="page-link">&laquo;&laquo;</a>
                <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo;</a>
            <?php endif; ?>

            <?php
            // Exibe os links das páginas no intervalo determinado
            for ($i = $startPage; $i <= $endPage; $i++):
                if ($i == $page):
                    // A página atual recebe uma classe especial para destacá-la
                    echo "<a href='?page=$i' class='page-link active'>$i</a>";
                else:
                    echo "<a href='?page=$i' class='page-link'>$i</a>";
                endif;
            endfor;
            ?>

            <?php if ($page < $totalPages): ?>
                <!-- Setas de navegação para a próxima página -->
                <a href="?page=<?php echo $page + 1; ?>" class="page-link">&raquo;</a>
                <a href="?page=<?php echo $totalPages; ?>" class="page-link">&raquo;&raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Função para abrir a modal
        function openModal() {
            document.getElementById('tagsModal').style.display = 'flex';
        }

        // Função para fechar a modal
        function closeModal() {
            document.getElementById('tagsModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Reabilita rolagem na página
        }

        // Fechar a modal quando clicar fora dela
        window.onclick = function(event) {
            if (event.target === document.getElementById('tagsModal')) {
                closeModal();
            }
        };

        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.trim(); // Remover espaços extras

            if (query.length > 0) {
                // Criar requisição AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'search_posts.php?q=' + encodeURIComponent(query), true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Exibir os resultados da pesquisa
                        document.getElementById('search-results').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            } else {
                // Limpar os resultados caso o campo de pesquisa esteja vazio
                document.getElementById('search-results').innerHTML = '';
            }
        });


        // Seleciona todos os elementos com a classe '.post'
        const posts = document.querySelectorAll('.post');

        // Função de callback que será executada quando o post estiver visível na tela
        const handleIntersection = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Adiciona a classe 'visible' quando o post entra na área visível
                    entry.target.classList.add('visible');
                    // Para de observar o post após ele se tornar visível
                    observer.unobserve(entry.target);
                }
            });
        };

        // Cria o observador
        const observer = new IntersectionObserver(handleIntersection, {
            threshold: 0.2, // Quando 20% do post estiver visível, a animação será ativada
        });

        // Começa a observar todos os posts
        posts.forEach(post => observer.observe(post));
    </script>

    <?php include 'includes/footer.php'; ?>
    <?php include 'js/script.php'; ?>

</body>

</html>