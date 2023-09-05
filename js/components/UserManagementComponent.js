export default class UserManagementComponent {
    constructor() {
        this.token = localStorage.getItem('token');
    }

    template() {
        return `
        <div class="content-container">
            <div class="card">
                <h3>Buscar Usuário</h3>
                <label for="getUserId">ID do Usuário:</label>
                <input type="number" id="getUserId">
                <button id="getUserButton">Buscar</button>

                <h3>Gerenciar Usuário</h3>
                <label for="inpuNome">Nome:</label>
                <input type="text" id="inpuNome">
                <button id="updateUserButton">Atualizar</button>
                <button id="deleteUserButton">Excluir</button>
            </div>
        </div>
        `;
    }

    attachEventListeners() {
        document.getElementById('getUserButton').addEventListener('click', this.getUser.bind(this));
        document.getElementById('updateUserButton').addEventListener('click', this.updateUser.bind(this));
        document.getElementById('deleteUserButton').addEventListener('click', this.deleteUser.bind(this));
    }

    getUser() {
        const userId = document.getElementById("getUserId").value;
    var token = localStorage.getItem('token');
    fetch('/backend/usuario/' + userId, {
        method: 'GET',
        headers: {
            'Authorization': token,
        },
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                window.location.href = '/';
                throw new Error('Não autorizado');
               
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert('Usuário não encontrado')
            document.getElementById("inpuNome").value = ''; 
        }else{
            document.getElementById("inpuNome").value = data.usuario.nome; 
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
    }

    updateUser() {
        const userId = document.getElementById("getUserId").value;
    const userName = document.getElementById("inpuNome").value;
    var token = localStorage.getItem('token');
    const usuarioAtualizado = {
        nome: userName
    };

    fetch('/backend/usuario/' + userId, { 
        method: 'PUT',
        headers: {
            'Authorization': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuarioAtualizado)
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                window.location.href = '/';
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert("Não pode atualizar: ");
        }else{
            alert("Usuário atualizado: " + JSON.stringify(data));
            window.location.href = '/todos';
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
    }

    deleteUser() {
        const userId = document.getElementById("getUserId").value;
    var token = localStorage.getItem('token');
    fetch('/backend/usuario/' + userId, {
        method: 'DELETE',
        headers: {
            'Authorization': token,
        },
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert("Não pode Deletar: ");
        }else{
            alert("Usuário deletado: " + JSON.stringify(data));
            document.getElementById("inpuNome").value = ''; 
            window.location.href = '/todos';
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
    }
}
