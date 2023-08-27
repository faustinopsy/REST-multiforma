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

                const usuarios = JSON.parse(localStorage.getItem('usuarios'));
                
                if (!usuarios) {
                    alert("Não há usuários");
                    return;
                }
        
                this.usuario = usuarios.find(u => u.id == this.userId);
                this.username = this.usuario ? this.usuario.nome : '';
                this.userId = this.usuario ? this.usuario.id : '';
                if (!this.usuario) {
                    alert('Usuário não encontrado');
                    this.usuario = null;
                }
            },
            deleteUser() {
                if (!this.userId) {
                    alert("Por favor, insira um ID válido!");
                    return;
                }
        
                var usuarios = JSON.parse(localStorage.getItem('usuarios'));
        
                if (!usuarios) {
                    alert("Não há usuários para deletar");
                    return;
                }
        
                const novoUsuarios = usuarios.filter(usuario => usuario.id !== this.userId);
        
                if (novoUsuarios.length === usuarios.length) {
                    alert("Usuário não encontrado");
                    return;
                }
        
                localStorage.setItem('usuarios', JSON.stringify(novoUsuarios));
                alert("Usuário deletado");
            },
            updateUser() {
                if (!this.userId || !this.username) {
                    alert("Por favor, insira um ID e um nome válidos!");
                    return;
                }
        
                const usuarios = JSON.parse(localStorage.getItem('usuarios'));
        
                if (!usuarios) {
                    alert("Não há usuários");
                    return;
                }
        
                const usuarioIndex = usuarios.findIndex(u => u.id === this.userId);
        
                if (usuarioIndex === -1) {
                    alert("Usuário não encontrado");
                    return;
                }
        
                usuarios[usuarioIndex].nome = this.username;
                localStorage.setItem('usuarios', JSON.stringify(usuarios));
        
                alert("Usuário atualizado");
            }
        }
    }
