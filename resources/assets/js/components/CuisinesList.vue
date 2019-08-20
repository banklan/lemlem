<template>
    <v-container>
        <v-layout row wrap class="px-3">
            <v-flex xs12>
                <div v-if="cuisines.length > 0">
                    <cuisine-single v-for="cuisine in cuisines" :cuisine="cuisine" :key="cuisine.id" class="single_cuisine"></cuisine-single>
                </div>
                <div v-else class="alert alert-info text-center" style="width: 70%; margin: auto">
                    <p>There are presently no cuisines for the selected outlet</p>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
    
</template>

<script>
export default {
    props: ['cuisines'],
    data() {
        return {
            items: [],
            order: {
                name: '',
                price: '',
                portion: null
            }
        }
    },
    methods: {
        
    },
}
</script>

