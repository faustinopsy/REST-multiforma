function getUser() {
    const userId = parseInt(document.getElementById("getUserId").value);

    if (!userId) {
        alert("Por favor, insira um ID válido!");
        return;
    }

    const usuarios = JSON.parse(localStorage.getItem('usuarios'));

    if (!usuarios) {
        alert("Não há usuários");
        return;
    }

    const usuario = usuarios.find(u => u.id === userId);

    if (!usuario) {
        alert('Usuário não encontrado');
        document.getElementById("inpuNome").value = ''; 
    } else {
        document.getElementById("inpuNome").value = usuario.nome;
    }
}