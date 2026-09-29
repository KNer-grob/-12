<template>
    <div id="main">
        <article>
            {{ pageID }}
            <h1 class="text-warning">{{ pageID ? 'Редактирование' : 'Создание нового' }} рецепта</h1>

            <input type="text" class="vodd mb-4" placeholder="Название рецепта" v-model="title" />
            <p class="red" v-if="errors.title">
                {{ errors.title.join('. ') }}
            </p>
            <input type="text" class="vodd mb-4" placeholder="Описание" v-model="description" />
            <p class="red" v-if="errors.description">
                {{ errors.description.join('. ') }}
            </p>
            <input type="text" class="vodd mb-4" placeholder="Время готовки в минутах" v-model="cook_time" />
            <p class="red" v-if="errors.cook_time">
                {{ errors.cook_time.join('. ') }}
            </p>
            <select class="form-select-warning vodd text-warning mb-4" v-model="difficulty" aria-label="Default select example">
                <option value="легкий">легкий</option>
                <option value="нормальный">нормальный</option>
                <option value="тяжелый">тяжелый</option>
            </select>
            <p class="red" v-if="errors.difficulty">
                {{ errors.unit.join('. ') }}
            </p>
            <div class="mb-3">
                <select :class="{ 'is-invalid': errors.category }" v-model="category" class="form-select-warning vodd text-warning mb-4">
                    <option v-for="category in categories" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <div v-if="errors.category" class="invalid-feedback">
                    {{ errors.category.join('. ') }}
                </div>
            </div>
            <input type="file" class="imageStep text-white" name="file" id="photo" /><br /><br />
            <p class="red" v-if="errors.photo">
                {{ errors.photo.join('. ') }}
            </p>
            <button v-if="pageID" type="button" class="btn btn-outline-warning" @click="addIngridient">Добавить ингредиенты</button>
            <button v-if="pageID" type="button" class="btn btn-outline-warning ms-2" @click="add">Приступить к пошаговому рецепту</button>
        </article>

        <table v-if="pageID" class="table-dark mt-3 table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Название ингредиента</th>
                    <th>Количесвто</th>
                    <th>Единица измерения</th>
                    <th>Инструменты</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, key) in ingridientsRecept">
                    <td>{{ key + 1 }}</td>
                    <td>
                        <select name="" class="form-select" id="" v-model="value.ingridient_id">
                            <option :value="ingridient.id" v-for="ingridient in ingridients">
                                {{ ingridient.name }}
                            </option></select
                        >{{}}
                    </td>
                    <td>
                        <input type="number" class="form-control" v-model="value.quantity" />
                    </td>
                    <td>
                        <span v-if="ingridients[value.ingridient_id]">{{ ingridients[value.ingridient_id].unit }}</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button @click="removeIngridient(key)" class="btn btn-outline-danger">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="13"
                                    height="13"
                                    fill="currentColor"
                                    class="bi bi-trash3-fill"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"
                                    />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mb-3 mt-3">
            <button type="button" class="btn btn-outline-warning" v-if="pageID" @click="saveIngredients">Сахранить ингредиент</button>
        </div>

        <div class="card mb-5 mt-2" v-if="pageID" v-for="(step, key) in steps" :key="key">
            <div class="card-header">
                <button type="button" class="btn btn-outline-danger me-2" @click="remove(key)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path
                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"
                        />
                    </svg></button
                >Шаг {{ key + 1 }}
            </div>
            <div class="cart-body">
                <label :for="'description' + key"> Описание шага </label>
                <textarea class="form-control" :id="'description' + key" v-model="step.description"></textarea>{{ step.json }}
                <div v-if="errors[key]">
                    <div v-if="errors[key][0]">
                        <p class="alert alert-danger" role="alert" v-if="errors[key][0].description" v-html="errors[key][0].description"></p>
                    </div>
                </div>
                <h2>Изображение для шага</h2>

                <input type="file" class="voddFile" :id="'imageStep' + key" />
                <div v-if="errors[key]">
                    <div v-if="errors[key][0]">
                        <p class="alert alert-danger" role="alert" v-if="errors[key][0].image_url" v-html="errors[key][0].image_url"></p>
                    </div>
                </div>
            </div>
            <img v-if="step.image_url" :src="PUBLIC + step.image_url" alt="" srcset="" class="imageStepStep" />
        </div>
        <div class="mb-3 mt-3">
            <button type="button" class="btn btn-outline-warning" v-if="pageID" @click="save">Сохранить шаг</button>
        </div>
        <div>
            <button type="button" class="btn btn-outline-warning" @click="receptadd">{{ pageID ? 'Редактировать' : 'Создать' }} рецепт</button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ReceptAddComponent',
    props: ['server', 'changePage', 'pageID', 'PUBLIC'],
    data() {
        return {
            steps: [],
            title: null,
            cook_time: null,
            description: null,
            photo: null,
            difficulty: 'нормальный',
            category: '',
            categories: [],
            errors: {},
            ingridients: {},
            ingridientsRecept: [],
        };
    },
    mounted() {
        if (this.pageID) {
            this.getRecipe();
            this.stepGet();
            this.getRecipeIngredients();
            console.log('pageID', this.pageID);
        }

        this.getIngridients();

        this.getCategories();
    },

    methods: {
        saveIngredients() {
            let formdata = new FormData();
            formdata.append('all', JSON.stringify(this.ingridientsRecept));
            this.server('saveIngredients/' + this.pageID, 'POST', formdata)
                .then((result) => {
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
        getCategories() {
            this.server('category')
                .then((result) => {
                    this.categories = result;
                })
                .catch((error) => console.log('error', error));
        },
        getRecipeIngredients() {
            this.server('getRecipeIngredient/' + this.pageID).then((result) => {
                this.ingridientsRecept = result;
            });
        },

        addIngridient() {
            this.ingridientsRecept.push({ ingridient_id: 1 });
        },
        removeIngridient(key) {
            this.ingridientsRecept.splice(key, 1);
        },
        stepGet() {
            this.server('step/' + this.pageID)
                .then((result) => {
                    this.steps = result;
                    console.log(result);
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
        getRecipe() {
            this.server('recipe/' + this.pageID)
                .then((result) => {
                    this.title = result.recipe.title;
                    this.cook_time = result.recipe.cook_time;
                    this.photo = result.recipe.photo;
                    this.description = result.recipe.description;
                    this.difficulty = result.recipe.difficulty;
                    this.category = result.recipe.category;
                })
                .catch((error) => console.log('error', error));
        },

        receptadd() {
            let formdata = new FormData();
            if (this.title) formdata.append('title', this.title);
            if (this.cook_time) formdata.append('cook_time', this.cook_time);
            if (this.description) formdata.append('description', this.description);
            if (this.difficulty) formdata.append('difficulty', this.difficulty);
            if (this.category) formdata.append('category', this.category);
            let photo = document.querySelector('#photo');
            if (photo.files[0]) {
                formdata.append('photo', photo.files[0]);
            }

            this.server(this.pageID ? 'recept/' + this.pageID : 'receptadd', 'POST', formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                    if (result.id) {
                        this.changePage('SinglePage', result.id);
                    }
                })
                .catch((error) => console.log('error', error));
        },
        add() {
            this.steps.push({ description: '' });
        },
        remove(key) {
            if (this.steps[key].id) {
                this.server('step/' + this.steps[key].id, 'DELETE')
                    .then(() => {})
                    .catch((error) => console.log('error', error));
            }
            this.steps.splice(key, 1);
        },
        save() {
            this.errors = [];
            this.steps.forEach((el, num) => {
                let form = new FormData();

                if (el.id) {
                    form.append('id', el.id);
                }
                form.append('description', el.description);
                form.append('step_number', num);
                console.log(num);
                if (this.pageID) {
                    form.append('recipe_id', this.pageID);
                }
                let img = document.querySelector('#imageStep' + num);
                if (img.files[0]) {
                    form.append('image_url', img.files[0]);
                }
                // this.data('step','recipe', form  )
                //     .then((result) => {
                // 		console.log(re)
                // })
                // .catch((error) => console.log('error', error));
                this.server('step', 'POST', form)
                    .then((result) => {
                        if (!this.errors[num]) {
                            this.errors[num] = [];
                        }
                        this.errors[num].push(result.errors);
                        console.log(result);
                    })
                    .catch((error) => console.log('error', error));
            });
        },
    },
};
</script>
