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

    .card-img {

      height: 400px;
      object-fit: contain;
      object-position: center;
      background-color: none;
    }

    #form-container {
      max-width: 400px;
      margin: 50px auto;
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


  <div class="container-fluid mt-4 mb-4 py-2">
    <div class="d-flex flex-wrap justify-content-center">
      <div id="menuFilms" class="menu-item" onclick="fetchData('films')">Films</div>
      <div id="menuPeople" class="menu-item" onclick="fetchData('people')">People</div>
      <div id="menuPlanets" class="menu-item" onclick="fetchData('planets')">Planets</div>
      <div id="menuSpecies" class="menu-item" onclick="fetchData('species')">Species</div>
      <div id="menuVehicles" class="menu-item" onclick="fetchData('vehicles')">Vehicles</div>
      <div id="menuStarships" class="menu-item" onclick="fetchData('starships')">Starships</div>
      <div id="menuMore" class="menu-item" onclick="fetchData('more')">More</div>
    </div>
  </div>


  <div id="content-area" class="container-fluid d-flex flex-wrap justify-content-center"></div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>

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

    $(document).ready(function () {

      $("#login-btn").on("click", function () {
        $("#login-form").removeClass("d-none");
        $("#register-form").addClass("d-none");
        $(this).addClass("btn-warning").removeClass("btn-outline-warning");
        $("#register-btn").addClass("btn-outline-warning").removeClass("btn-warning");
      });

      $("#register-btn").on("click", function () {
        $("#register-form").removeClass("d-none");
        $("#login-form").addClass("d-none");
        $(this).addClass("btn-warning").removeClass("btn-outline-warning");
        $("#login-btn").addClass("btn-outline-warning").removeClass("btn-warning");
      });

      $(document).on("submit", "#login-form", function (e) {
        e.preventDefault();

        const loginData = {
          email: $("#login-email").val().trim(),
          senha: $("#login-password").val().trim(),
        };

        if (!loginData.email || !loginData.senha) {
          alert("Por favor, preencha todos os campos de login.");
          return;
        }

        sendAjaxRequest("/api/user/auth", "POST", loginData)
          .done(function (response) {

            alert("Login successfully!");

            const user = response.result;
            document.cookie = `id=${user.id}; path=/;`;
            document.cookie = `nome=${encodeURIComponent(user.nome)}; path=/;`;
            document.cookie = `email=${encodeURIComponent(user.email)}; path=/;`;
            document.cookie = `nivel=${encodeURIComponent(user.nivel)}; pat=/`;
            renderMore();

          })
          .fail(function (jqXHR) {
            let errorMessage = "Erro desconhecido.";

            const parsedError = JSON.parse(jqXHR.responseText);
            errorMessage = parsedError.message || parsedError.error;

            console.error("Erro no login:", errorMessage);
            alert("Erro ao fazer login: " + errorMessage);
          });

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
      });

      $(document).on("submit", "#register-form", function (e) {
        e.preventDefault();

        const registerData = {
          nome: $("#register-name").val().trim(),
          email: $("#register-email").val().trim(),
          senha: $("#register-password").val().trim(),
        };

        if (!registerData.nome || !registerData.email || !registerData.senha) {
          alert("Por favor, preencha todos os campos de cadastro.");
          return;
        }

        sendAjaxRequest("/api/user/create", "POST", registerData)
          .done(function (response) {
            console.log(response);
            alert("Successful registration! log in now!");
            window.location.reload();
          })
          .fail(function (jqXHR) {
            let errorMessage = "Erro desconhecido.";

            const parsedError = JSON.parse(jqXHR.responseText);
            errorMessage = parsedError.message || parsedError.error;

            console.error("Erro no login:", errorMessage);
            alert("Erro ao fazer Cadastro: " + errorMessage);
          });
      });
    });


    let sessionMenu = sessionStorage.getItem("menu");
    let isLoading = false; fetchData
    if (!sessionMenu || sessionMenu.trim() === "") {

      sessionStorage.setItem("menu", "films");
      fetchData("films")
    } else {
      fetchData(sessionMenu)
    }


    function fetchData(menu) {
      if (isLoading) return; 
      isLoading = true;

      sessionStorage.setItem("menu", menu);

      $("#content-area").empty();
      $('.menu-item').removeClass("menuSelecionado");
      $(`#menu${menu.charAt(0).toUpperCase()}${menu.slice(1)}`).addClass("menuSelecionado");

      if (menu !== 'more') {
        $('#inputSearch').show();

        const url = `/api/${menu}`;
        $.ajax({
          url: url,
          method: "GET",
          success: function (data) {
          
            try {
              const res = JSON.parse(data);

              switch (menu) {
                case 'films':
                  renderFilms(res);
                  break;
                default:
                  renderOthers(res, menu);
                  break;
              }
            } catch (error) {
              console.error("Erro ao processar os dados:", error);
              alert("Erro ao processar os dados recebidos.");

 
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert("Erro ao carregar os dados.");
 
            const parsedError = JSON.parse(jqXHR.responseText);
            errorMessage = parsedError.message || parsedError.error;

            const link = document.createElement("p");
            link.classList.add("m-2", "col-12", "rounded", "d-flex", "flex-column", "align-items-center", "justify-content-center", "text-center", "p-2", "text-decoration-none", "text-warning");
            link.innerHTML = `
                        <h3>${errorMessage}</h3>   `;

            $("#content-area").append(link);

          },
          complete: function () {
            isLoading = false; 
          }
        });
      } else {
        $('#inputSearch').hide();
        renderMore();
        isLoading = false; 
      }
    }

    function renderFilms(data) {
   
      let input = `
    <div class="col-12 mb-5">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" id="inputSearchFilms" aria-label="Search"
          aria-describedby="btnSearch">
      </div>
    </div>
  `;

   
      $("#content-area").append(input);

    
      data.forEach(item => {
        const card = `
      <div class="col-3 col-md-4 col-sm-6 col-12 p-1 card-item">
        <div class="card shadow-sm border-warning bg-black text-light h-100">
          <h5 class="card-header bg-dark text-white text-center">
            ${item.description}: Episode ${item.episode_id} - ${item.title}
          </h5>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-center">
              <strong>Release Date:</strong> ${item.release_date} <strong>Age:</strong> ${item.age['years']} years
            </p>
            <div class="text-center mb-3">
              <img 
                src="/public/img/${item.img}.jpg" 
                alt="Image of ${item.title}" 
                class="img-fluid rounded card-img" 
                onerror="this.src='/public/img/placeholder.jpg'" />
            </div>
          </div>
          <div class="card-footer text-center">
            <a href="/films?${item.id}" class="btn btn-warning btn-sm">More Info</a>
          </div>
        </div>
      </div>
    `;
        $("#content-area").append(card);
      });

      $("#inputSearchFilms").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();

        $(".card-item").each(function () {
          const cardText = $(this).find(".card-header").text().toLowerCase() +
            $(this).find(".card-body").text().toLowerCase(); 
          const cardContainer = $(this);

        
          if (cardText.includes(searchTerm)) {
            cardContainer.show();
          } else {
            cardContainer.hide();
          }
        });
      });
    }

    function renderOthers(data, menu) {
     
      let input = `
    <div class="col-12 mb-5">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" id="inputSearchOthers" aria-label="Search"
          aria-describedby="btnSearch">
      </div>
    </div>
  `;

 
      $("#content-area").append(input);

      let card = `<div class="col-12 shadow-sm justify-content-start row mb-4 mr-3 ml-3 ">`;

      data.forEach(item => {
        card += `
      <span class='col-12 col-sm-6 col-md-3'>
        <a class="btn btn-outline-warning btn-lg w-100 m-1" href="/${menu}?${item.uid}" target="_self">${item.name}</a>
      </span>
    `;
      });

      card += `</div>`;

      $("#content-area").append(card);


      $("#inputSearchOthers").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();

      
        $(".btn").each(function () {
          const buttonText = $(this).text().toLowerCase();
          const buttonContainer = $(this).closest(".col-12, .col-sm-6, .col-md-3");

        
          if (buttonText.includes(searchTerm)) {
            buttonContainer.show();
          } else {
            buttonContainer.hide();
          }
        });
      });
    }

    function deleteCookies() {

      const cookies = document.cookie.split("; ");

      cookies.forEach((cookie) => {
        const [key] = cookie.split("=");
        document.cookie = `${key}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
      });

      window.location.reload();

    }

    function renderMore() {

      const cookies = document.cookie.split("; ");

      const getCookieValue = (key) => {
        const cookie = cookies.find((row) => row.startsWith(`${key}=`));
        return cookie ? cookie.split("=")[1] : null;
      };

      const id = getCookieValue("id");
      const nome = getCookieValue("nome");
      const email = getCookieValue("email");
      const nivel = getCookieValue("nivel");

      const isLoggedIn = id && nome && email && nivel;

      let html = '';

      if (isLoggedIn) {

        html = `
            <div class="col-12 p-1 row justify-content-between ">
                 
                    <a id="favorites-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/favorites">
                      <h3>Favorites</h3>
                      <p>Access your favorite items.</p>
                    </a>  
                
                    <a id="pageView-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/pageView">
                      <h3>Most viewed</h3>
                      <p>View item history with more viewing.</p> 
                    </a> 
                
                <!-- Avaliações
                    <a id="ratings-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/ratings">
                      <h3>Reviews</h3>
                      <p>Rate our content to improve your experience.</p> 
                    </a>  --> 
                
                    <a id="comments-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/comments">
                      <h3>Comments</h3>
                      <p>See the latest comments</p> 
                    </a> 

        `;

        if (nivel == 'A') {
          html += `
                    <a id="users-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/users">
                      <h3>Users</h3>
                      <p>List Users</p> 
                    </a> 

                    <a id="user-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/myuser">
                      <h3>My user</h3>
                      <p>Edit your data</p> 
                    </a> `;

        } else {
          html += `
                    <a id="user-section" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="/myuser">
                      <h3>My user</h3>
                      <p>Edit your data</p> 
                    </a> `;
        }

        html += `
                  <!-- sair do usuario --> 
                    <a onclick="deleteCookies()" id="log-out" class='m-2 col-12 col-sm-5 col-md-2 rounded d-flex flex-column align-items-center justify-content-center text-center p-2 btn btn-outline-warning text-decoration-none ' href="#">
                      <h3>Log Uut</h3>
                      <p>Do you want to log out the user?</p> 
                    </a> 
            </div>
        `;

        $("#content-area").empty().append(html);

      } else {

        html = `
            <div id="form-container" class="p-4 w-100 shadow rounded text-warning">
              <div class="text-left mb-3">
                  <button id="login-btn" class="btn btn-warning">Log In</button>
                  <button id="register-btn" class="btn btn-outline-warning">Register</button>
              </div>

              <!-- Formulário de Login -->
              <form autocomplete="off" id="login-form" class="text-left"> 
                  <div class="mb-3">
                      <label for="login-email" class="form-label">E-mail</label>
                      <input autocomplete="off" type="email" class="form-control" id="login-email" placeholder="Enter your e-mail" required>
                  </div>
                  <div class="mb-3">
                      <label for="login-password" class="form-label">Password</label>
                      <input autocomplete="off" type="password" class="form-control" id="login-password" placeholder="Enter your password" required>
                  </div>
                  <button type="submit" id="btnEntrar" class="btn btn-success w-100">Log In</button>
              </form>

              <!-- Formulário de Cadastro -->
              <form autocomplete="off" id="register-form" class="d-none">
                  <div class="mb-3">
                      <label for="register-name" class="form-label">Name</label>
                      <input autocomplete="off" type="text" class="form-control" id="register-name" placeholder="Enter your name" required>
                  </div>
                  <div class="mb-3">
                      <label for="register-email" class="form-label">E-mail</label>
                      <input autocomplete="off" type="email" class="form-control" id="register-email" placeholder="Enter your e-mail" required>
                  </div>
                  <div class="mb-3">
                      <label for="register-password" class="form-label">Password</label>
                      <input autocomplete="off" type="password" class="form-control" id="register-password" placeholder="Enter your password" required>
                  </div>
                  <button type="submit" id="btnCadastrar" class="btn btn-success w-100">Register</button>
              </form>
          </div>

        `;

        $("#content-area").empty().append(html);

        if (!isLoggedIn) {
          $("#login-btn").on("click", function () {
            $("#login-form").removeClass("d-none");
            $("#register-form").addClass("d-none");
            $(this).addClass("btn-warning").removeClass("btn-outline-warning");
            $("#register-btn").addClass("btn-outline-warning").removeClass("btn-warning");
          });

          $("#register-btn").on("click", function () {
            $("#register-form").removeClass("d-none");
            $("#login-form").addClass("d-none");
            $(this).addClass("btn-warning").removeClass("btn-outline-warning");
            $("#login-btn").addClass("btn-outline-warning").removeClass("btn-warning");
          });
        }

      }




    }

  </script>




</body>

</html>