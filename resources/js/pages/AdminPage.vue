<template>
    <main>
        <div id="accordionExample">
            <MainHeaderComponent :user="user" :changePage="changePage" :server="server"   />

            <div class="main">
                <div>
                    <div class="exspress block">{{ pageID ? 'Редактирование' : 'Создание нового' }}</div>
                    <div class="block">
                        <button @click="setActive('add')" class="btn btn-outline-warning" type="button">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="235"
                                height="16"
                                fill="currentColor"
                                class="bi bi-pencil-square"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                                />
                                <path
                                    fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"
                                />
                            </svg>
                        </button>
                    </div>
                
                    <div class="exspress block">Просмотр пользователей</div>
                    <div class="block">
                        <button @click="setActive('users')" type="button" class="btn btn-outline-warning">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="235"
                                height="16"
                                fill="currentColor"
                                class="bi bi-person-lines-fill"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="exspress block">Создание ингредиентов</div>
                    <div class="block">
                        <button @click="setActive('ingridients')" type="button" class="btn btn-outline-warning">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="235"
                                height="16"
                                fill="currentColor"
                                class="bi bi-fork-knife"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M13 .5c0-.276-.226-.506-.498-.465-1.703.257-2.94 2.012-3 8.462a.5.5 0 0 0 .498.5c.56.01 1 .13 1 1.003v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5zM4.25 0a.25.25 0 0 1 .25.25v5.122a.128.128 0 0 0 .256.006l.233-5.14A.25.25 0 0 1 5.24 0h.522a.25.25 0 0 1 .25.238l.233 5.14a.128.128 0 0 0 .256-.006V.25A.25.25 0 0 1 6.75 0h.29a.5.5 0 0 1 .498.458l.423 5.07a1.69 1.69 0 0 1-1.059 1.711l-.053.022a.92.92 0 0 0-.58.884L6.47 15a.971.971 0 1 1-1.942 0l.202-6.855a.92.92 0 0 0-.58-.884l-.053-.022a1.69 1.69 0 0 1-1.059-1.712L3.462.458A.5.5 0 0 1 3.96 0z"
                                />
                            </svg>
                        </button>
                    </div>
                         <div class="exspress block">Создание категорий</div>
                    <div class="block">
                        <button @click="setActive('categorys')" type="button" class="btn btn-outline-warning">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="235"
                                height="16"
                                fill="currentColor"
                                class="bi bi-fork-knife"
                                viewBox="0 0 16 16"
                            >
                               <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
  <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>

                            </svg>
                        </button>
                    </div>
                </div>
                <div class="catalog">
                    <div>
                        <div class="multi-collapse" id="multiCollapseExample1">
                            <div v-if="active == 'add'">
                                <ReceptAddComponent :server="server" :changePage="changePage" :pageID="pageID" :PUBLIC="PUBLIC" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="multi-collapse" id="multiCollapseExample2">
                            <div v-if="active == 'users'">
                                <ProsmotrUserComponent :server="server" />
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
                    <div>
                        <div class="multi-collapse" id="multiCollapseExample2">
                            <div v-if="active == 'ingridients'">
                                <IngridientAddComponent :server="server" :changePage="changePage" :active="active" />
                            </div>
                        </div>
                    </div>
                      <div>
                        <div class="multi-collapse" id="multiCollapseExample2">
                            <div v-if="active == 'categorys'">
                                <CategoryComponent :server="server"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import ProsmotrUserComponent from '@/components/ProsmotrUserComponent.vue';
import ReceptAddComponent from '@/components/ReceptAddComponent.vue';
import ReceptComponent from '@/components/ReceptComponent.vue';
import IngridientAddComponent from '@/components/IngridientAddComponent.vue';
import MainHeaderComponent from '@/components/MainHeaderComponent.vue';
import CategoryComponent from '@/components/CategoryComponent.vue';

export default {
    name: 'AdminPage',
    components: {
        ReceptComponent,
        ReceptAddComponent,
        ProsmotrUserComponent,
        IngridientAddComponent,
        MainHeaderComponent,
        CategoryComponent,
    },

    props: ['changePage', 'server', 'pageID', 'PUBLIC', 'isUser', 'user'],
    data() {
        return {
            active: localStorage.getItem('adminBlock') || 'add',
            recipes: [],
        };
        //     data() {
        //   return {
        //     step:[],
        //     server:'http://127.0.0.1:8000/api/'

        //   }
    },
    mounted() {
        this.getRecipes();
    },

    methods: {
        setActive(active) {
            this.active = active;
            localStorage.setItem('adminBlock', active);
        },
        getRecipes(page = 1) {
            this.server('recipesAdmin?page=' + page)
                .then((result) => {
                    this.recipes = result.recipes;
                })
                .catch((error) => console.log('error', error));

            //  async data(route, method = 'GET', formdata = null) {
            //     let myHeaders = new Headers();
            //     myHeaders.append('Accept', 'application/json');

            //     if (localStorage.getItem('token')) {
            //         myHeaders.append('Authorization', 'Bearer ' + localStorage.getItem('token'));
            //     }

            //     let requestOptions = { method: POST, headers: myHeaders, redirect: 'follow' };

            //     if (method != 'GET') {
            //         requestOptions.body = formdata;
            //     }
            //     return await fetch(this.server  + route, requestOptions)
            //     .then((response) =>response.json())
        },
    },
};
</script>
