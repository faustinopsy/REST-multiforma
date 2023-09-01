function deleteUser() {
    const userId = document.getElementById("getUserId").value;
    var token = localStorage.getItem('token');
    fetch('/backend/usuario/' + userId, {
        method: 'DELETE',
        headers: {
            'Authorization': token,
        },
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert("Não pode Deletar: ");
        }else{
            alert("Usuário deletado: " + JSON.stringify(data));
            document.getElementById("inpuNome").value = ''; 
            window.location.href = './';
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}