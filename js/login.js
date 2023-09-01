document.getElementById('loginForm').addEventListener('submit', function(event){
    event.preventDefault();
    
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    
    fetch('/backend/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password
        }),
    })
    
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                throw new Error('Não autorizado');
               
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
            
        }
        return response.json();
    })
    .then(data => {
        if(data.token){
            localStorage.setItem('token', data.token)
            
            alert('Login bem-sucedido!');
            window.location.href = './';
        }
        else{
            alert('Erro: ' + data.error);
        }
    })
    .catch(error => alert('Erro na requisição: ' + error));
});