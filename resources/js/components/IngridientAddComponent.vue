<template>
    <article >
        <h1 class="text-warning">Создание ингридиентов</h1>
        <input type="text" class="vodd mb-4" v-model="name" placeholder="Название ингредиента" />
        <p class="red" v-if="errors.name">
            {{ errors.name.join('. ') }}
        </p>
        <select class="form-select-warning vodd text-warning mb-4" v-model="unit" aria-label="Default select example">
            <option value="шт">шт</option>
            <option value="кг">кг</option>
            <option value="л">л</option>
        </select>
        <p class="red" v-if="errors.unit">
            {{ errors.unit.join('. ') }}
        </p>
    </article>
    <button type="button" class="btn btn-outline-warning me-2">
        <a href="" @click.prevent="add" class="register-link">{{id ? 'Редактирование' : 'Создание нового' }} рецепта</a>
    </button>


    <table class="table-dark mt-3 table">
        <thead>
            <tr>
                <th>id</th>
                <th>Название ингредиента</th>
                <th>Единица измерения</th>
                <th>Инструменты</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(ingridient, key) in ingridients" :key="key">
                <td>{{ ingridient.id }}</td>
                <td>{{ ingridient.name }}</td>
                <td>{{ ingridient.unit }}</td>
                <td>
                    <div class="btn-group">
                        <button
                            @click="setIngredient(ingridient)"
                            class="btn btn-outline-warning"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="13"
                                height="13"
                                fill="currentColor"
                                class="bi bi-pencil"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"
                                />
                            </svg>
                        </button>
                        <button @click="delIngridient(ingridient.id)" class="btn btn-outline-danger">
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
</template>

<script>
export default {
    name: 'IngridientAddComponent',
    props: ['isUser', 'successUser', 'recipe', 'server', 'user', 'PUBLIC', 'changePage', 'logout' , ],
    data() {
        return {
            name: '',
            unit: 'шт',
            id: '',
            errors: {},
            ingridients: [],
        };
    },
    mounted() {
        this.getIngridients();
        // this.ingridients = [{description: 'шаг 1', image_url:'' },
        //     {description: 'шаг 2', image_url:'' },
        // ];
    },
    methods: {
        getIngridients() {
            this.server('ingridient/')
                .then((result) => {
                    this.ingridients = result;
                    console.log(result);
                })
                .catch((error) => console.log('error', error));
        },
        setIngredient(ingredient) {
            this.id = ingredient.id;
            this.name = ingredient.name;
            this.unit = ingredient.unit;
        },

        add() {
            let formdata = new FormData();
            formdata.append('name', this.name);
            formdata.append('unit', this.unit);
              if (this.id) {
                formdata.append('_method', 'PUT');
            }
            this.server(this.id ? 'ingridient/' + this.id : 'ingridient', 'POST', formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.errors = {};
                        this.name = '';
                        this.unit = 'шт';

                        this.getIngridients();
                        this.id = '';


                    }


                })
                .catch((error) => console.log('error', error));
        },
        delIngridient(id) {
            console.log('DELETE ID:', id);

            this.server('ingridient/' + id, 'DELETE')
                .then(() => {
                    this.getIngridients();
                })
                .catch((error) => console.log('error', error));
        },
    },
};
</script>
