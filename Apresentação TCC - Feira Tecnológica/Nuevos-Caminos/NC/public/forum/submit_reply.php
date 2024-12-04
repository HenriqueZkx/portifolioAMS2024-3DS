<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $postId = $_POST['post_id'];
    $userId = $_SESSION['user_id']; // Usando o ID do usuário logado
    $usernameId = $_SESSION['username'];

    // Lista de palavras restritas
    $restricted_words = [
        // Português
        'burro',
        'idiota',
        'estúpido',
        'imbecil',
        'otário',
        'babaca',
        'vagabundo',
        'desgraçado',
        'miserável',
        'merda',
        'porra',
        'caralho',
        'puta',
        'piranha',
        'bosta',
        'cuzão',
        'arrombado',
        'corno',
        'chifrudo',
        'cretino',
        'trouxa',
        'mané',
        'palhaço',
        'besta',
        'cretino',
        'lesma',
        'inútil',
        'incompetente',
        'safado',
        'canalha',
        'vagabunda',
        'vagabundo',
        'malandro',
        'malandra',
        'bandido',
        'ladrão',
        'viado',
        'bixa',
        'boiola',
        'macaco',
        'negro',
        'feia',
        'gorda',
        'cu',

        // Espanhol
        'idiota',
        'estúpido',
        'imbécil',
        'pendejo',
        'cabron',
        'gilipollas',
        'coño',
        'mierda',
        'puta',
        'zorra',
        'perra',
        'maldito',
        'desgraciado',
        'maricón',
        'huevón',
        'cabrón',
        'tonto',
        'bobo',
        'cretino',
        'capullo',
        'subnormal',
        'basura',
        'marica',
        'maricon',
        'negro',
        'moreno',
        'fea',
        'gorda',

        // Inglês
        'idiot',
        'stupid',
        'dumb',
        'moron',
        'bastard',
        'jerk',
        'asshole',
        'crap',
        'shit',
        'fuck',
        'bitch',
        'slut',
        'whore',
        'dick',
        'prick',
        'freak',
        'scumbag',
        'retard',
        'wanker',
        'loser',
        'failure',
        'fool',
        'dork',
        'tool',
        'faggot',
        'queer',
        'nigger',
        'blackie',
        'ugly',
        'fat'
    ];


    $base_restricted_words = [
        // Português
        'burro',
        'idiota',
        'estúpido',
        'imbecil',
        'otário',
        'babaca',
        'vagabundo',
        'desgraçado',
        'miserável',
        'merda',
        'porra',
        'caralho',
        'puta',
        'piranha',
        'bosta',
        'cuzão',
        'arrombado',
        'corno',
        'chifrudo',
        'cretino',
        'trouxa',
        'mané',
        'palhaço',
        'besta',
        'lesma',
        'inútil',
        'incompetente',
        'safado',
        'canalha',
        'vagabunda',
        'malandro',
        'bandido',
        'ladrão',
        'viado',
        'bixa',
        'boiola',
        'macaco',
        'negro',
        'feia',
        'gorda',
        'cu',

        // Espanhol
        'idiota',
        'estúpido',
        'imbécil',
        'pendejo',
        'cabron',
        'gilipollas',
        'coño',
        'mierda',
        'puta',
        'zorra',
        'perra',
        'maldito',
        'desgraciado',
        'maricón',
        'huevón',
        'cabrón',
        'tonto',
        'bobo',
        'cretino',
        'capullo',
        'subnormal',
        'basura',
        'marica',
        'negro',
        'moreno',
        'fea',
        'gorda',

        // Inglês (sem variações de gênero)
        'idiot',
        'stupid',
        'dumb',
        'moron',
        'bastard',
        'jerk',
        'asshole',
        'crap',
        'shit',
        'fuck',
        'bitch',
        'slut',
        'whore',
        'dick',
        'prick',
        'freak',
        'scumbag',
        'retard',
        'wanker',
        'loser',
        'failure',
        'fool',
        'dork',
        'tool',
        'faggot',
        'queer',
        'nigger',
        'blackie',
        'ugly',
        'fat'
    ];

    // Função para gerar variações de gênero
    function generateGenderVariants($words)
    {
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

    // Exibir a lista (para debug, remova em produção)
    print_r($restricted_words);

    // Função para verificar palavras restritas, ignorando formatações
    function containsRestrictedWords($content, $restricted_words)
    {
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

    // Verificar se o conteúdo da resposta contém palavras restritas
    if (containsRestrictedWords($content, $restricted_words)) {
        $_SESSION['restricted_message'] = "Tu respuesta contiene palabras restringidas y no puede ser enviada.";
        // Redirecionar de volta para o fórum com a mensagem de erro
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Inserir resposta no banco de dados se não houver palavras restritas
    $query = "INSERT INTO replies (post_id, user_id, username, content) VALUES (?, ?, ?, ?)";
    $_SESSION['sucess_message'] = "Tu respuesta fue enviada exitosamente.";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$postId, $userId, $usernameId, $content]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;

    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];

    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE username LIKE ?");
    $stmt->execute(['%' . $username . '%']);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($users);
}
