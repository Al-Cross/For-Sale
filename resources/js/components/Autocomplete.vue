<template>
 <div class="col-lg-13 mb-4 mb-xl-0 col-xl-3">
    <div class="wrap-icon">
        <span class="icon icon-room"></span>
        <input type="text" placeholder="Location" name="city" v-model="query" v-on:keyup="autoComplete" class="form-control rounded">
    </div>
    <small v-if="validationMessage" class="text-danger position-absolute" style="left: 30%" v-text="validationMessage"></small>
    <div v-if="displayResults" id="results">
        <div v-for="result in results.slice(0, 3)">
            <span v-text="result.city" class="item" @click="fillLocation(result.city)"></span>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['errors', 'selectedCity'],

    data() {
        return {
            query: this.prefill(),
            results: [],
            displayResults: false,
            validationMessage: false
        };
    },

    mounted() {
        if (!this.selectedCity) {
             if (Object.keys(this.errors).length !== 0) {
                this.validationMessage = this.errors.city[0];
            }
        }

        if (this.query == '') {
            document.getElementById('distance').disabled = true;
        }
    },

    methods: {
        autoComplete(){
            if(this.query.length > 2){
                axios.get('/getlocation',{params: {location: this.query}})
                .then(response => {
                    this.results = response.data;
                    this.displayResults = true;
                });

                document.getElementById('distance').disabled = false;
            } else {
                document.getElementById('distance').disabled = true;
            }
        },

        fillLocation(city) {
            this.query = city;
            this.displayResults = false;
            document.getElementById('distance').disabled = false;
        },

        prefill() {
            return this.selectedCity ? this.selectedCity : new URL(location.href).searchParams.get('city');
        }
    }
 };
</script>

<style>
    #results {
        position: absolute;
    }
    .item {
        display: block;
        padding: 12px 70px;
        margin-bottom: -1px;
        border: 1px solid #ddd;
        line-height: 1em;
        background-color: white;
        border-radius: 5px;
    }
</style>
