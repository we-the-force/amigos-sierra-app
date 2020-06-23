
import HomePage from '../pages/home.f7.html';
import CampanaPage from '../pages/campana.f7.html';


import NotFoundPage from '../pages/404.f7.html';



var routes = [
  {
    path: '/',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;
      var campanasInfo;
      // App instance
      var app = router.app;
      // Show Preloader
      app.preloader.show();

      app.request.promise.json(app.data.server+'/items/campana?fields=*.*')
      .then(function (res) {
        console.log(res);
        campanasInfo=res.data.data;
        // app.preloader.hide();
        app.request.promise.json(app.data.server+'/items/informacion?fields=*.*')
        .then(function(respuesta){
        app.preloader.hide();
          resolve(
            {
              component: HomePage,
            },
            {
              context: {
                campanas: campanasInfo,
                informacion: respuesta.data.data[0],
                server: app.data.server
              }
            }
          );
        })
      });
      
    },
  },
  
  {
    path: '/campana/:campanaId',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;

      // App instance
      var app = router.app;
      var campanaId = routeTo.params.campanaId;
      // Show Preloader
      app.preloader.show();

      app.request.promise.json(app.data.server+'/items/campana/'+campanaId+'?fields=*.*.*')
      .then(function (res) {
        console.log(res);
        app.preloader.hide();
        resolve(
          {
            component: CampanaPage,
          },
          {
            context: {
              server: app.data.server,
              campana: res.data.data,
              paquetes: res.data.data.paquetes,
            }
          }
        );

      });
      
    }
  },


 
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;