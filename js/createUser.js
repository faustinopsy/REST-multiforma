document.getElementById('submitButton').addEventListener('click', createUser);
var token = localStorage.getItem('token');
function createUser() {
    const nomeUsuario = document.getElementById('username').value;

    if (!nomeUsuario) {
        alert("Por favor, insira um nome!");
        return;
    }

    const usuario = {
        nome: nomeUsuario
    };

    fetch('/backend/usuario', { 
        method: 'POST',
        headers: {
            'Authorization': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuario)
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
        if(!data.status){
            alert('Usuário já existe')
        }else{
            alert("Usuário criado: " + JSON.stringify(data));
            window.location.href = './';
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
