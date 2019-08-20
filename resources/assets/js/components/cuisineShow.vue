<template>
    <v-container grid-list-sm>
        <v-content>
            <v-layout mb-3>
                <v-btn color="#ff3c38" dark raised round ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
            </v-layout>
            <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!cuisine"></v-progress-circular>
            <v-layout row wrap v-if="cuisine" class="cuisine_wrap">
                <v-flex xs12 sm8>
                    <v-layout row wrap px-3>
                        <v-flex xs12>
                            <v-card class="pa-3 mb-3" raised elevation="12" ripple max-height="500px" light>
                                <v-container grid-list-sm>
                                    <v-layout row wrap>
                                        <v-flex xs12 sm8>
                                            <v-img v-if="cuisine.picture" :src="'/images/assets/cuisines/' + cuisine.picture" height="300" transition="scale-transition"></v-img>
                                            <v-icon v-if="!cuisine.picture" size="10rem" color="grey lighten-2" class="pl-5">local_dining</v-icon>
                                        </v-flex>
                                        <v-flex xs12 sm4 class="pa-4 cuis_det">
                                            <h5 class="body-2">{{ cuisine.name }} - &#8358;{{ cuisine.price | price }}</h5>
                                            <v-chip outline>{{ cuisine.category.name }}</v-chip>
                                            <router-link :to="{path: '/outlets/'+ cuisine.restaurant.id + '/' + cuisine.restaurant.slug}">
                                                <h5 class="body-1 coral--text">{{ cuisine.restaurant.name }}</h5>
                                            </router-link>
                                            <h5 class="body-2 grey--text darken-5">Opening Hrs: {{ cuisine.restaurant.opening_hrs }}</h5>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                            <v-card raised light elevation="12" min-height="200">
                                <v-card-title class="justify-center">
                                    <div class="title">Reviews for {{ cuisine.name }}</div>
                                </v-card-title>
                                <v-card-text v-if="reviews.length > 0">
                                    <div v-for="review in reviews" :key="review.id" class="review">
                                        <div class="body-1">
                                            {{ review.comments }}
                                        </div>
                                        <div class="body-2 grey--text darken-5">{{ review.user && review.user.name }} @ {{ review.reviewed_date }}</div>
                                    </div>
                                </v-card-text>
                                <v-card-text v-else>
                                    <div class="body-1">No reviews for this cuisine</div>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12 sm4>
                    <v-layout row wrap px-3>
                        <v-flex xs12 text-xs-center>
                            <v-card raised elevation="12" ripple light class="py-4">
                                <v-layout row wrap>
                                    <v-flex xs10 offset-xs1>
                                        <v-card-title class="justify-center sidebar">
                                            <span class="subheading text-center">Similar Cuisines</span>
                                        </v-card-title>
                                        <v-progress-circular indeterminate color="coral" :width="2" :size="30" v-if="similar.length == 0"></v-progress-circular>
                                        <div v-if="similar.length > 0">
                                            <v-card v-for="cuis in similar" :key="cuis.id" class="mb-3 sim_cuis" height="80" :to="{path: '/cuisine/' + cuis.id + '/' + cuis.slug}" hover> 
                                                <div class="pix">
                                                    <img v-if="cuis.picture" :src="'/images/assets/cuisines/' + cuis.picture">
                                                    <v-icon v-else size="4rem" color="grey lighten-2">local_dining</v-icon>
                                                </div>
                                                <div class="details">
                                                    <h5>{{ cuis.name }} - &#8358;{{ cuis.price | price }}</h5>
                                                    <h5>{{ cuis.restaurant && cuis.restaurant.name }}</h5>
                                                </div>
                                            </v-card>
                                        </div>
                                        <v-divider></v-divider>
                                        <v-card-title class="justify-center sidebar">
                                            <span class="subheading text-center">Other Cuisines by {{ cuisine.restaurant.name }}</span>
                                        </v-card-title>
                                        <div v-if="sameOutletCuis.length > 0">
                                            <v-card v-for="cuis in sameOutletCuis" :key="cuis.id" class="mb-3 sim_cuis" height="80" :to="{path: '/cuisine/' + cuis.id + '/' + cuis.slug}" hover> 
                                                <div class="pix">
                                                    <img v-if="cuis.picture" :src="'/images/assets/cuisines/' + cuis.picture">
                                                    <v-icon v-else size="4rem" color="grey lighten-2">local_dining</v-icon>
                                                </div>
                                                <div class="details">
                                                    <h5>{{ cuis.name }} - &#8358;{{ cuis.price | price }}</h5>
                                                    <h5>{{ cuis.restaurant && cuis.restaurant.name }}</h5>
                                                </div>
                                            </v-card>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-content>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            name: this.$route.params.name,
            cuisine: null,
            picture: null,
            similar: [],
            sameOutletCuis: [],
            reviews: []
        }
    },
    watch: {
        '$route.params':{
            handler(newVal){
                let id = newVal
                this.getCuisine(id);
                this.getCuisineReviews()
            },
            immediate: true
        }
    },
    methods: {
        getCuisine(id){
            axios.get('/fetch_cuisinebyid/' + this.$route.params.id).then((res) =>{
                this.cuisine = res.data
                let rez = res.data
                //get similar cuisines
                let vm = this
                axios.get('/fetch_similarcuisine/'+ res.data.category_id).then((res) => {
                    let similar = res.data.filter((cuis) => cuis.id !== rez.id)
                    this.similar = similar
                })

                //getcuisines from same outlet
                axios.get('/fetch_mealsfromsameoutlet/' + rez.restaurant_id).then((res) => {
                    this.sameOutletCuis = res.data
                })
            })
        },
        getCuisineReviews(){
            axios.get(`/fetch_cuisine_reviews/${this.$route.params.id}`).then((res) => {
                console.log(res.data)
                this.reviews = res.data
            })
        }
    },
    mounted() {
        this.id = this.$route.params.id;
        // console.log(this.id)
        this.getCuisine()

        this.getCuisineReviews()
    },
}
</script>

<style lang="scss" scoped>
    .cuisine_wrap{
        .cuis_det a{
            color: coral;
            text-decoration: none;
        }

        .sidebar{
            border-bottom: 1px solid rgb(206, 206, 206);
            margin-bottom: 2rem;
        }
        .sim_cuis{
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;

            .pix{
                height: 80% !important;
                flex: 0 1 30%;

                img{
                    height: 60px;
                    width: 60px;
                }
            }
            .details{
                flex: 0 1 70%;
                display: flex;
                flex-direction: column;
            }
        }
        .review{
            padding: 1.5rem;

            &:not(:last-child){
                border-bottom: 1px solid grey;
            }
        }
    }
    
</style>
