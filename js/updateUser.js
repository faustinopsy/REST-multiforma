function updateUser() {
    const userId = document.getElementById("getUserId").value;
    const userName = document.getElementById("inpuNome").value;
    var token = localStorage.getItem('token');
    const usuarioAtualizado = {
        nome: userName
    };

    fetch('/backend/usuario/' + userId, { 
        method: 'PUT',
        headers: {
            'Authorization': token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuarioAtualizado)
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
            alert("Não pode atualizar: ");
        }else{
            alert("Usuário atualizado: " + JSON.stringify(data));
            window.location.href = './';
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
