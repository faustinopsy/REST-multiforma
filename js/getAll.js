document.getElementById('getAllButton').addEventListener('click', getAll);
var token = localStorage.getItem('token');
function getAll() {
    fetch('/backend/usuario', {
        method: 'GET',
        headers: {
            'Authorization': token,
        },
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                window.location.href = './login.html';
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        displayUsers(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
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
getAll();