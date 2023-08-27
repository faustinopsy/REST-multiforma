
import criarUser from './createUser.js';
import GetUser from './getUser.js';
import listar from './getAll.js';

Vue.use(VueRouter )


const routes = [
    { path: '/criar', component: criarUser },
    { path: '/listar', component: listar },
    { path: '/buscar', component: GetUser },
  ]

  
  const router = new VueRouter({
    routes,
  });
  


  new Vue({
    router,
      el: '#app',
      data: {
        
      },
      methods: {
        
      },
      template: `
      <div>
        <router-view></router-view>
      </div>
      `
    });