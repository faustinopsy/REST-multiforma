function deleteUser() {
    const userId = parseInt(document.getElementById("getUserId").value);

    if (!userId) {
        alert("Por favor, insira um ID válido!");
        return;
    }

    var usuarios = JSON.parse(localStorage.getItem('usuarios'));

    if (!usuarios) {
        alert("Não há usuários para deletar");
        return;
    }

    const novoUsuarios = usuarios.filter(usuario => usuario.id !== userId);

    if (novoUsuarios.length === usuarios.length) {
        alert("Usuário não encontrado");
        return;
    }

    localStorage.setItem('usuarios', JSON.stringify(novoUsuarios));
    document.getElementById("inpuNome").value = ''; 
    alert("Usuário deletado");
}