<template>
    <v-container grid-list-sm>
        <v-content>
            <v-layout mb-3>
                <v-btn color="#ff3c38" dark raised round ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
            </v-layout>
            <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!cuisine"></v-progress-circular>
            <v-layout row wrap v-if="cuisine">
                <v-flex xs12 sm8>
                    <v-layout row wrap px-3>
                        <v-flex xs12>
                            <v-card class="pa-3" raised elevation="12" ripple min-height="350px" light>
                                <v-container grid-list-sm>
                                    <v-layout row wrap>
                                        <v-flex xs12 sm8>
                                            <v-img :src="'/images/assets/cuisines/' + cuisine.picture"></v-img>
                                            
                                        </v-flex>
                                        <v-flex xs12 sm4 class="pa-4">
                                            <h5 class="body-2">{{ cuisine.name }} - &#8358;{{ cuisine.price }}</h5>
                                            <v-chip outline>{{ cuisine.category.name }}</v-chip>
                                            <h5 class="body-1 grey--text">{{ cuisine.restaurant.name }}</h5>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12 sm4>
                    <v-layout row wrap px-3>
                        <v-flex xs12 text-xs-center>
                            
                            <v-card raised elevation="12" ripple min-height="550px" light>
                                <v-layout row wrap>
                                    <v-flex xs10 offset-xs1>
                                        <v-card-title justify-center>
                                            <span class="subheading text-center">Similar Cuisines</span>
                                        </v-card-title>
                                        <v-progress-circular indeterminate color="coral" :width="2" :size="30" v-if="similar.length == 0"></v-progress-circular>
                                        <div v-if="similar.length > 0">
                                            <v-card v-for="cuis in similar" :key="cuis.id" class="mb-3 sim_cuis" height="80" :to="{path: '/cuisine/' + cuis.id + '/' + cuis.slug}">
                                                <!-- <router-link :to="{path: '/cuisine/' + cuis.id + '/' + cuis.name}" class="sim_cuis"> -->
                                                    <div class="pix">
                                                        <img :src="'/images/assets/cuisines/' + cuis.picture">
                                                    </div>
                                                    <div class="details">
                                                        <h5>{{ cuis.name }} - &#8358;{{ cuis.price }}</h5>
                                                        <h5>{{ cuis.restaurant && cuis.restaurant.name }}</h5>
                                                    </div>
                                                <!-- </router-link> -->
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
            id: this.$route.params.id,
            name: this.$route.params.name,
            cuisine: null,
            picture: null,
            similar: []
        }
    },
    methods: {
        getCuisine(){
            axios.get('/fetch_cuisinebyid/' + this.id).then((res) =>{
                this.cuisine = res.data
                let rez = res.data
                //get similar cuisines
                let vm = this
                axios.get('/fetch_similarcuisine/'+ res.data.category_id).then((res) => {
                    let similar = res.data.filter((cuis) => cuis.id !== rez.id)
                    this.similar = similar
                })
            })
        },
    },
    mounted() {
        this.getCuisine()
        // this.getSimilarCuisine()
    },
}
</script>

<style lang="scss" scoped>
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
</style>
