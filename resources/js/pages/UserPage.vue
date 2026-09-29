<template>
    <main>
        <MainHeaderComponent :user="user" :changePage="changePage" :server="server" />
            <div class="row row-cols-md-3 container">
                <template v-for="recipe in recipes">
                    <ReceptComponent
                        :server="server"
                        :recipe="recipe.recipe"
                        :isUser="isUser"
                        :PUBLIC="PUBLIC"
                        :changePage="changePage"
                        :pageID="recipe.id"
                    />
                </template>
            </div>
    </main>
</template>
<script>
import MainHeaderComponent from '@/components/MainHeaderComponent.vue';
import ReceptComponent from '@/components/ReceptComponent.vue';

export default {
    name: 'UserPage',
    props: ['isUser', 'successUser', 'server', 'user', 'PUBLIC', 'changePage', 'pageID'],
    components: {
        ReceptComponent,
        MainHeaderComponent,
    },
    data() {
        return {
            recipes: [],

           
        };
    },
    mounted() {
        this.getFavorites();
   
        
    },

    methods: {
        getFavorites(id) {
            this.server('user/' + id)
                .then((result) => {
                    console.log(result);

                    this.recipes = result;
                    this.server('category').then((result) => {
                        this.categories = result;
                    });
                })
                .catch((error) => console.log('error', error));
        },
     
    },
};
</script>
