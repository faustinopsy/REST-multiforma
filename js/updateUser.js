const templateupdate =  `<div>
        <label for="getUserId">ID do Usuário:</label>
        <input type="number" v-model="userId">
        <label for="inputNome">Nome:</label>
        <input type="text" v-model="username">
        <button @click="updateUser">Atualizar</button>
    </div>`;

    export default {
    el: '#form-atualiza',
    template: templateupdate,
    data: {
        userId: null,
        username: ''
            
        },
        methods: {
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
