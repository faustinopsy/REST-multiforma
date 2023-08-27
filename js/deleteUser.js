const templatedeletar =  `<div>
        <label for="getUserId">ID do Usuário:</label>
        <input type="number" v-model="userId">
        <button @click="deleteUser">Excluir</button>
    </div>`;
    export default {
    el: '#form-delete',
    template: templatedeletar,
    data: {
        userId: null
    
},
methods: {
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
    }
}
}
