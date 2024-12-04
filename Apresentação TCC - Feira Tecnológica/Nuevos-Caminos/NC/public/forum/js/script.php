<script>
// Abre a modal para editar post
const editModal = document.getElementById('edit-modal');
const closeEditModal = document.getElementsByClassName('close')[0];
const editModalTitle = document.getElementById('edit-modal-title');
const editModalContent = document.getElementById('edit-modal-content');
const editModalForm = document.getElementById('edit-modal-form');
const editModalAction = document.getElementById('edit-modal-action');

// Abre a modal para excluir post
const deleteModal = document.getElementById('delete-modal');
const closeDeleteModal = document.getElementsByClassName('close')[1];
const deleteModalForm = document.getElementById('delete-modal-form');
const deleteModalAction = document.getElementById('delete-modal-action');

// Ação dos botões de Editar e Excluir
const openModalButtons = document.querySelectorAll('.open-modal');
openModalButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const type = button.getAttribute('data-type');
        const id = button.getAttribute('data-id');

        if (type === 'post') {
            // Editar post
            editModalTitle.innerText = 'Editar Post';

            // Carregar dados do post para editar
            fetch(`get_post_content.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    editModalContent.value = data.content;
                })
                .catch(error => console.log('Erro ao carregar conteúdo do post:', error));

            editModalForm.action = `edit_post.php?id=${id}`;
            editModalAction.innerText = 'Guardar Cambios';

            editModal.style.display = 'block';
        } else if (type === 'edit_reply') {
            // Editar resposta
            editModalTitle.innerText = 'Editar Resposta';

            // Carregar dados da resposta para editar
            fetch(`get_reply_content.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    editModalContent.value = data.content;
                })
                .catch(error => console.log('Erro ao carregar conteúdo da resposta:', error));

            editModalForm.action = `edit_reply.php?id=${id}`;
            editModalAction.innerText = 'Guardar Cambios';

            editModal.style.display = 'block';
        } else if (type === 'delete_post') {
            // Excluir post
            deleteModalForm.action = `delete_post.php?id=${id}`;
            deleteModal.style.display = 'block';
        } else if (type === 'delete_reply') {
            // Excluir resposta
            deleteModalForm.action = `delete_reply.php?id=${id}`;
            deleteModal.style.display = 'block';
        }
    });
});

// Fechar modais
closeEditModal.addEventListener('click', () => {
    editModal.style.display = 'none';
});

closeDeleteModal.addEventListener('click', () => {
    deleteModal.style.display = 'none';
});

// Fechar a modal se clicar fora dela
window.addEventListener('click', (event) => {
    if (event.target === editModal || event.target === deleteModal) {
        editModal.style.display = 'none';
        deleteModal.style.display = 'none';
    }
});

// Escuta os eventos de input no campo de pesquisa
document.getElementById('search-input').addEventListener('input', function () {
    const query = this.value;

    // Verifica se o campo de pesquisa não está vazio
    if (query.length > 0) {
        // Cria uma nova requisição AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'search_posts.php?q=' + encodeURIComponent(query), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Atualiza o conteúdo com os resultados da pesquisa
                document.getElementById('search-results').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        // Se o campo de pesquisa estiver vazio, limpa os resultados
        document.getElementById('search-results').innerHTML = '';
    }
});

// Delegação de eventos para lidar com cliques nos cards
document.getElementById('search-results').addEventListener('click', function (event) {
    const clickedElement = event.target.closest('.search-card a'); // Verifica se um link foi clicado

    if (clickedElement) {
        event.preventDefault(); // Evita o comportamento padrão do link
        const url = clickedElement.href; // Obtém o link do card
        window.location.href = url; // Redireciona para o link
    }
});


window.onbeforeunload = function () {
    sessionStorage.setItem("scrollPosition", window.scrollY);
};

// Restaurar a posição de rolagem após o carregamento da página
window.onload = function () {
    const savedPosition = sessionStorage.getItem("scrollPosition");
    if (savedPosition) {
        window.scrollTo(0, savedPosition); // Volta para a posição salva
        sessionStorage.removeItem("scrollPosition"); // Limpa a posição salva após uso
    }
};

// Quando a página carregar, verifique se a mensagem de erro existe
window.onload = function () {
    const message = document.getElementById('message');

    if (message) {
        // Exibe a mensagem
        message.style.display = 'block';

        // Após 4 segundos, oculta a mensagem suavemente
        setTimeout(function () {
            message.style.opacity = '0'; // Torna a mensagem invisível
            // Espera o tempo da transição para esconder completamente
            setTimeout(function () {
                message.style.display = 'none'; // Oculta a mensagem após a transição
            }, 500); // Tempo de transição (500ms)
        }, 4000); // A mensagem será ocultada após 4 segundos
    }
}

document.querySelectorAll('.clickable-post').forEach(function (postTitle) {
    postTitle.addEventListener('click', function (e) {
        const postId = e.target.getAttribute('data-id');
        const postDetailsContainer = document.getElementById('post-details');

        // Verifica se o post que foi clicado é o mesmo que está aberto
        if (postDetailsContainer.getAttribute('data-post-id') === postId) {
            postDetailsContainer.innerHTML = '';
            postDetailsContainer.removeAttribute('data-post-id');
        } else {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_post_content.php?id=' + postId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    postDetailsContainer.innerHTML = xhr.responseText;
                    postDetailsContainer.setAttribute('data-post-id', postId); 
                }
            };
            xhr.send();
        }
    });
});
const openOffcanvasBtn = document.getElementById('openOffcanvasBtn');
const offcanvas = new bootstrap.Offcanvas(document.getElementById('userOffcanvas'));

// Abrir o Offcanvas quando o botão de "Modificar" for clicado
openOffcanvasBtn.addEventListener('click', function (e) {
    e.preventDefault(); // Impede a navegação padrão do link
    offcanvas.show(); // Mostra o Offcanvas
});

const logout = document.getElementById('outID');

// Lógica para fazer logout
logout.addEventListener('click', function (e) {
    e.preventDefault(); // Impede o comportamento padrão de navegação do link

    fetch('logout.php', {
        method: 'GET',
        credentials: 'same-origin' // Certifique-se de enviar cookies de sessão, se necessário
    }).then(response => {
        if (response.ok) {
            window.location.href = 'login.php'; // Redireciona para a página de login após o logout
        } else {
            alert('Erro ao tentar fazer logout.');
        }
    }).catch(error => {
        console.error('Erro:', error);
    });

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