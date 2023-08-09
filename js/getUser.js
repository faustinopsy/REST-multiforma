export function getUser() {
    fetch('/backend/usuario/1')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert("Usuário recuperado: " + JSON.stringify(data));
        })
        .catch(error => alert('Erro na requisição: ' + error));
}
