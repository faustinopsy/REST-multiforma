import UserFormComponent from './components/UserFormComponent.js';
import UsersListComponent from './components/UsersListComponent.js';
import UserManagementComponent from './components/UserManagementComponent.js';
import LoginComponent from './components/LoginComponent.js';
import NavbarComponent from './components/NavbarComponent.js';

const loginComponent = new LoginComponent();
const userFormComponent = new UserFormComponent();
const usersListComponent = new UsersListComponent();
const userManagementComponent = new UserManagementComponent();
import Router from './Router.js';

const navbarComponent = new NavbarComponent();

document.getElementById('navbarPlaceholder').innerHTML = navbarComponent.template();

const routes = {
    '/': loginComponent,
    '/criar': userFormComponent,
    '/todos': usersListComponent,
    '/busca': userManagementComponent,
    '/not-found': { template: '<p>Not found</p>' } // Exemplo de rota 404
};

const router = new Router(routes);
