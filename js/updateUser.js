function updateUser() {
    const userId = document.getElementById("getUserId").value;
    const userName = document.getElementById("updateUserName").value;

    const usuarioAtualizado = {
        nome: userName
    };

    fetch('/backend/usuario/' + userId, { 
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuarioAtualizado)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Sem rede ou não conseguiu localizar o recurso');
        }
        return response.json();
    })
    .then(data => {
        if(!data.codigo){
            alert("Não pode atualizar: ");
        }else{
            alert("Usuário atualizado: " + JSON.stringify(data));
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
