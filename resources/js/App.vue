<template>
    <HeaderComponent :changePage="changePage" :isUser="isUser" :page='page' :successUser="successUser" :logout="logout" :user="user"/>
    <HomePage v-if="page == 'HomePage'" :changePage="changePage" :page='page' :server="server" :isUser="isUser" :user="user" :pageID="pageID" :PUBLIC="PUBLIC" />
    <AuthPage v-if="page == 'AuthPage'" :server="server" :isUser="isUser" :successUser="successUser" :logout="logout" :changePage="changePage" />
    <RegisterPage
        v-if="page == 'RegisterPage'"
        :server="server"
        :isUser="isUser"
        :successUser="successUser"
        :logout="logout"
        :changePage="changePage"
    />
    <SinglePage
        v-if="page == 'SinglePage'"
        :server="server"
        :isUser="isUser"
        :successUser="successUser"
        :pageID="pageID"
        :PUBLIC="PUBLIC"
        :logout="logout"
        :changePage="changePage"
    />
    <UserPage v-if="page == 'UserPage'" :user="user"  :changePage="changePage" :server="server" :isUser="isUser" :pageID="pageID" :PUBLIC="PUBLIC" />
    <AdminPage v-if="page == 'AdminPage'" :user="user"  :page='page' :changePage="changePage" :server="server" :isUser="isUser" :pageID="pageID" :PUBLIC="PUBLIC" />

    <FooterComponent />
</template>

<script>
import FooterComponent from './components/FooterComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue';
import AdminPage from './pages/AdminPage.vue';
import AuthPage from './pages/AuthPage.vue';
import HomePage from './pages/HomePage.vue';
import RegisterPage from './pages/RegisterPage.vue';
import SinglePage from './pages/SinglePage.vue';
import UserPage from './pages/UserPage.vue';

export default {
    name: 'App',
    components: {
        HeaderComponent,
        HomePage,
        FooterComponent,
        RegisterPage,
        AuthPage,
        SinglePage,
        UserPage,
        AdminPage,
    },
    data() {
        return {
            page: localStorage.getItem('page') || 'HomePage',
            pageID: localStorage.getItem('pageID') ?? '',
            api: 'http://127.0.0.1:8000/api/',
            PUBLIC: 'http://127.0.0.1:8000/storage/',
            isUser: false,
            isLoad: false,
            user: {},
            likeArray: [],
        };
    },
    mounted() {
        if (localStorage.getItem('token')) {
            this.getUser();
            this.isUser = localStorage.getItem('token') ? true : false;
        } else {
            this.isLoad = true;
        }
    },
    methods: {
        changePage(page, pageID = null) {
            this.page = page;
            this.pageID = pageID;
            localStorage.setItem('page', page);
            localStorage.setItem('pageID', pageID ?? '');
        },
        getUser() {
            this.server('user')
                .then((result) => {
                    this.user = result.user;
                    this.isUser = true;
                    this.isLoad = true;
                    this.likeArray = result.likeArray;
                })
                .catch((error) => console.log('error', error));
        },
        successUser(token) {
            localStorage.setItem('token', token);
            this.isUser = true;
            this.getUser();
        },
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('page');
            this.user = {};
            this.isUser = false;
        },
        async server(route, method = 'GET', formdata = null) {
            let myHeaders = new Headers();
            myHeaders.append('Accept', 'application/json');

            if (localStorage.getItem('token')) {
                myHeaders.append('Authorization', 'Bearer ' + localStorage.getItem('token'));
            }

            let requestOptions = { method: method, headers: myHeaders, redirect: 'follow' };

            if (method != 'GET') {
                requestOptions.body = formdata;
            }
            return await fetch(this.api + route, requestOptions).then((response) => {
                if (response.status == 401) {
                    this.logout();
                }
                return response.json();
            });
        },
    },
};
</script>
