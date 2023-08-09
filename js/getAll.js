export function getAll() {
    fetch('/backend/usuario') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert("Usuários recuperados: " + JSON.stringify(data));
        })
        .catch(error => alert('Erro na requisição: ' + error));
}