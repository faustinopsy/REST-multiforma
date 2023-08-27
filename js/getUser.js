const templatedeletar =  `
<div>
<div>
    <label for="getUserId">ID do Usuário:</label>
    <input type="number" v-model="userId">
    <button @click="getUser">Buscar</button>
</div>
<div v-if="usuario"><br>
    <div>
        <label for="inputNome">Nome:</label>
        <input type="text" v-model="username">
    </div>
    <div>
        <button @click="updateUser">Atualizar</button>
        <button @click="deleteUser">Excluir</button>
    </div>
</div>
</div>`;


export default {
    template: templatedeletar,
    data() {
        return {
            userId: null,
            usuario: null,
            username: ''   
        };
    },
    methods: {
        getUser() {
            if (!this.userId) {
                alert("Por favor, insira um ID válido!");
                return;
            }

            const token = localStorage.getItem('token');
            if (!token) {
                alert("Token não encontrado!");
                return;
            }

            fetch('/backend/usuario/' + this.userId, {
                method: 'GET',
                headers: {
                    'Authorization': token,
                },
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
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
                    this.username = ''; 
                }else{
                    this.usuario = data.usuario;
                    this.username = this.usuario.nome;
                } 
            })
            .catch(error => alert('Erro na requisição: ' + error));
        },
        deleteUser() {
            if (!this.userId) {
                alert("Por favor, insira um ID válido!");
                return;
            }

            const token = localStorage.getItem('token');
            if (!token) {
                alert("Token não encontrado!");
                return;
            }

            fetch('/backend/usuario/' + this.userId, {
                method: 'DELETE',
                headers: {
                    'Authorization': token,
                },
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error('Não autorizado');
                    } else {
                        throw new Error('Sem rede ou não conseguiu localizar o recurso');
                    }
                }
                return response.json();
            })
            .then(data => {
                if(!data.status){
                    alert("Não pode deletar");
                }else{
                    alert("Usuário deletado: " + JSON.stringify(data));
                    this.username = '';
                } 
            })
            .catch(error => alert('Erro na requisição: ' + error));
        },
        updateUser() {
            if (!this.userId || !this.username) {
                alert("Por favor, insira um ID e um nome válidos!");
                return;
            }

            const token = localStorage.getItem('token');
            if (!token) {
                alert("Token não encontrado!");
                return;
            }

            const usuarioAtualizado = {
                id: this.userId,
                nome: this.username,
                type: 'user',
            };

            fetch('/backend/usuario/' + this.userId, { 
                method: 'PUT',
                headers: {
                    'Authorization': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(usuarioAtualizado)
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error('Não autorizado');
                    } else {
                        throw new Error('Sem rede ou não conseguiu localizar o recurso');
                    }
                }
                return response.json();
            })
            .then(data => {
                if(!data.status){
                    alert("Não pode atualizar");
                }else{
                    alert("Usuário atualizado: " + JSON.stringify(data));
                } 
            })
            .catch(error => alert('Erro na requisição: ' + error));
        }
    }
}
