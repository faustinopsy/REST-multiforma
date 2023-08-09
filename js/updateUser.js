export function updateUser() {
    const usuarioAtualizado = {
        nome: "Carlos da Silva"
    };

    fetch('/backend/usuario/1', { 
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuarioAtualizado)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert("Usuário atualizado: " + JSON.stringify(data));
        })
        .catch(error => alert('Erro na requisição: ' + error));
}