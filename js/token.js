const templatetoken = `
    <div></div>
`;

const token = new Vue({
    data: {
    },
        mounted() {
            this.loadToken();
        },
        methods: {
            loadToken() {
                fetch('/backend/token')
                    .then(response => response.json())
                    .then(data => localStorage.setItem('token', data.token));
            }
        }
    });
