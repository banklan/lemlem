<template>
    <v-layout>
        <v-flex xs10 offset-xs1 class="my-3">
            <v-container grid-list-xl text-xs-center>
                <h2>Popular cuisines</h2>
                <v-layout row wrap my-4 pa-3>
                    <v-flex xs12 sm6 md4 v-for="cuis in cuisines" :key="cuis.id">
                        <v-card hover ripple raised height="350px" light elevation="14" class="pa-3">
                            <v-img height="160px" :src="`./images/assets/cuisines/${cuis.picture}`"></v-img>
                            <v-card-title class="primary-title justify-center">
                                <div>
                                    <h4 class="subheading">{{ cuis.name }} - &#8358;{{ cuis.price }}</h4>
                                    <v-rating dense color="success" hover ripple small empty-icon="$vuetify.icons.ratingEmpty" half-increments v-model="ratings"></v-rating>
                                    <span>{{ cuis.restaurant.name }}</span>
                                </div>
                            </v-card-title>
                            <v-card-actions>
                                <v-chip outline>{{ cuis.category.name }}</v-chip>
                                
                                <v-spacer></v-spacer>
                                <v-icon outline>favorite</v-icon> 250
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    // props: ['cuisines'],
    data() {
        return {
            cuisines: [],
            ratings: 3
        }
    },
    methods: {
        getPopCuisines(){
            axios.get('/fetch_popcuisines').then((res) => {
                this.cuisines = res.data
                    console.log(res.data)
                })
            }
    },
    mounted() {
        this.getPopCuisines()
        console.log(this.ratings)
    },
}
</script>

<style>

</style>
