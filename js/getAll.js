document.getElementById('getAllButton').addEventListener('click', getAll);

function getAll() {
    fetch('/backend/usuario') 
    .then(response => {
        if (!response.ok) {
            throw new Error('Sem rede ou não conseguiu localizar o recurso');
        }
        return response.json();
    })
    .then(data => {
        displayUsers(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}

function displayUsers(data) {
    const users = data.usuarios;  // pegando o array 'usuarios' do objeto data
    const usersDiv = document.getElementById('usersList');
    usersDiv.innerHTML = ''; // Limpa a lista atual

    const list = document.createElement('ul');
    users.forEach(user => {
        const listItem = document.createElement('li');
        listItem.textContent = `${user.id} - ${user.nome} - ${user.email}`; // Supondo que cada usuário tenha propriedades 'id', 'nome' e 'email'
        list.appendChild(listItem);
    });

    usersDiv.appendChild(list);
}
