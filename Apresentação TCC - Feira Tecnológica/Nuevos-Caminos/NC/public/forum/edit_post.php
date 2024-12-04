<?php
session_start();
include('db.php');

// Verifica se o usuário está logado e tem permissão para editar
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id']) && isset($_POST['content']) && isset($_POST['tag_id'])) {
    $post_id = $_GET['id'];
    $content = $_POST['content'];
    $tag_id = $_POST['tag_id']; // Captura o ID da tag selecionada

    // Lista de palavras restritas
    $base_restricted_words = [
        // Português
        'burro', 'idiota', 'estúpido', 'imbecil', 'otário', 'babaca', 'vagabundo', 'desgraçado', 'miserável',
        'merda', 'porra', 'caralho', 'puta', 'piranha', 'bosta', 'cuzão', 'arrombado', 'corno', 'chifrudo',
        'cretino', 'trouxa', 'mané', 'palhaço', 'besta', 'lesma', 'inútil', 'incompetente',
        'safado', 'canalha', 'vagabunda', 'malandro', 'bandido', 'ladrão',
        'viado', 'bixa', 'boiola', 'macaco', 'negro', 'feia', 'gorda', 'cu',

        // Espanhol
        'idiota', 'estúpido', 'imbécil', 'pendejo', 'cabron', 'gilipollas', 'coño', 'mierda', 'puta', 
        'zorra', 'perra', 'maldito', 'desgraciado', 'maricón', 'huevón', 'cabrón', 'tonto', 'bobo',
        'cretino', 'capullo', 'subnormal', 'basura', 'marica', 'negro', 'moreno', 'fea', 'gorda',

        // Inglês
        'idiot', 'stupid', 'dumb', 'moron', 'bastard', 'jerk', 'asshole', 'crap', 'shit', 'fuck', 'bitch', 
        'slut', 'whore', 'dick', 'prick', 'freak', 'scumbag', 'retard', 'wanker', 'loser', 'failure', 'fool',
        'dork', 'tool', 'faggot', 'queer', 'nigger', 'blackie', 'ugly', 'fat'
    ];

    // Função para gerar variações de gênero
    function generateGenderVariants($words) {
        $gendered_words = [];

        foreach ($words as $word) {
            // Adiciona a palavra original
            $gendered_words[] = $word;

            // Regras básicas para formar palavras no feminino ou masculino
            if (substr($word, -1) === 'o') { // Termina com 'o', cria a versão com 'a'
                $gendered_words[] = substr($word, 0, -1) . 'a';
            } elseif (substr($word, -1) === 'a') { // Termina com 'a', cria a versão com 'o'
                $gendered_words[] = substr($word, 0, -1) . 'o';
            } elseif (substr($word, -2) === 'ão') { // Termina com 'ão', cria a versão com 'ã' ou 'ões'
                $gendered_words[] = substr($word, 0, -2) . 'ã';
                $gendered_words[] = substr($word, 0, -2) . 'ões';
            }
        }

        return array_unique($gendered_words); // Remove duplicatas
    }

    // Gera a lista final com variações de gênero
    $restricted_words = generateGenderVariants($base_restricted_words);

    // Função para verificar palavras restritas, ignorando formatações
    function containsRestrictedWords($content, $restricted_words) {
        // Normalizar o conteúdo: remover espaços e caracteres especiais, e transformar em minúsculas
        $normalized_content = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $content));

        foreach ($restricted_words as $word) {
            // Normalizar a palavra proibida
            $normalized_word = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $word));
            if (strpos($normalized_content, $normalized_word) !== false) {
                return true;  // Encontrou uma palavra proibida
            }
        }
        return false;  // Nenhuma palavra proibida encontrada
    }

    // Verificar se o conteúdo do post contém palavras restritas
    if (containsRestrictedWords($content, $restricted_words)) {
        $_SESSION['restricted_message'] = "Tu publicación contiene palabras restringidas y no puede ser enviada.";
        // Redirecionar de volta para a página anterior (HTTP_REFERER)
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Verifica se o usuário é o criador do post
    $query = "SELECT user_id FROM posts WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        // Atualiza o conteúdo do post e a tag associada
        $updateQuery = "UPDATE posts SET content = ?, tag_id = ? WHERE id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$content, $tag_id, $post_id]);

        // Redireciona para o fórum após a edição
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Você não tem permissão para editar este post.";
    }
}
?>
