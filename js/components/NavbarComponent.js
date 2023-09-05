export default class NavbarComponent {
    template() {
        return `
            <nav class="navbar">
                <a href="#/criar">Cadastrar</a>
                <a href="#/todos">Listar todos</a>
                <a href="#/busca">Buscar</a>
            </nav>
        `;
    }

    attachEventListeners() {
       
    }
}
