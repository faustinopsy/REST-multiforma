export function createUser() {
    const usuario = {
        nome: "Carlos"
    };

    fetch('/backend/usuario', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuario)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert("Usuário criado: " + JSON.stringify(data));
        })
        .catch(error => alert('Erro na requisição: ' + error));
}
