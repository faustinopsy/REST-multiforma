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
    
    .then(response => response.json())
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
    .catch(error => {
        console.error('Erro:', error);
    });
});