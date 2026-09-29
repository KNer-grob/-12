<template>
    <div id="wrapper">
        <!-- Header -->

        <!-- Main -->
        <div id="main" v-if="recipe">
            <!-- recipe -->
            <article class="recipe bg-black">
                <header>
                    <div class="title ms-4">
                        <h2>
                            <a href="#" class="text-white">{{ recipe.title }}</a>
                        </h2>
                    </div>

                </header>
                <span class="image featured ms-4"><img :src="PUBLIC + recipe.photo" /></span>
                <p class="text-white mb-5 ms-4" >
                    {{ recipe.description }}
                </p>
                   <div class="singlRec">
                    <h1 class="text-white">Время приготовления:</h1>
                    <div class="badge text-bg-warning fs-5  text-wrap" >
                        {{ recipe.cook_time }} мин
                    </div>
                </div>

                <div class="singlRec mb-3">
                    <h1 class="text-white">Уровень сложности:</h1>
                    <div class="badge text-bg-warning fs-5  text-wrap">
                        {{ recipe.difficulty }}
                    </div>
                </div>

                <footer>
                    <ul class="stats">

                        <button type="button" class="btn btn-outline-warning" v-if="isAdmin">
                            <a href="" @click="setActive('add')" @click.prevent="changePage('AdminPage', recipe.id)">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
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
                            </a>
                        </button>
                    </ul>
                </footer>

            </article>
            <table class="table-dark mt-3 table" v-if="isUser">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название ингредиента</th>
                        <th>Количесвто</th>
                        <th>Единица измерения</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, key) in ingridientsRecept">
                        <td>{{ key + 1 }}</td>
                        <td>
                            <option >
                                {{ ingridients[value.ingridient_id].name }}
                            </option>
                        </td>
                        <td>
                            {{ value.quantity }}
                        </td>
                        <td>
                            <span v-if="ingridients[value.ingridient_id]">{{ ingridients[value.ingridient_id].unit }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination" v-if="isUser">
                    <li class="page-item" v-for="st in steps">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="changeStep(st.step_number)"
                            :class="{ active: step == st.step_number, 'bg-warning text-dark': step == st.step_number }"
                            >{{ st.step_number + 1}}</a
                        >
                    </li>
                </ul>
            </nav>
            <div class="conteyner">
                <div class="card conteynerStep mb-5 mt-2" v-if="steps[step]">
                    <div class="card-header">Шаг {{ step + 1 }}</div>
                    <div class="cart-body">
                     {{ steps[step].description }}
                       
                    </div>
                    <img v-if="steps[step].image_url" :src="PUBLIC + steps[step].image_url" class="imageStepStep" />
                </div>
            </div>

            <div class="recipe bg-black">
                <section class="comments" v-if="isUser">
                    <h3 class="text-white">Коментарий</h3>

                    <textarea class="text-white" v-model="comment"></textarea><br />
                    <button type="submit" class="btn btn-warning h-25 text-white" @click="addComment">Добавить коментарий</button>
                    <p class="red" v-if="errors.comment">
                        {{ errors.comment.join('. ') }}
                    </p>
                </section>

                <article class="comment" v-for="value in comments">
                    <div class="comment-autor">
                        <a href="#" @click.prevent="changePage('UserPage', recipe.user_id)"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="32"
                                height="32"
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

                        <a href="#" @click.prevent="changePage('UserPage', recipe.user_id)">{{ value.user.name }}</a>
                    </div>
                    <p>{{ value.comment }}</p>
                </article>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SinglePage',
    props: ['server', 'pageID', 'PUBLIC', 'changePage', 'isUser'],
    data() {
        return {
            recipe: null,
            comment: null,
            comments: [],
            errors: {},
            isAdmin: false,
            isLike: false,
            steps: [],
            ingridients: [],
            ingridientsRecept: [],
            step: 1,
        };
    },
    mounted() {
        if (this.pageID) {
            this.getRecipe();
            console.log('pageID', this.pageID);
        }
        this.stepGet();
        this.getIngridients();
        this.getRecipeIngredients();
    },
    methods: {
        setActive(active) {
            this.active = active;
            localStorage.setItem('adminBlock', active);
        },
        changeStep(step) {
            // console.log(step)
            let formdata = new FormData();
            formdata.append('step_number', step);
            if (this.isUser) {
                this.server('changeStep/' + this.recipe.id, 'POST', formdata)
                    .then((result) => {
                        console.log(result);

                        this.step = step;
                    })
                    .catch((error) => console.log('error', error));
            } else {
                this.step = step;
            }
        },
        // likeClick() {
        //     if (!this.isUser) {
        //         alert['Авторизуйтесь'];
        //     } else {
        //         this.server('like/' + this.pageID)
        //             .then((result) => {
        //                 console.log(result.like_count);
        //                 // this.recipe.likes_count = result.like_count;
        //                 // this.isLike = result.isLike;
        //             })
        //             .catch((error) => console.log('error', error));
        //     }
        // },
        stepGet() {
            this.server('step/' + this.pageID)
                .then((result) => {
                    this.steps = result;
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
        getRecipeIngredients() {
            this.server('getRecipeIngredient/' + this.pageID).then((result) => {
                this.ingridientsRecept = result;
            });
        },
        getRecipe() {
            this.server(this.isUser ? 'recipeUser/' + this.pageID : 'recipe/' + this.pageID)
                .then((result) => {
                    console.log(result);
                    this.recipe = result.recipe;
                    this.comments = result.comments;
                    this.isAdmin = result.isAdmin;
                    this.step = result.stepUser;
                })
                .catch((error) => console.log('error', error));
        },
        getIngridients() {
            this.server('ingridient/')
                .then((result) => {
                    this.ingridients = result;
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
        addComment() {
            let formdata = new FormData();
            if (this.comment) formdata.append('comment', this.comment);
            this.server('comment/' + this.pageID, 'POST', formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.getRecipe();
                    }
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
    },
};
</script>
