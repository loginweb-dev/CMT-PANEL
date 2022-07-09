<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ setting('site.title') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://panel.cmt.gob.bo//storage/189554289_5435081946561694_8001421338486302867_n.jpg" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  
  <style>
    /* html, body {
    background: #efefef;
    height:100%;
    } */
    #center-text {
    display: flex;
    flex: 1;
    flex-direction:column;
    justify-content: center;
    align-items: center;
    height:100%;

    }
    #chat-circle {
    position: fixed;
    bottom: 75px;
    right: 10px;
    background: #2F8F4C;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: white;
    padding: 14px;
    cursor: pointer;
    box-shadow: 0px 3px 16px 0px #2F8F4C, 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    }

    .btn#my-btn {
        background: white;
        padding-top: 13px;
        padding-bottom: 12px;
        border-radius: 45px;
        padding-right: 40px;
        padding-left: 40px;
        color: #5865C3;
    }
    #chat-overlay {
        background: #2F8F4C;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: none;
    }


    .chat-box {
    display:none;
    background: #efefef;
    position:fixed;
    right:30px;
    bottom:75px;
    width:350px;
    max-width: 85vw;
    max-height:100vh;
    border-radius:5px;
    /*   box-shadow: 0px 5px 35px 9px #464a92; */
    box-shadow: 0px 5px 35px 9px #ccc;
    }
    .chat-box-toggle {
    float:right;
    margin-right:15px;
    cursor:pointer;
    }
    .chat-box-header {
    background: #2B333A;
    height:50px;
    border-top-left-radius:5px;
    border-top-right-radius:5px;
    color:white;
    text-align:center;
    font-size:25px;
    padding-top:10px;
    }
    .chat-box-body {
    position: relative;
    height:370px;
    height:auto;
    border:1px solid #ccc;
    overflow: hidden;
    }
    .chat-box-body:after {
    content: "";
    background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
    opacity: 0.1;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    height:100%;
    position: absolute;
    z-index: -1;
    }
    #chat-input {
    background: #f4f7f9;
    width:100%;
    position:relative;
    height:47px;
    padding-top:10px;
    padding-right:50px;
    padding-bottom:10px;
    padding-left:15px;
    border:none;
    resize:none;
    outline:none;
    border:1px solid #ccc;
    color:#888;
    border-top:none;
    border-bottom-right-radius:5px;
    border-bottom-left-radius:5px;
    overflow:hidden;
    }
    .chat-input > form {
        margin-bottom: 0;
    }
    #chat-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #ccc;
    }
    #chat-input::-moz-placeholder { /* Firefox 19+ */
    color: #ccc;
    }
    #chat-input:-ms-input-placeholder { /* IE 10+ */
    color: #ccc;
    }
    #chat-input:-moz-placeholder { /* Firefox 18- */
    color: #ccc;
    }
    .chat-submit {
    position:absolute;
    bottom:3px;
    right:10px;
    background: transparent;
    box-shadow:none;
    border:none;
    border-radius:50%;
    color:#2C343C;
    width:35px;
    height:35px;
    }
    .chat-logs {
    padding:15px;
    height:370px;
    overflow-y:scroll;
    }

    .chat-logs::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
    }

    .chat-logs::-webkit-scrollbar
    {
        width: 5px;
        background-color: #F5F5F5;
    }

    .chat-logs::-webkit-scrollbar-thumb
    {
        background-color: #2C343C;
    }



    @media only screen and (max-width: 500px) {
    .chat-logs {
            height:40vh;
        }
    }

    .chat-msg.user > .msg-avatar img {
    width:45px;
    height:45px;
    border-radius:50%;
    float:left;
    width:15%;
    }
    .chat-msg.self > .msg-avatar img {
    width:45px;
    height:45px;
    border-radius:50%;
    float:right;
    width:15%;
    }
    .cm-msg-text {
    background:white;
    padding:10px 15px 10px 15px;
    color:#666;
    max-width:75%;
    float:left;
    margin-left:10px;
    position:relative;
    margin-bottom:20px;
    border-radius:30px;
    }
    .chat-msg {
    clear:both;
    }
    .chat-msg.self > .cm-msg-text {
    float:right;
    margin-right:10px;
    background: #2C343C;
    color:white;
    }
    .cm-msg-button>ul>li {
    list-style:none;
    float:left;
    width:50%;
    }
    .cm-msg-button {
        clear: both;
        margin-bottom: 70px;
    }


    /* micss */
    .btn-boton {
      background-color: #398D4F; /* Green */
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 12px;
      border-radius: 12px;
    }
</style>
</head>

<body>
	
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <a href="/"><img src="https://panel.cmt.gob.bo//storage/navbar.jpg" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li class="dropdown"><a href="#"><span>Mi Concejo</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a class="nav-link scrollto" href="/resena-historica">Reseña Historica</a></li>
              <li><a class="nav-link scrollto" href="/estructura-del-concejo">Estructura del Consejo</a></li>
              <li><a class="nav-link scrollto" href="/reglamento-general">Reglamento General</a></li>              
              <li><a class="nav-link scrollto" href="https://mail.zoho.com/zm">Correo Institucional</a></li>
              <li><a class="nav-link scrollto" href="/admin">Gestion Documental</a></li>
              <li><a class="nav-link scrollto" href="/teletrabajo">Sesion en Vivo</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="/biblioteca-legislativa">Gaceta Oficial</a></li>
          <li><a class="nav-link scrollto " href="/convocatorias-publicas">Convocatorias</a></li>
          <li><a class="nav-link scrollto" href="/publicaciones-oficiales">Noticias</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

      <div class="header-social-links d-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>

    </div>
  </header>

  @yield('content')

  <div id="chat-circle" class="btn btn-raised">
    <div id="chat-overlay"></div><i class="bi bi-whatsapp"></i>
  </div>
  <div class="chat-box">
      <div class="chat-box-header">
          CHATBOT
          <span class="chat-box-toggle">x</span>
      </div>
      <div class="chat-box-body">
          <div class="chat-box-overlay">
      </div>
          <div class="chat-logs"></div><!--chat-log -->
      </div>
      <div class="chat-input">
          <form>
              <input type="text" id="chat-input" placeholder="Enviar un mensaje..."/>
              <button type="submit" class="chat-submit" id="chat-submit"><i class="bx bx-send"></i></button>
          </form>
      </div>
  </div>
  <footer id="footer">
    <div class="container">
      <div class="credits">
        Powrer by <a href="#">LoginWeb @2022</a>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
  
  @yield('javascript')

  <script>
        $(function() {
        var INDEX = 0;
        $("#chat-submit").click( async function(e) {
            e.preventDefault();
            var msg = $("#chat-input").val();
            if(msg.trim() == ''){
                return false;
            }
            // generate_message(msg, 'self');
            // var buttons = [
            //     {
            //     name: 'Existing User',
            //     value: 'existing'
            //     },
            //     {
            //     name: 'New User',
            //     value: 'new'
            //     }
            // ];
            // setTimeout(function() {
            //     generate_message(msg, 'user');
            //     // generate_button_message(msg, buttons)
            // }, 1000)
            var phone = '59171130523@c.us'
            //toastr.success('Mensaje enviado a: '+phone)
            // await axios.post("{{ setting('admin.url') }}api/chatbot/save/out", midata)
            var datapost = {
                phone: phone,
                type: 'text',
                message: msg
            }
            await axios.post("https://chatbot.loginweb.dev/chat", datapost)
            $("#chat-input").val('');
        })

        function generate_message(msg, type) {
            INDEX++;
            var str="";
            str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg "+type+"\">";
            str += "          <span class=\"msg-avatar\">";
            str += "            <img src=\"https://pos.loginweb.dev//storage/chatbots/cliente_avatar.png\">";
            str += "          <\/span>";
            str += "          <div class=\"cm-msg-text\">";
            str += msg;
            str += "          <\/div>";
            str += "        <\/div>";
            $(".chat-logs").append(str);
            $("#cm-msg-"+INDEX).hide().fadeIn(300);
            if(type == 'self'){
                $("#chat-input").val('');
            }
            $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
        }

        function generate_button_message(msg, buttons){
            /* Buttons should be object array
            [
                {
                name: 'Existing User',
                value: 'existing'
                },
                {
                name: 'New User',
                value: 'new'
                }
            ]
            */
            INDEX++;
            var btn_obj = buttons.map(function(button) {
            return  "<li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\""+button.value+"\">"+button.name+"<\/a><\/li>";
            }).join('');
            var str="";
            str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg user\">";
            str += "          <span class=\"msg-avatar\">";
            str += "            <img src=\"https://pos.loginweb.dev//storage/chatbots/cliente_avatar.png\">";
            str += "          <\/span>";
            str += "          <div class=\"cm-msg-text\">";
            str += msg;
            str += "          <\/div>";
            str += "          <div class=\"cm-msg-button\">";
            str += "            <ul>";
            str += btn_obj;
            str += "            <\/ul>";
            str += "          <\/div>";
            str += "        <\/div>";
            $(".chat-logs").append(str);
            $("#cm-msg-"+INDEX).hide().fadeIn(300);
            $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
            $("#chat-input").attr("disabled", true);
        }

        $(document).delegate(".chat-btn", "click", function() {
            var value = $(this).attr("chat-value");
            var name = $(this).html();
            $("#chat-input").attr("disabled", false);
            generate_message(name, 'self');
        })

        $("#chat-circle").click(function() {
            console.log('abrir chat')
            // var buttons = [
            //     {
            //     name: 'Existing User',
            //     value: 'existing'
            //     },
            //     {
            //     name: 'New User',
            //     value: 'new'
            //     }
            // ];
            // var btn_obj = buttons.map(function(button) {
            // return  "<li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\""+button.value+"\">"+button.name+"<\/a><\/li>";
            // }).join('');
            // var str="";
            // str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg user\">";
            // str += "          <span class=\"msg-avatar\">";
            // str += "            <img src=\"https://pos.loginweb.dev//storage/chatbots/cliente_avatar.png\">";
            // str += "          <\/span>";
            // str += "          <div class=\"cm-msg-text\">";
            // str += 'msg';
            // str += "          <\/div>";
            // str += "          <div class=\"cm-msg-button\">";
            // str += "            <ul>";
            // str += btn_obj;
            // str += "            <\/ul>";
            // str += "          <\/div>";
            // str += "        <\/div>";
            // $(".chat-logs").append(str);
            $("#chat-circle").toggle('scale');
            $(".chat-box").toggle('scale');
        })

        $(".chat-box-toggle").click(function() {
            $("#chat-circle").toggle('scale');
            $(".chat-box").toggle('scale');
        })
    })
  </script>
</body>

</html>