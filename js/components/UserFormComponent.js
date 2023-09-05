export default class UserFormComponent {
    constructor() {
        this.token = localStorage.getItem('token');
    }

    template() {
        return `
        <div class="content-container">
            <div class="card">
                <form id="userForm">
                    <label for="username">Nome:</label>
                    <input type="text" id="username" name="username" required>
                    <button type="button" id="submitButton">Criar Usuário</button>
                </form>
            </div>
        </div>
        `;
    }

    attachEventListeners() {
        document.getElementById('submitButton').addEventListener('click', this.createUser.bind(this));
    }

    createUser() {
        const nomeUsuario = document.getElementById('username').value;

        if (!nomeUsuario) {
            alert("Por favor, insira um nome!");
            return;
        }

        const usuario = {
            nome: nomeUsuario
        };

        fetch('/backend/usuario', { 
            method: 'POST',
            headers: {
                'Authorization': this.token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(usuario)
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401 || response.status === 403) {
                    window.location.hash = '#/';
                    throw new Error('Não autorizado');
                } else {
                    throw new Error('Sem rede ou não conseguiu localizar o recurso');
                }
            }
            return response.json();
        })
        .then(data => {
            if(!data.status) {
                alert('Usuário já existe');
            } else {
                alert("Usuário criado: " + JSON.stringify(data));
                window.location.href = '/todos';
            }
        })
        .catch(error => alert('Erro na requisição: ' + error));
    }
}
