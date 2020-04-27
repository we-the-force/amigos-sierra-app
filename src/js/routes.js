
import HomePage from '../pages/home.f7.html';
import AboutPage from '../pages/about.f7.html';
import CampanaPage from '../pages/campana.f7.html';


import DynamicRoutePage from '../pages/dynamic-route.f7.html';
import RequestAndLoad from '../pages/request-and-load.f7.html';
import NotFoundPage from '../pages/404.f7.html';

var routes = [
  {
    path: '/',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;

      // App instance
      var app = router.app;

      // Show Preloader
      app.preloader.show();

      app.request.promise.json(app.data.server+'campanas')
      .then(function (res) {
        console.log(res.data);
        app.preloader.hide();
        resolve(
          {
            component: HomePage,
          },
          {
            context: {
              campanas: res.data,
            }
          }
        );

      });
      
    },
  },
  {
    path: '/about/',
    component: AboutPage,
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

      app.request.promise.json(app.data.server+'campanas/'+campanaId)
      .then(function (res) {
        console.log(res.data);
        app.preloader.hide();
        resolve(
          {
            component: CampanaPage,
          },
          {
            context: {
              Campana: res.data,
              Paquetes: res.data.Paquetes,
            }
          }
        );

      });
      
    }
  },


  {
    path: '/dynamic-route/blog/:blogId/post/:postId/',
    component: DynamicRoutePage,
  },
  {
    path: '/request-and-load/user/:userId/',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;

      // App instance
      var app = router.app;

      // Show Preloader
      app.preloader.show();

      // User ID from request
      var userId = routeTo.params.userId;

      // Simulate Ajax Request
      setTimeout(function () {
        // We got user data from request
        var user = {
          firstName: 'Vladimir',
          lastName: 'Kharlampidi',
          about: 'Hello, i am creator of Framework7! Hope you like it!',
          links: [
            {
              title: 'Framework7 Website',
              url: 'http://framework7.io',
            },
            {
              title: 'Framework7 Forum',
              url: 'http://forum.framework7.io',
            },
          ]
        };
        // Hide Preloader
        app.preloader.hide();

        // Resolve route to load page
        resolve(
          {
            component: RequestAndLoad,
          },
          {
            context: {
              user: user,
            }
          }
        );
      }, 1000);
    },
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;