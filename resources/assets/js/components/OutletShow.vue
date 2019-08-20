<template>
    <v-container grid-list-sm>
        <v-content>
            <v-layout mb-3>
                <v-btn color="#ff3c38" dark raised round ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
            </v-layout>
            <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!outlet"></v-progress-circular>
            <v-layout row wrap v-if="outlet" class="outlet_wrap">
                <v-flex xs12 sm7>
                    <v-layout row wrap class="px-2">
                        <v-flex xs12>
                            <v-card class="main" raised elevation="12" ripple max-height="400px" light>
                                <v-container grid-list-sm>
                                    <v-layout row wrap>
                                        <v-flex xs12 sm7>
                                            <v-img v-if="outlet.picture" :src="`/images/assets/outlets/${outlet.picture}`" class='img' transition="scale-transition"></v-img>
                                            <v-icon v-else size="10rem" color="grey lighten-2" class="pl-5">local_dining</v-icon>
                                        </v-flex>
                                        <v-flex xs12 sm5 class="mt-3">
                                            <h5 class="body-2">{{ outlet.name }}</h5>
                                            <h5>12, Airport Road, Warri.</h5>
                                            <v-rating readonly small dense color="#ff3c38" :value="ratings"></v-rating>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                        <v-flex xs12 mt-3>
                            <v-card raised light ripple elevation="12" min-height="200" >
                                <v-card-title class="justify-center mb-0">
                                    <div class="subheading">Reviews ({{ reviews.length }})</div>
                                </v-card-title>
                                <v-card-text v-if="reviews.length > 0" class="reviews">
                                    <div v-for="(review, index) in reviews" :key="review.id">
                                        <div v-if="index < displ">
                                            <div class="body-2">{{ review.comments }}</div>
                                            <div class="body-3 grey--text">{{ review.user.name }} @ {{ review.reviewed_date }}</div>
                                       <hr> </div>
                                    </div>
                                    <v-btn v-if="displ == 3" outline color="#ff3c38" @click.prevent="loadMore">All Reviews</v-btn>
                                </v-card-text>
                                <v-card-text v-else>
                                    <div class="body-2">No review yet for this outlet</div>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12 sm5>
                    <v-layout row wrap px-3>
                        <v-flex xs12>
                            <v-card raised elevation="12" ripple light class="py-4">
                                <v-layout row wrap>
                                    <v-flex xs10 offset-xs1>
                                        <v-card-title class="justify-center sidebar">
                                            <span class="subheading text-center">Cuisines by {{ outlet.name }}</span>
                                        </v-card-title>
                                        <!-- <v-progress-circular indeterminate color="coral" :width="2" :size="30" v-if="minCuisines.length == 0"></v-progress-circular> -->
                                        <div v-if="cuisines.length === 0">No cuisines for this outlet</div>
                                        <div v-if="minCuisines.length > 0">
                                            <v-card v-for="cuis in minCuisines" :key="cuis.id" class="mb-3 sim_cuis" height="80" :to="{path: '/cuisine/' + cuis.id + '/' + cuis.slug}" hover> 
                                                <div class="pix">
                                                    <img v-if="cuis.picture" :src="'/images/assets/cuisines/' + cuis.picture">
                                                    <v-icon v-else size="4rem" color="grey lighten-2">local_dining</v-icon>
                                                </div>
                                                <div class="details">
                                                    <h5>{{ cuis.name }} - &#8358;{{ cuis.price }}</h5>
                                                    <h5>{{ cuis.restaurant && cuis.restaurant.name }}</h5>
                                                </div>
                                            </v-card>
                                        </div>
                                        <span class="all_cuis align-center" v-if="!showAllCuis">
                                            <v-btn round dark color="#ff3c38" @click.prevent="seeAll">See all</v-btn>
                                        </span>
                                        <span v-if="showAllCuis">
                                            <v-card v-for="cuis in cuisines" :key="cuis.id" class="mb-3 sim_cuis" height="80" :to="{path: '/cuisine/' + cuis.id + '/' + cuis.slug}" hover> 
                                                <div class="pix">
                                                    <img v-if="cuis.picture" :src="'/images/assets/cuisines/' + cuis.picture">
                                                    <v-icon v-else size="4rem" color="grey lighten-2">local_dining</v-icon>
                                                </div>
                                                <div class="details">
                                                    <h5>{{ cuis.name }} - &#8358;{{ cuis.price }}</h5>
                                                    <h5>{{ cuis.restaurant && cuis.restaurant.name }}</h5>
                                                </div>
                                            </v-card>
                                        </span>
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
            outlet: null,
            cuisines: [],
            minCuisines: [],
            showAllCuis: false,
            ratings: null,
            reviews: [],
            displ: 3
        }
    },
    methods: {
        getOutletDetails(){
            axios.get(`/fetch_outletbyid/${this.id}`).then(res => {
                this.outlet = res.data
                // console.log(res.data)
                //get reviews
                const sorted = res.data.cuisine_review.sort((a, b) => {
                    if(a.reviewed_date > b.reviewed_date) return -1
                    
                    if(a.reviewed_date < b.reviewed_date) return 1

                    return 0
                })
                this.reviews = sorted

                for (let i = 0; i < res.data.cuisine.length; i++) {
                    if(i < 3){
                        this.minCuisines.push(res.data.cuisine[i])
                    }else{
                        this.cuisines.push(res.data.cuisine[i])
                    }
                }
            })
        },
        seeAll(){
            this.showAllCuis = true
        },
        getOutletRatings(){
            axios.get(`/fetch_outletratings/${this.id}`).then((res) => {
                // console.log(res.data)
                const ratings = []
                for (let i = 0; i < res.data.length; i++) {
                    ratings.push(res.data[i].ratings)
                }
                const sum = ratings.reduce((a, b) => {
                    return parseFloat(a) + parseFloat(b)
                }, 0)
                this.ratings = Math.round(sum / res.data.length)
            })
        },
        loadMore(){
            this.displ = this.reviews.length
        }
    },
    mounted() {
        this.id = this.$route.params.id;
        this.getOutletDetails()
        this.getOutletRatings()
    },
}
</script>

<style lang="scss" scoped>
    .outlet_wrap{
        .main{
            // display: 
            .img{
                height: 20rem;
                width: 20rem;
            }
        }
        .revw{
            padding: .7rem;

            &:not(:last-child){
                border-bottom: 1px solid rgb(216, 216, 216);
            }
        }
        .all_cuis{
            padding: 1rem;
            display: flex;
            justify-content: center;
        }
    }
    .sim_cuis{
        text-decoration: none;
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100%;
        padding-left: 1rem;

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
</style>
