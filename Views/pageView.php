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

    <div id="content-area" class="container-fluid text-justify d-flex flex-wrap justify-content-center mb-5"> </div>

    <script>
        fetchPageView()

        function fetchPageView() {

            $("#content-area").empty();

            let url = "/api/pageView";

            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {

                    let res = JSON.parse(data);
                    console.log(res)
                    renderPageView(res);

                },
                error: function () {
                    alert("Erro ao carregar os dados.");
                }
            });

        }

        async function renderPageView(data) {
            $("#content-area").empty();

            if (data.success && Array.isArray(data.message)) {

             
                data.message.forEach(item => {
                    const link = document.createElement("a");
                    link.classList.add("m-2", "col-12", "col-sm-5", "col-md-2", "rounded", "d-flex", "flex-column", "align-items-center", "justify-content-center", "text-center", "p-2", "btn", "btn-outline-warning", "text-decoration-none");
                    link.href = '/L5_Networks' + item.rota;
                    link.innerHTML = `
                        <h3>${item.titulo}</h3>
                        <p>View quantity: ${item.quantidade}</p>

                    `;

                    $("#content-area").append(link);
                });
            } else {
                console.error("Erro ao carregar os dados ou os dados estão vazios.");
            }
        }

        function goBack() {
            window.history.back();
        }

    </script>




</body>

</html>