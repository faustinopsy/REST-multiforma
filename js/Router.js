class Router {
    constructor(routes) {
        this.routes = routes;
        this.init();
    }

    init() {
        window.addEventListener('hashchange', () => this.routeChanged());
        if (!window.location.hash) {
            window.location.hash = '#/';
        } else {
            this.routeChanged();
        }
    }

    routeChanged() {
        const uri = window.location.hash.substring(1);
        const routeComponent = this.routes[uri] || this.routes["#/not-found"];
        const template = routeComponent.template();
    
        document.querySelector("#app").innerHTML = this.addNavbar(template);
    
        if (routeComponent.attachEventListeners) {
            routeComponent.attachEventListeners();
        }
    }

    addNavbar(template) {
        return `
            <div>
                <navbar-component></navbar-component>
                ${template}
            </div>
        `;
    }
}

export default Router;
