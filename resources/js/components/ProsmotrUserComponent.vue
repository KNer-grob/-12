<template>
    <table class="table-dark table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Имя</th>

                <th scope="col">почта</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(user, key) in users" :key="key">
                <th>{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: 'ProsmotrUserComponent',
    props: ['server'],
    data() {
        return {
            users: [],
        };
    },

    mounted() {
        this.getUsers();
    },

    methods: {
        getUsers() {
            this.server('usersSpisok')
                .then((result) => {
                    this.users = result;
                })
                .catch((error) => console.log('error', error));
        },
    },
};
</script>
