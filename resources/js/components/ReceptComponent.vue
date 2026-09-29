<template>
    <div class="col">
        <div class="card text-bg-warning h-100">
      
            <img :src="PUBLIC + recipe.photo" class="card-img-top" alt="..." />
            <button type="button" class="btn btn-outline-warning" >
                <div class="redit" v-if="isAdmin">
                          <a href="" @click="setActive('add')" @click.prevent="changePage('AdminPage', recipe.id)"   >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
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
                    </a>

                  
                </div>
                
            </button>
            <div class="card-body">
           
                <h3 class="card-title">{{ recipe.title }}</h3>  
                <p class="card-text">{{ recipe.cook_time }} мин</p>

                <div class="badge text-bg-dark text-wrap">
                    {{ recipe.difficulty }}
                </div>
                <button
                    v-if="isUser"
                    :class="isfavorites ? 'btn-danger' : 'btn-outline-black'"
                    @click="clickFavorite(recipe.id)"
                    class="btn w-25 m-1 ms-5"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-bookmark-heart-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"
                        />
                    </svg>
                </button>
            </div>
        

            <div class="card-footer">
                <button>
                    <a href="" @click.prevent="changePage('SinglePage', recipe.id)" class="nav-link px-2 text-white"> <h2>Просмотр рецепта</h2></a>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ReceptComponent',
    props: ['isUser', 'successUser', 'pageID', 'recipe', 'server', 'user', 'PUBLIC', 'changePage', 'logout',],
    data() {
        return {
            isAdmin: false,
            isfavorites: false,
            favorites: [],
            active: localStorage.getItem('adminBlock') || 'add',
        };
    },
    mounted() {
       this.getRecipe();
    },
    methods: {
        clickFavorite(id) {
            this.isfavorites = this.isfavorites == false ? true : false;
            this.server(`recipes/${id}/favorite`)
                .then((result) => {
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
         setActive(active) {
            this.active = active;
            localStorage.setItem('adminBlock', active);
        },

        getRecipe() {
            this.server(this.isUser ? 'recipeUser/' + this.pageID : 'recipe/' + this.pageID)
                .then((result) => {
                    this.isAdmin = result.isAdmin;
                })
                .catch((error) => console.log('error', error));
        },
        
    },
};
</script>
