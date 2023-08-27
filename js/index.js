
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
      mounted() {
        this.loadToken();
    },
      methods: {
        loadToken() {
            fetch('/backend/token')
                .then(response => response.json())
                .then(data => localStorage.setItem('token', data.token));
        }
      },
      template: `
      <div>
        <router-view></router-view>
      </div>
      `
    });