@extends('master')

@section('content')
  <section id="hero">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
          <div>
            <h2>Bienvenidos al portal de información del</h2>
            <h1>Concejo Municipal de Trinidad</h1>
            <h2>Órgano Municipal deliberante, legislador y fiscalizador de la gestión municipal</h2>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
          <img src="https://cmt.gob.bo//storage/landingpage/BannerPrincipal.jpeg" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section>

  <main id="main">
    <section id="about" class="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6" data-aos="zoom-in">
            <img src="https://cmt.gob.bo//storage/landingpage/backgroup.jpg" class="img-fluid" alt="">
            <p class="fst-italic" style="text-align: justify">
              Motivado por el deseo de expresar gratitud  a los estimados seguidores de este portal Web, como Presidente del Concejo Municipal de Trinidad gestión 2021-2022,  quiero hacerles llegar mis más sinceros agradecimientos.
            </p>
          </div>
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content pt-4 pt-lg-0">
              <h3>Bienvenida</h3>
              <p style="text-align: justify">
                Destacar que esta página está diseñada para que ustedes como ciudadanos conozcan de primera fuente, todo el accionar del Concejo Municipal de  Trinidad, en cuanto al  desarrollo legislativo de normas municipales como  Leyes y Resoluciones, así como actividades de fiscalización realizadas como Órgano  Legislativo Municipal.</p>
                <p style="text-align: justify">
                  Nuestro objetivo es ser transparentes en el manejo técnico administrativo institucional a través  de la comunicación fluida  con cada uno de  ustedes y con nuestro pueblo. Indicarles que es de mucha importancia, que los vecinos, la dirigencia vecinal y los sectores sociales utilicen esta herramienta tecnológica de consulta que les permite realizar un  seguimiento directo de las actividades legislativas; y a su vez nos puedan enviar sus sugerencias.
                </p>
                <p>Muchas gracias y que Dios nos bendiga a todos.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="cta" class="cta">
      <div class="container">
        <div class="row" data-aos="zoom-in">
          <div class="text-center text-lg-start">
            <h3>Misión</h3>
            <p>Contribuir a la satisfacción de las necesidades Colectivas y Garantizar la integración y participación de los ciudadanos en la planificación y el desarrollo económico productivo, humano cultural, recursos naturales, medio ambiente y organizativo institucional sostenible del municipio de la Ciudad de la Santísima Trinidad.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="cta2" class="cta">
      <div class="container">
        <div class="row" data-aos="zoom-in">
          <div class="text-center text-lg-start">
            <h3>Visión</h3>
            <p>El Municipio adaptado a la dinámica de los ecosistemas e integrado territorial y socialmente, competitivo y atractivo para las inversiones y emprendedor en actividades productivas ambientalmente sostenibles, que revaloriza su identidad cultural y recupera sus tecnologías ancestrales, en un marco de gestión pública transparente, eficiente y participativa.</p>
          </div>
        </div>
      </div>
    </section>


    <section id="contact" class="contact section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Contactanos</h2>
        </div>

        <div class="row">

          <div class="col-lg-6 d-flex align-items-stretch" data-aos="fade-right">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Direccion:</h4>
                <p>Av. 6 de Agosto #80, ex Hotel Camapanario</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@cmt.gob.bo</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telefonos:</h4>
                <p>Presidencia (03)462770
                <br>Secretaria (03)4622812
                <br>Whatsapp +591 72632128</p>
              </div>

              {{-- <iframe src="https://www.google.com.bo/maps/place/Hotel+Campanario+Trinidad/@-14.8357067,-64.9065895,18z/data=!4m8!3m7!1s0x93dd6fd58a49d12f:0xf78237184d966cfb!5m2!4m1!1i2!8m2!3d-14.8354686!4d-64.9058211?hl=es" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe> --}}
              {{-- <div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=trinidad%20beni&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-a.com"></a><br><style>.mapouter{position:relative;text-align:right;height:300px;width:100%;}</style><a href="https://www.embedgooglemap.net">embed map in gmail</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:100%;}</style></div></div> --}}
            </div>

          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-left">
            <form role="form" class="php-email-form">
              <div class="row">
                <div class="form-group">
                  <label for="name">Tu Nombre Completo</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                  <label for="name">Tu Numero Whatsapp</label>
                  <input type="number" class="form-control" name="number" id="number" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Asunto</label>
                <input type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <label for="name">Mensajes</label>
                <textarea class="form-control" name="message" rows="10" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                {{-- <div class="error-message"></div> --}}
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center">
                <button type="submit">Enviar Mensaje</button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </section>
  </main>
@endsection