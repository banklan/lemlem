<template>
    <v-app light>
        <v-content>
            <v-container>
                <v-layout row wrap>
                    <v-flex xs10>
                        <v-layout wrap justify-center>
                            <v-flex xs12 sm5 d-flex>
                                <v-select color="primary" dense :items="cities" item-text="name" item-value="id" label="Choose your City" v-model="city" @change="fetchOutlets"></v-select>
                            </v-flex>
                            <v-flex xs12 sm4 d-flex class="ml-2">
                                <v-select color="primary" dense :items="outlets" item-text="name" item-value="id" label="Choose Outlet" v-model="outlet"></v-select>
                            </v-flex>
                            <v-flex xs12 sm2 d-flex>
                                <v-btn large color="coral white--text" class="fetch" ripple rounded @click.prevent="fetchCuisines" :disabled="loading"><i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Fetching...' : 'Search' }}</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                    <v-flex xs9 md2 px-2>
                        <v-text-field v-model="q" placeholder="Search for meal/outlet" prepend-inner-icon="search" @keyup.enter="search"></v-text-field>
                    </v-flex>
                    <v-flex xs3 class="hidden-sm-and-up">
                        <v-btn color="coral white--text" class="fetch" ripple rounded @click.prevent="search">Go</v-btn>
                    </v-flex>
                </v-layout>
                <v-layout row class="text-xs-center" v-if="showList">
                    <v-flex xs6 offset-xs3 sm2 offset-sm5 mt-3 mb-2>
                        <v-select color="primary" dense :items="categories" item-text="name" item-value="id" label="Choose Category" v-model="cat" @change="filterCuisines"></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 sm8>
                        <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="loading"></v-progress-circular>
                        <cuisines-list v-if="showList" :cuisines = "cuisines"></cuisines-list>
                    </v-flex>
                    <v-flex xs12 sm4 v-if="orders.length !== 0" transition="scale-transition">
                        <order-tray :orders="orders"></order-tray>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            cities: [],
            outlets: [],
            cuisines: [],
            city: null,
            outlet: null,
            loading: false,
            showList: false,
            categories: [],
            cat: null,
            q: '',
            errorFile: []
        }
    },
    computed: {
        orders(){
            return this.$store.getters.getOrders
        }
    },
    methods: {
        getCities(){
            axios.get('/get_cities').then((res)=> {
                res.data.forEach(el => {
                    this.cities.push(el)
                })
            })
        },
        fetchOutlets(){
            if(this.city !== null){
                axios.get(`/fetch_outlets/${this.city}`).then((res)=>{
                    // res.data.forEach(el => {
                    //     this.outlets.push(el)
                    // })
                    this.outlets = res.data
                }) 
            }
        },
        fetchCuisines(){
            if(this.outlet !== null){
                this.loading = true
                this.showList = true

                axios.get(`/fetch_meals/${this.outlet}`).then((res) =>{
                    this.cuisines = res.data
                    this.loading = false
                })
            }
        },
        fetchCategories(){
            axios.get('/fetch_categories').then((res) => {
                this.categories = res.data
                // console.log(res.data)
            })
        },
        filterCuisines(){
            if(this.cat !== null){
               let filtered = this.cuisines.filter((el) => el.category_id == this.cat)
               this.cuisines = filtered
            }
        },
        search(){
            if(this.q !== ''){
                this.loading = true
                axios.post('/search_cuisine', {
                    q: this.q
                }).then((res) => {
                    this.loading = false
                    this.q = ""
                    // console.log(res.data)
                    this.showList = true
                    this.cuisines = res.data
                }).catch((err) => {
                    this.loading = false
                    this.errorFile = "Search failed. Please try again"
                })
            }
        }
    },
    mounted() {
        this.getCities();
        this.fetchCategories()
    },
}
</script>

<style lang="scss" scoped>
    .fetch{
        border-radius: 6px;
        &:hover{
            background: #E53935 !important;
        }
    }
</style>
