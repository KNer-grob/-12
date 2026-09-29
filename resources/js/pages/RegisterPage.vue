<template>
    <div >
        <div class="position-absolute top-50 start-50 translate-middle headings formBorder ">
        <p сlass="text-white  ">Регистрация</p>
        <main class="form border-warning ">

            <div class="row g-3">
                <div class="col-md-6">
                    <label  class="form-label text-white">Электронная почта</label>
                    <input type="email"  v-model="email"  class="form-control" >
                       <h3 class="red" v-if="errors.email">
                        {{ errors.email.join('. ') }}
                    </h3>
                </div>

                <div class="col-md-6">
                    <label  class="form-label text-white">Пароль</label>
                    <input type="password"   v-model="password" class="form-control">
                         <h3 class="red" v-if="errors.password">
                        {{ errors.password.join('. ') }}
                    </h3>
                </div>

                <div class="col-12">
                    <label  class="form-label text-white">Имя пользователя</label>
                    <input type="text" v-model="name"  class="form-control"  placeholder="Имя пользователя">
                           <h3 class="red" v-if="errors.name">
                        {{ errors.name.join('. ') }}
                    </h3>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning text-white w-50"  @click="register">Зарег-ся</button>
                </div>
            </div>
        </main>
    </div>
    </div>


</template>

<script>
export default {
    name: 'RegisterPage',
    props: ['server', 'isUser', 'successUser', 'logout', 'changePage'],
        data() {
        return {
            name: null,
            email: null,
            password: null,
            errors: {},
        };
    },
    methods: {
        register() {
            let formdata = new FormData();
            if (this.name) formdata.append('name', this.name);
            if (this.email) formdata.append('email', this.email);
            if (this.password) formdata.append('password', this.password);


            this.server('register', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;

                    }
                    if (result.token) {
                        this.successUser(result.token);
                        this.changePage('HomePage')
                    }
                })
                .catch((error) => console.log("error", error));
        },
    },
};
</script>
