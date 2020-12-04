<template>
 <div class="col-lg-13 mb-4 mb-xl-0 col-xl-3">
    <div class="wrap-icon">
        <span class="icon icon-room"></span>
        <input type="text" placeholder="Location" name="city" v-model="query" v-on:keyup="autoComplete" class="form-control rounded">
    </div>
    <div v-if="displayResults" id="results">
        <div v-for="result in results.slice(0, 3)">
            <span v-text="result.city" class="item" @click="fillLocation(result.city)"></span>
        </div>
    </div>
</div>
</template>
<script>
export default{
    data(){
        return {
            query: new URL(location.href).searchParams.get('city'),
            results: [],
            displayResults: false
        };
    },

    methods: {
        autoComplete(){
            if(this.query.length > 2){
                axios.get('/getlocation',{params: {location: this.query}})
                .then(response => {
                    this.results = response.data;
                    this.displayResults = true;
                });
            }
        },

        fillLocation(city) {
            this.query = city;
            this.displayResults = false;
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
    span:hover {
        background-color: #30e3ca;
    }
</style>
