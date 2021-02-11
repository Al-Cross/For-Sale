<template>
    <div id="category">
        <div class="row align-items-stretch no-gutters d-md-flex justify-content-center">
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-3 d-block" v-for="category in categories">
                <div>
                    <a href="#category" class="popular-category h-100" @click="fillTable(category)">
                        <span class="icon"><span :class="setIcon(category.name)"></span></span>
                        <span class="caption mb-2 d-block" v-text="category.name"></span>
                        <span class="number" v-text="category.ads_count"></span>
                    </a>
                </div>
            </div>
        </div>
        <div v-if="showTable">
            <table class="w-100">
                <thead>See all in > <a :href="'/' + category.slug" v-text="category.name"></a></thead>
                <hr>
                <tbody class="d-md-flex justify-content-between">
                    <div class="col">
                        <tr v-for="section in sliced[0]">
                            <td class="pb-2"><a :href="'/' + category.slug + '/' + section.slug" v-text="'>' + section.name"></a></td>
                        </tr>
                    </div>
                    <div class="col">
                        <tr v-for="section in sliced[1]">
                            <td class="pb-2"><a :href="'/' + category.slug + '/' + section.slug" v-text="'>' + section.name"></a></td>
                        </tr>
                    </div>
                     <div class="col">
                        <tr v-for="section in sliced[2]">
                            <td class="pb-2"><a :href="'/' + category.slug + '/' + section.slug" v-text="'>' + section.name"></a></td>
                        </tr>
                    </div>
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
            showTable: false,
            sliced: [[], [], []]
        };
    },

    watch: {
        sections() {
            this.sliced = [[], [], []];
            var itemsInArray = Math.ceil(this.sections.length / 3);

            for (var subArray = 0; subArray < 3; subArray++) {
                for (var i = 0; i < itemsInArray; i++) {
                    let value = Object.values(this.sections)[i + subArray * itemsInArray];
                    if(!value) continue;
                    this.sliced[subArray].push(value);
                }
            }
        }
    },

    methods: {
        fillTable(category) {
            axios.get('/', {
                params: {"id": category.id}
            })
            .then(response => {
                this.sections = response.data;
                this.showTable = true;
                this.category = category;
            });
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
