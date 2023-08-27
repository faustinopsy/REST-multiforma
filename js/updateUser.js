function updateUser() {
    const userId = parseInt(document.getElementById("getUserId").value);
    const userName = document.getElementById("inpuNome").value;

    if (!userId || !userName) {
        alert("Por favor, insira um ID e um nome válidos!");
        return;
    }

    const usuarios = JSON.parse(localStorage.getItem('usuarios'));

    if (!usuarios) {
        alert("Não há usuários");
        return;
    }

    const usuarioIndex = usuarios.findIndex(u => u.id === userId);

    if (usuarioIndex === -1) {
        alert("Usuário não encontrado");
        return;
    }

    usuarios[usuarioIndex].nome = userName;
    localStorage.setItem('usuarios', JSON.stringify(usuarios));

    alert("Usuário atualizado");
}