const templateTodos = `
<div>
<div v-if="usuarios">
    <ul>
        <li v-for="usuario in usuarios" :key="usuario.id">
            {{ usuario.id }} - {{ usuario.nome }} - {{ usuario.type }}
        </li>
    </ul>
</div>
<div v-else>
    Não há usuários.
</div>
</div>

        `;

        export default {
            template: templateTodos,
            data() {
                return {
                    usuarios: null
                };
            },
            created() {
                this.getAll();
            },
            methods: {
                getAll() {
                    const token = localStorage.getItem('token');
                    if (!token) {
                        alert("Token não encontrado!");
                        return;
                    }
        
                    fetch('/backend/usuario', {
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
                        this.usuarios = data.usuarios;
                    })
                    .catch(error => alert('Erro na requisição: ' + error));
                }
            }
        
        }
        