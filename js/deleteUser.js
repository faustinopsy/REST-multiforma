export function deleteUser() {
    fetch('/backend/usuario/1', {
        method: 'DELETE'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert("Usuário deletado: " + JSON.stringify(data));
        })
        .catch(error => alert('Erro na requisição: ' + error));
}