function getUser() {
    const userId = document.getElementById("getUserId").value;

    fetch('/backend/usuario/' + userId)
    .then(response => {
        if (!response.ok) {
            throw new Error('Sem rede ou não conseguiu localizar o recurso');
        }
        return response.json();
    })
    .then(data => {
        if(!data.codigo){
            alert('Usuário não encontrado')
        }else{
            document.getElementById("updateUserName").value = data.usuario.nome; 
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
}