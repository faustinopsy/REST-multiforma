function getUser() {
    const userId = document.getElementById("getUserId").value;
    var token = localStorage.getItem('token');
    fetch('/backend/usuario/' + userId, {
        method: 'GET',
        headers: {
            'Authorization': token,
        },
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
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
            alert('Usuário não encontrado')
            document.getElementById("inpuNome").value = ''; 
        }else{
            document.getElementById("inpuNome").value = data.usuario.nome; 
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
}