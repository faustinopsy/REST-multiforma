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
        
                var usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
                const usuario = {
                    id: usuarios.length + 1,
                    nome: this.username,
                    type: 'user',
                };
        
                usuarios.push(usuario);
                localStorage.setItem('usuarios', JSON.stringify(usuarios));
        
                alert("Usuário criado: " + JSON.stringify(usuario));
                this.username = '';
            }
        }
}
