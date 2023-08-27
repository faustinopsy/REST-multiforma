const templateTodos = `
<div>
<div v-if="usuarios">
    <ul>
        <li v-for="usuario in usuarios" :key="usuario.id">
            {{ usuario.id }} - {{ usuario.nome }} - {{ usuario.type }}
        </li>
    </ul>
</div>
<div v-else>
    Não há usuários.
</div>
</div>

        `;

        export default {
            template: templateTodos,
            data() {
                return {
                    usuarios: null
                };
            },
            created() {
                this.getAll();
            },
            methods: {
                getAll() {
                    this.usuarios = JSON.parse(localStorage.getItem('usuarios'));
                    if (!this.usuarios) {
                        alert("Não há usuários");
                        return;
                    }
                }
            }
        
        }
        
