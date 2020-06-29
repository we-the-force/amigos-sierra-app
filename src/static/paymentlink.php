<template>
<div class="page" data-name="campana" data-campana="{{campana.nombre}}" data-campanaid="{{campana.id}}" id="campana">
  <div class="navbar">
    <div class="navbar-bg"></div>
    <div class="navbar-inner sliding">
      <div class="left">
        <a href="#" class="link back">
          <!-- <i class="icon icon-back"></i> -->
          <span class="material-icons">
            close
            </span>
          <!-- <span class="if-not-md">Back</span> -->
        </a>
      </div>
      <!-- <div class="title">{{campana.nombre}}</div> -->
    </div>
  </div>
  <div class="page-content">
    
    <div class="logo">
      <img src="/static/logo_white.svg" alt="">
    </div>
    <div class="title">{{campana.nombre}}</div>
    <div data-pagination='{"el": ".swiper-pagination"}' data-space-between="10" data-slides-per-view="1.5" data-centered-slides="true" class="swiper-container swiper-init ">
      <div class="swiper-wrapper">
        {{#each paquetes}}
        <div class="swiper-slide paquete">
          {{#if icono}}
          <img src="{{icono.data.full_url}}" alt="" class="icono">
          {{else}}
          <span class="material-icons icono">
            star
            </span>
          {{/if}}
          <div class="card ">

            <div class="card-content card-content-padding">
              <p class="descripcion">{{descripcion}}</p>
              <p class="nombre">{{nombre}}</p>
              <p class="precio donacion" data-donacion="{{cantidad}}">MXN ${{cantidad}}</p>
              
            </div>
          </div>



         
        </div>
        {{/each}}
        <div class="swiper-slide paquete">
          
          
          <span class="material-icons icono">
            star
            </span>
          
          <div class="card set-price">

            <div class="card-content card-content-padding">
              <p class="descripcion">¿Cuánto?</p>
              <p class="nombre">Tu decides</p>
              <p class="precio personalizado donacion" data-donacion="">MXN $<span class="custom-price">0</span>.00 <i class="f7-icons" >pencil</i></p>
            </div>
          </div>




        </div>
        
      </div>
    </div>
    <div class="row no-gap">
      <div class="col-20"></div>
      <div class="col-60">
        <a class="button button-raised  button-fill button-large link donar" data-force="true" data-ignore-cache="true" data-view=".view-main" href="">Donar</a>
        <!-- <a class="button button-raised  button-fill button-large link external donar" data-force="true" data-ignore-cache="true" data-view=".view-main" href="https://pay.conekta.com/link/b4cfa5543f104e3981f36246efea87ce">Donar</a> -->

      </div>
      
      <div class="col-20"></div>
    </div>
    <div class="footer">
      <img src="/static/footer.svg" alt="" width="100%" height="auto">
    </div>
  </div>
</div>

</template>
<script>
  import $$ from 'dom7';
export default {

 
  on: {
    pageMounted: function(e, page) {
      // const curl = new (require( 'curl-request' ))();
      var self = this;
      var app = self.$app;

  
      $$('.set-price').on('click', function () {
        app.dialog.prompt('','Ingresa la cantidad a donar:', function (price) {
          $$('.set-price .donacion').data('donacion',price);
          $$('.custom-price').html(price);
        

        });
      });

       

      

      $$('a.donar').on('click', function(e){
        e.preventDefault();
        app.dialog.preloader('Generando Link de pago...');
        var cantidadDonada = $$('.swiper-slide-active .donacion').data('donacion');
        var donacion = cantidadDonada*100;
        var campanaName = $$('.page').data('campana');
        var campanaId = $$('.page').data('campanaid');
        var today = new Date();
        today.setHours(0,0,0,0);
        const tomorrow = new Date(today);

        tomorrow.setDate(tomorrow.getDate() + 10);
        var expiration_date = Math.round(tomorrow.getTime()/1000);
        app.request.promise.postJSON(app.data.server+'/custom/paymentlink?price='+donacion+'&expiration='+expiration_date,
        {
          
        }

        )
        .then(function (res) {
          console.log(res);
        app.dialog.close();
          window.open(res.data.paymentLink.url, '_blank');
        })
        .catch((error) => {
          console.error(error);
          app.dialog.close();
          app.dialog.alert('Encontramos un error, por favor, vuelva a intentarlo. Gracias', 'Error...');
        });
        

      });
    },
    pageInit: function(e, page) {

    },
    pageBeforeIn: function(e, page) {
      // Get all videos.

    },
    pageAfterIn: function(e, page) {
      

    },
    pageBeforeOut: function(e, page) {
    },
    pageAfterOut: function(e, page) {
    },
    pageBeforeRemove: function(e, page) {
    },
  }
};
</script>