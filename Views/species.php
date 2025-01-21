<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SW - Wiki</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #000;
            background-image: url('/public/img/fundoEstrelado.gif');
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            font-family: 'Arial', sans-serif;
        }

        .nav-link {
            color: #ffd700;
        }

        .nav-link:hover {
            color: #fff;
        }

        .menu-item {
            color: #ffd700;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .menuSelecionado,
        .menu-item:hover {
            background-color: #444;
            color: #fff;
        }

        iframe {
            height: 600px;
            border: none;
            background-color: #222;
        }

        .sidebar {
            background-color: #222;
            color: #fff;
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }

        span {
            color: #f0f0f0;

        }

        h1,
        h2,
        h4,
        li,
        .sidebar h3 {
            color: #ffd700;
        }

        .rating {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .rating input {
            width: 20px;
            height: 20px;
        }

        .chat-box {
            height: 300px;
            overflow-y: auto;
            background-color: #333;
            padding: 10px;
            margin-bottom: 10px;
            color: #fff;
        }

        .comment-input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        @media (max-width: 992px) {

            /* Tamanho para tablets e dispositivos menores */
            .menu-item {
                font-size: 14px;
                padding: 8px;
            }

            iframe {
                height: 500px;
            }

            .navbar .form-control {
                width: 70%;
            }

            .navbar .btn {
                font-size: 14px;
                padding: 5px 10px;
            }
        }

        @media (max-width: 768px) {

            /* Tamanho para celulares */
            .menu-item {
                font-size: 12px;
                padding: 6px;
            }

            iframe {
                height: 400px;
            }

            .navbar .form-control {
                width: 60%;
            }

            .navbar .btn {
                font-size: 12px;
                padding: 5px;
            }
        }

        @media (max-width: 576px) {

            /* Tamanho para celulares muito pequenos */
            .navbar {
                flex-wrap: wrap;
                text-align: center;
            }

            .navbar .form-control {
                width: 100%;
                margin-bottom: 10px;
            }

            .navbar .btn {
                width: 100%;
                margin-bottom: 5px;
            }

            .menu-item {
                font-size: 10px;
                padding: 5px;
            }

            iframe {
                height: 300px;
            }

            .sidebar {
                width: 100%;
                padding: 10px;
            }
        }
    </style>

    <script>

    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
        <div class="container-fluid ">

            <div class="row justify-content-start w-100 ">

                <a href="/" class="col-md-1 navbar-brand text-right">
                    <img src="/public/img/Star_Wars_Logo.svg" alt="Star Wars" width="120">
                </a>

                <div class="col-md-4 d-flex align-items-center">
                    <a href="https://www.facebook.com/StarWars/?locale=pt_BR" class="nav-link me-3">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <a href="https://x.com/starwars" class="nav-link me-3">
                        <i class="bi bi-twitter"></i> Twitter
                    </a>
                    <a href="https://www.instagram.com/starwars/" class="nav-link me-3">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <button class="btn btn-warning" onclick="goBack()">Back</button>
    </div>


    <!-- Área de conteúdo -->
    <div class="container-fluid text-justify d-flex flex-wrap justify-content-between mb-5">

        <div id="content-area" class="col-7">

        </div>

        <div class="sidebar col-4 border border-warning">

            <div class="rating">
                <h3>Favorite: </h3>
                <label for="rating" style="font-size: 24px; cursor: pointer;">
                    <i onclick="updateFavoriteStatus()" class="bi bi-heart" id="heart-icon"></i>
                </label>
            </div>

            <h3>Leave a comment</h3>
            <textarea class="comment-input" rows="4" placeholder="Write your comment here..."></textarea>

            <div class="chat-box" id="chat-box">
                <div class="message">

                </div>
            </div>

            <button class="btn btn-outline-warning w-100" onclick="addComment()">Send Comment</button>
        </div>

    </div>

    <!-- JavaScript -->
    <script>

        let titulo;
        let idFav;

        const url = window.location.href;

        const paramValue = url.split('?')[1];

        if (paramValue) {

            if (!isNaN(paramValue) && !isNaN(parseFloat(paramValue))) {

                fetchPeople(paramValue);
                checkLogin();

            } else {
                window.location.href = '/';
            }
        } else {
            window.location.href = '/';
        }

        function fetchPeople(id) {

            $("#content-area").empty();

            let url = "/api/species/" + id;

            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {

                    let res = JSON.parse(data);

                    renderStarships(res);

                },
                error: function () {
                    alert("Erro ao carregar os dados.");
                }
            });

        }

        async function fetchOuthers(type) {
            return new Promise((resolve, reject) => {
                const url = `/api/${type}`;

                $.ajax({
                    url: url,
                    method: "GET",
                    success: function (data) {
                        const typeValue = type.split('/')[0];

                        let res = JSON.parse(data);

                        let nome, link;
                        switch (typeValue) {
                            case "planets":
                                nome = res.properties.name;
                                link = `planets?${res.uid}`;
                                break;
                            case "people":
                                nome = res.properties.name;
                                link = `people?${res.uid}`;
                                break;
                        }

                        resolve({ nome, link });
                    },
                    error: function () {
                        reject("Erro ao carregar os dados.");
                    }
                });
            });
        }

        async function renderStarships(data) {
            $("#content-area").empty();


            const {
                classification = "",
                designation = "",
                average_height = "",
                average_lifespan = "",
                hair_colors = "",
                skin_colors = "",
                eye_colors = "",
                homeworld = "",
                language = "",
                people = [],
                name = ""
            } = data.properties;

            const description = data.description;

            const lastPartWorld = homeworld.split('/').slice(-2).join('/');
            const homeworldInfo = await fetchOuthers(lastPartWorld);

            const homeworldHtml = `
        <a class="text-warning" href="${homeworldInfo.link}" target="_self">${homeworldInfo.nome}</a>`;

            const peopleLinks = await Promise.all(
                people.map(async (e) => {

                    let lastPart = e.split('/').slice(-2).join('/');

                    const resPeoples = await fetchOuthers(lastPart);

                    return `
            <a href="${resPeoples.link}" target="_self" class="btn btn-warning btn-sm">${resPeoples.nome}</a>`;
                })
            );

            let pleopleHTML = peopleLinks.join(" ");

            if (pleopleHTML.trim() !== '') {

                pleopleHTML = `
                
                    <section class="pilots">
                            <h4>Characters</h4>
                            <p>
                               ${pleopleHTML}
                            </p>
                        </section>

                `;

            }

            titulo = name;

            const card = `
               <div class="card shadow-lg border-warning bg-black text-light">
                    <div class="card-header bg-dark text-warning text-center">
                        <h3>Species Name: <span>${name}</span></h3>
                    </div>
                    <div class="card-body">
                        <section class="details">
                            <h4>Species Information</h4>
                            <ul>
                                <li><strong>Classification:</strong> <span>${classification}</span></li>
                                <li><strong>Designation:</strong> <span>${designation}</span></li>
                                <li><strong>Average Height:</strong> <span>${average_height} cm</span></li>
                                <li><strong>Average Lifespan:</strong> <span>${average_lifespan} years</span></li>
                                <li><strong>Hair Colors:</strong> <span>${hair_colors}</span></li>
                                <li><strong>Skin Colors:</strong> <span>${skin_colors}</span></li>
                                <li><strong>Eye Colors:</strong> <span>${eye_colors}</span></li>
                                <li><strong>Homeworld:</strong> 
                                    ${homeworldHtml}
                                </li>
                                <li><strong>Language:</strong> <span>${language}</span></li>
                            </ul>
                        </section>

                        ${pleopleHTML}

                        <section class="description">
                            <h4>Description</h4>
                            <p>${description}</p>
                        </section>
                    </div>
                </div>

            `;

            $("#content-area").append(card);

            const urls = window.location.href;

            // Obtém o valor da URL
            const rota = urls.split('?')[1];

            const Data = {
                rota: '/species?' + rota,
                titulo: titulo
            };

            sendAjaxRequest("/api/pageView/create", "POST", Data)
                .done(function (response) {

                })
                .fail(function (jqXHR) {
                    let errorMessage = "Erro desconhecido.";

                    const parsedError = JSON.parse(jqXHR.responseText);
                    errorMessage = parsedError.message || parsedError.error;

                    console.error("Erro no login:", errorMessage);
                });

        }

        function sendAjaxRequest(url, method, data) {

            return $.ajax({
                url: url,
                method: method,
                data: JSON.stringify(data),
                contentType: "application/json",
                dataType: "json",
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Falha na requisição:");
                console.error("Status:", textStatus);
                console.error("Erro:", errorThrown);
                console.error("Resposta do servidor:", jqXHR.responseText);
                console.error("Erro no login:", textStatus, jqXHR.responseJSON);
            });
        }

        function checkLogin() {
            const cookies = document.cookie.split("; ");

            const getCookieValue = (key) => {
                const cookie = cookies.find((row) => row.startsWith(`${key}=`));
                return cookie ? cookie.split("=")[1] : null;
            };

            const id = getCookieValue("id");
            const nome = getCookieValue("nome");

            const isLoggedIn = id && nome;

            const commentDiv = document.querySelector('.sidebar');
            const heartIcon = document.getElementById('heart-icon');

            if (isLoggedIn) {

                if (commentDiv) {
                    commentDiv.style.display = 'block';
                }

                checkIfFavorited(id);
                loadChatMessages();
            } else {
                addComment
                if (commentDiv) {
                    commentDiv.style.display = 'none';
                }

                if (heartIcon) {
                    heartIcon.classList.remove('bi-heart-fill');
                    heartIcon.classList.add('bi-heart');
                }
            }
        }

        function checkIfFavorited(userId) {

            const requestBody = {
                user: userId,
                route: '/species?' + paramValue
            };

            $.ajax({
                url: '/api/favorites/favorite-status',
                method: 'POST',
                contentType: 'application/json',
                dataType: "json",
                data: JSON.stringify(requestBody),
                success: function (response) {
                    const isFavorited = response.success;

                    const heartIcon = document.getElementById('heart-icon');

                    if (isFavorited) {
                        idFav = response.results[0].id
                        heartIcon.classList.remove('bi-heart');
                        heartIcon.classList.add('bi-heart-fill');
                    } else {
                        heartIcon.classList.remove('bi-heart-fill');
                        heartIcon.classList.add('bi-heart');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(jqXHR.responseJSON);
                }
            });
        }

        function updateFavoriteStatus() {
            const heartIcon = document.getElementById('heart-icon');
            const isFavorited = heartIcon.classList.contains('bi-heart-fill');

            const cookies = document.cookie.split("; ");

            const getCookieValue = (key) => {
                const cookie = cookies.find((row) => row.startsWith(`${key}=`));
                return cookie ? cookie.split("=")[1] : null;
            };

            const id = getCookieValue("id");
            const nome = getCookieValue("nome");

            let requestBody;

            const method = isFavorited ? 'DELETE' : 'POST';
            let urlFav;

            if (method == 'POST') {
                urlFav = '/api/favorites/create';
                requestBody = {
                    user: id,
                    route: "/species?" + paramValue,
                    titulo: titulo
                };
            } else {
                urlFav = '/api/favorites/delete';
                requestBody = {
                    id: idFav,
                };
            }

            $.ajax({
                url: urlFav,
                method: method,
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(requestBody),
                success: function (response) {

                    if (method == 'POST') {
                        heartIcon.classList.remove('bi-heart');
                        heartIcon.classList.add('bi-heart-fill');

                        idFav = response.id;
                    } else {
                        heartIcon.classList.add('bi-heart');
                        heartIcon.classList.remove('bi-heart-fill');
                        idFav = null;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(jqXHR.responseJSON);
                }
            });
        }

        async function loadChatMessages() {

            let body = {
                route: '/species?' + paramValue
            }

            $.ajax({
                url: '/api/comments/chat',
                method: 'POST',
                contentType: 'application/json',
                dataType: "json",
                data: JSON.stringify(body),
                success: function (response) {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';

                    if (response.success && Array.isArray(response.message)) {
                        response.message.forEach(comment => {
                            const messageDiv = document.createElement('div');
                            messageDiv.classList.add('message');
                            messageDiv.innerHTML = `<strong>${comment.user_name}:</strong> ${comment.comentario}`;
                            chatBox.appendChild(messageDiv);
                        });
                    } else {
                        chatBox.innerHTML = '';
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(jqXHR.responseJSON);
                }
            });

        }

        function addComment() {
            const comment = document.querySelector('.comment-input').value;

            const heartIcon = document.getElementById('heart-icon');
            const isFavorited = heartIcon.classList.contains('bi-heart-fill');

            const cookies = document.cookie.split("; ");

            const getCookieValue = (key) => {
                const cookie = cookies.find((row) => row.startsWith(`${key}=`));
                return cookie ? cookie.split("=")[1] : null;
            };

            const idUser = getCookieValue("id");
            const nome = getCookieValue("nome");

            let body = {
                user: idUser,
                route: '/species?' + paramValue,
                comentario: comment,
                titulo: titulo
            };

            if (comment.trim() !== '') {
                $.ajax({
                    url: '/api/comments/create',
                    method: 'POST',
                    contentType: 'application/json',
                    dataType: "json",
                    data: JSON.stringify(body),
                    success: function (response) {

                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('message');
                        messageDiv.innerHTML = `<strong>${nome}:</strong> ${comment}`;

                        const chatBox = document.getElementById('chat-box');
                        if (chatBox.firstChild) {
                            chatBox.insertBefore(messageDiv, chatBox.firstChild);
                        } else {
                            chatBox.appendChild(messageDiv);
                        }


                        document.querySelector('.comment-input').value = '';
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Erro ao enviar comentário:', textStatus, errorThrown);
                    }
                });
            } else {
                alert('Por favor, escreva um comentário!');
            }
        }



        function goBack() {
            window.history.back();
        }

    </script>




</body>

</html>