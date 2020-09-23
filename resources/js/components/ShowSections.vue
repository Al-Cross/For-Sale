<template>
    <div>
        <div class="row align-items-stretch no-gutters d-md-flex justify-content-center">
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-3 d-block" v-for="category in categories">
                <div>
                    <a href="#" class="popular-category h-100" @click="fillTable(category)">
                        <span class="icon"><span :class="setIcon(category.name)"></span></span>
                        <span class="caption mb-2 d-block" v-text="category.name"></span>
                        <span class="number">3,921</span>
                    </a>
                </div>
            </div>
        </div>
        <div v-if="showTable">
            <table class="w-100">
                <thead>See all in > <a href="#" v-text="category.name"></a></thead>
                <hr>
                <tbody class="d-md-flex justify-content-between">
                    <tr v-for="section in sections">
                        <td><a :href="'/' + category.slug + '/' + section.slug" v-text="'>' + section.name"></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['categories'],

    data() {
        return {
            sections: {},
            category: {},
            showTable: false
        };
    },

    methods: {
        fillTable(category) {
            axios.get('/', {
                params: {"id": category.id}
            })
                .then(response => this.sections = response.data);

            this.category = category;
            this.showTable = true;

            setTimeout(function () {
                window.scrollTo(0, 500);
            },2);
        },

        setIcon(name) {
            var icon;
            switch(name) {
                case 'Electronics':
                    icon = 'flaticon-innovation';
                    break;
                case 'Fashion' :
                    icon = 'flaticon-clothes';
                    break;
                case 'Animals':
                    icon = 'flaticon-house';
                    break;
                case 'Cars':
                    icon = 'flaticon-car';
                    break;
                case 'Real Estate':
                    icon = 'flaticon-house';
                    break;
                case 'Tools And Equipment':
                    icon = 'flaticon-bunk-bed';
                    break;
                case 'Services':
                    icon = 'flaticon-pizza';
            }

            return icon;
        }
    }
};
</script>
