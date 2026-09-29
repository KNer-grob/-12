<template>
    <div>
        <div class="position-absolute top-50 start-50 translate-middle headings formBorder1">
            <p сlass="text-white  ">Авторизация</p>
            <main class="form border-warning ">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label  class="form-label text-white">Электронная почта</label>
                        <input type="email" v-model="email" class="form-control" />
                        <h3 class="red" v-if="errors.email">
                            {{ errors.email.join('. ') }}
                        </h3>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white">Пароль</label>
                        <input type="password" v-model="password" class="form-control"  />
                        <h3 class="red" v-if="errors.password">
                            {{ errors.password.join('. ') }}
                        </h3>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-warning w-50 text-white" @click="auth">Авторизация</button>
                        <h3 class="red" v-if="401">
                            {{ errors.login }}
                        </h3>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AuthPage',
    props: ['server', 'isUser', 'successUser', 'logout', 'changePage'],
    data() {
        return {
            email: null,
            password: null,
            errors: {},
        };
    },
    methods: {
        auth() {
            let formdata = new FormData();
            if (this.email) formdata.append('email', this.email);
            if (this.password) formdata.append('password', this.password);

            this.server('login', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                    if (result.token) {
                        this.successUser(result.token);
                        this.changePage('HomePage')
                    }
                    if (result.token == 401) {
                        this.errors = 'Не правильный логин или пороль';
                    }
                })
                .catch((error) => console.log('error', error));
        },
    },
};
</script>
