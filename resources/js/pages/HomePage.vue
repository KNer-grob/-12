<template>
    <main>
        <MainHeaderComponent :user="user" :changePage="changePage" :server="server" />
        <div class="p-5 pb-0">

                <div class="poisk">
                    <input type="text" v-model="serch" class="form-control" placeholder="Поиск рецепта" />
                    <button @click="filter" class="btn btn-outline-warning" type="button">
                        <i class="bi bi-search"></i>
                        Поиск
                    </button>
                </div>

        </div>
        <div>
            <select v-model="selectSort" @change="changeSort" class="form-select w-25 float-end">
                <option v-for="(sort, key) in sortOptions" :value="key">{{ sort.text }}</option>
            </select>
        </div>
        <div class="main">
            <div class="setting">
                <div class="exspress block">Выбрать категорию</div>
                <div class="block" v-for="category in categories">
                    <input class="form-check-input" v-model="checkedCategories" :value="category.id" type="checkbox" :id="category.id" />
                    <label class="form-check-label" :for="category.id"> {{ category.name }} </label>
                </div>

                <div class="exspress block">Выбрать время приготовления</div>
                <div class="block">
                    <input type="radio" value="[0, 30]" v-model="checkedTime" />
                    <h5>До 30 мин</h5>
                </div>
                <div class="block">
                    <input type="radio" value="[30, 60]" v-model="checkedTime" />
                    <h5 class="h5">От 30 мин до 60 мин</h5>
                </div>
                <div class="block">
                    <input type="radio" value="[60, 1000]" v-model="checkedTime" />
                    <h5 class="h5">От 60 мин</h5>
                </div>

                <div class="exspress block">Уровень сложности</div>
                <div class="block">
                    <input type="radio" v-model="checkedDif" name="difficulty" value="легкий" />
                    <h5>Легкий</h5>
                </div>
                <div class="block">
                    <input type="radio" v-model="checkedDif" name="difficulty" value="нормальный" />
                    <h5>Нормальный</h5>
                </div>
                <div class="block">
                    <input type="radio" v-model="checkedDif" name="difficulty" value="тяжелый" />
                    <h5>Тяжелый</h5>
                </div>
                <div class="block">
                    <button type="button" id="ok" @click="filter" class="btn btn-warning">OK</button>
                    <button type="button" id="ok" @click="claerFilter" class="btn btn-warning">Сбросить</button>
                </div>
            </div>
            <div class="catalog">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <template v-for="recipe in recipes.data">
                        <ReceptComponent
                            :server="server"
                            :recipe="recipe"
                            :isUser="isUser"
                            :PUBLIC="PUBLIC"
                            :changePage="changePage"
                            :pageID="recipe.id"
                        />
                    </template>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center m-3">
            <button class="btn btn-outline-warning m-2" @click="getRecipes(recipes.current_page - 1)" :disabled="recipes.current_page == 1">
                Назад
            </button>
            <button
                class="btn btn-outline-warning m-2"
                @click="getRecipes(recipes.current_page + 1)"
                :disabled="recipes.current_page == recipes.last_page"
            >
                Далее
            </button>
        </div>
    </main>
</template>
<script>
import MainHeaderComponent from '@/components/MainHeaderComponent.vue';
import ReceptComponent from '@/components/ReceptComponent.vue';

export default {
    name: 'HomePage',
    props: ['changePage', 'server', 'isUser', 'PUBLIC', 'user'],

    components: {
        ReceptComponent,
        MainHeaderComponent,
    },
    data() {
        return {
            page: 1,
            serch: '',
            recipes: {},
            favorites: [],
            categories: [],
            sort: {
                field: 'created_at',
                by: 'desc',
            },
            selectSort: '',
            sortOptions: [
                { text: 'сначала новые', field: 'created_at', by: 'desc' },
                { text: 'сначала старые', field: 'created_at', by: 'asc' },
                { text: 'По времини по возрастанию', field: 'cook_time', by: 'asc' },
                { text: 'По времини по убыванию', field: 'cook_time', by: 'desc' },
            ],
            isfilter: false,
            checkedCategories: [],
            checkedTime: '',
            checkedDif: '',
        };
    },
    mounted() {
        this.getRecipes();
    },

    methods: {
        filter() {
            this.isfilter = true;
            this.getRecipes();
        },
        getRecipes(page = 1) {
            let formdata = new FormData();
            formdata.append('sort', JSON.stringify(this.sort));
            if (this.isfilter) {
                if (this.checkedCategories.length > 0) {
                    formdata.append('categories', JSON.stringify(this.checkedCategories));
                }
                if (this.checkedDif) {
                    formdata.append('difficulty', this.checkedDif);
                }
                if (this.checkedTime) {
                    formdata.append('checkedTime', this.checkedTime);
                }
                if (this.serch) {
                    formdata.append('serch', this.serch);
                }
            }

            this.server('recipesHome?page=' + page, 'POST', formdata)
                .then((result) => {
                    this.recipes = result;
                    this.page = result.page;
                    this.server('category').then((result) => {
                        this.categories = result;
                    });
                })
                .catch((error) => console.log('error', error));
        },

        changeSort(event) {
            this.sort.field = this.sortOptions[event.target.value].field;
            this.sort.by = this.sortOptions[event.target.value].by;
            this.getRecipes();
        },
        claerFilter() {
            this.checkedTime = '';
            this.checkedDif = '';
            this.checkedCategories = [];
        },
    },
};
</script>
