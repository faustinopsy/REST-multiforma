const templatecriar =  `
    <div>
        <form @submit.prevent="createUser">
            <label for="username">Nome:</label>
            <input type="text" v-model="username" required>
            <button type="submit">Criar Usuário</button>
        </form>
    </div>`;

    export default {
    template: templatecriar,
        data() {
            return {
                username: ''
            };
        },
        methods: {
            createUser() {
                if (!this.username) {
                    alert("Por favor, insira um nome!");
                    return;
                }
            
                const usuario = {
                    nome: this.username,
                    type: 'user',
                };
            
                const token = localStorage.getItem('token');

                if (!token) {
                    alert("Token não encontrado!");
                    return;
                }
            
                fetch('/backend/usuario', { 
                    method: 'POST',
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(usuario)
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
                        alert('Usuário já existe')
                    }else{
                        alert("Usuário criado: " + JSON.stringify(data));
                    } 
                    this.username = '';
                })
                .catch(error => alert('Erro na requisição: ' + error));
            }
            
        }
}
