document.getElementById('getAllButton').addEventListener('click', getAll);
var token = localStorage.getItem('token');
function getAll() {
    const usuarios = JSON.parse(localStorage.getItem('usuarios'));

    if (!usuarios) {
        alert("Não há usuários");
        return;
    }

    displayUsers({usuarios: usuarios});
}

function displayUsers(data) {
    const users = data.usuarios;  
    const usersDiv = document.getElementById('usersList');
    usersDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    users.forEach(user => {
        const listItem = document.createElement('li');
        listItem.textContent = `${user.id} - ${user.nome} - ${user.type}`;
        list.appendChild(listItem);
    });

    usersDiv.appendChild(list);
}
