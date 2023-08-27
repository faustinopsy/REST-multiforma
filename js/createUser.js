document.getElementById('submitButton').addEventListener('click', createUser);
var token = localStorage.getItem('token');
function createUser() {
    const nomeUsuario = document.getElementById('username').value;

    if (!nomeUsuario) {
        alert("Por favor, insira um nome!");
        return;
    }

    var usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
    const usuario = {
        id: usuarios.length + 1,
        nome: nomeUsuario,
        type: 'user',
    };

    usuarios.push(usuario);
    localStorage.setItem('usuarios', JSON.stringify(usuarios));

    alert("Usuário criado: " + JSON.stringify(usuario));
}
