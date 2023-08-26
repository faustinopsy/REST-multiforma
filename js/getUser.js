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
        if(!data.status){
            alert('Usuário não encontrado')
            document.getElementById("inpuNome").value = ''; 
        }else{
            document.getElementById("inpuNome").value = data.usuario.nome; 
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
}