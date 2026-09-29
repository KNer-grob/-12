<template>
    <header class="border-bottom border-warning p-3">
        <div class="container">
            <div class="d-flex">
                <ul class="nav col-12 col-lg-auto me-lg-auto">
                    <a href="" @click.prevent="changePage('HomePage')" class="d-flex align-items-center text-decoration-none text-white">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="45"
                            height="32"
                            fill="currentColor"
                            class="bi bi-fork-knife"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M13 .5c0-.276-.226-.506-.498-.465-1.703.257-2.94 2.012-3 8.462a.5.5 0 0 0 .498.5c.56.01 1 .13 1 1.003v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5zM4.25 0a.25.25 0 0 1 .25.25v5.122a.128.128 0 0 0 .256.006l.233-5.14A.25.25 0 0 1 5.24 0h.522a.25.25 0 0 1 .25.238l.233 5.14a.128.128 0 0 0 .256-.006V.25A.25.25 0 0 1 6.75 0h.29a.5.5 0 0 1 .498.458l.423 5.07a1.69 1.69 0 0 1-1.059 1.711l-.053.022a.92.92 0 0 0-.58.884L6.47 15a.971.971 0 1 1-1.942 0l.202-6.855a.92.92 0 0 0-.58-.884l-.053-.022a1.69 1.69 0 0 1-1.059-1.712L3.462.458A.5.5 0 0 1 3.96 0z"
                            />
                        </svg>
                    </a>
                    <li><a href="" @click.prevent="changePage('HomePage')" class="nav-link px-2 text-white">Главная страница</a></li>
                    <li><a href="" class="nav-link px-2 text-white">Контакты</a></li>
                    <li><a href="" class="nav-link px-2 text-white">Фелиалы</a></li>
                    <li><a href="" class="nav-link px-2 text-white">О нас</a></li>
                    <li><a href="" class="nav-link px-2 text-white">Партнерам</a></li>
                </ul>

                <div class="nav col-12 col-lg-auto text-end" v-if="!isUser">
                    <button type="button" class="btn btn-outline-warning me-2">
                        <a href="" @click.prevent="changePage('AuthPage')" class="register-link">Авторнизация</a>
                    </button>
                    <button type="button" class="btn btn-outline-warning">
                        <a href="" @click.prevent="changePage('RegisterPage')" class="register-link">Регистрация</a>
                    </button>
                </div>
                <div class="nav col-12 col-lg-auto text-end" v-else>
                    <button type="button" class="btn btn-outline-warning me-2">
                        <a href="" @click.prevent="changePage('UserPage')" class="register-link">Личный кабинет</a>
                    </button>
                    <button type="button" class="btn btn-outline-warning me-2">
                        <a href="" @click.prevent="logout" class="register-link">Выйти</a>
                    </button>
                    <div v-if="page !== 'AdminPage'" >
                          <button type="button" class="btn btn-outline-warning me-2" v-if="user.role == 'admin'">
                        <a href="" @click.prevent="changePage('AdminPage')" class="register-link">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-person-circle"
                                viewBox="0 0 16 16"
                            >
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path
                                    fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"
                                />
                            </svg>
                        </a>
                    </button>
                    <button type="button" class="btn btn-outline-warning me-2" v-if="user.role == 'admin'">
                        <a href=""  @click="changePage('AdminPage')" @click.prevent="setActive('add')" class="register-link">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-bag-plus"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5"
                                />
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"
                                />
                            </svg>
                        </a>
                    </button>
                    </div>
                  
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'HeaderComponent',
    props: ['isUser', 'successUser', 'server', 'user', 'PUBLIC', 'changePage', 'logout','page'],
    data() {
        return {
            active: localStorage.getItem('adminBlock') || 'add',
        };
    },
    methods: {
        setActive(active) {
            this.active = active;
            localStorage.setItem('adminBlock', active);
        },
    }
 
};
</script>
