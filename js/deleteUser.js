function deleteUser() {
    const userId = document.getElementById("getUserId").value;

    fetch('/backend/usuario/' + userId, {
        method: 'DELETE'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Sem rede ou não conseguiu localizar o recurso');
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert("Não pode Deletar: ");
        }else{
            alert("Usuário deletado: " + JSON.stringify(data));
            document.getElementById("inpuNome").value = ''; 
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}