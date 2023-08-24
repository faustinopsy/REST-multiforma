function deleteUser() {
    const userId = document.getElementById("getUserId").value;

    fetch('/backend/usuario/' + userId, {
        method: 'DELETE'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(!data.codigo){
            alert("Não pode Deletar: ");
        }else{
            alert("Usuário deletado: " + JSON.stringify(data));
            document.getElementById("updateUserName").value = ''; 
        } 
        
    })
    .catch(error => alert('Erro na requisição: ' + error));
}