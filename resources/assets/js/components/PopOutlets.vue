<template>
    <v-container>
        <v-content>
            <v-layout>
                <v-flex xs12 sm6 offset-sm3>
                    <h2 class="text-center">Popular Outlets</h2>
                    <v-carousel light height="300" max="100" cycle>
                        <v-carousel-item v-for="(item,i) in images" :key="i" :src="'../images/assets/cuisines/' + item"></v-carousel-item>
                    </v-carousel>
                </v-flex>
            </v-layout>
        </v-content>
    </v-container>
</template>

<script>
export default {
    props: ['outlets'],
    data() {
        return {
            images: []
        }
    },
    mounted() {
        axios.get('/get_carousel_imgs').then((res) => {
            res.data.forEach(el => {
                this.images.push(el.picture)
            })
            // console.log(this.images)
        })
    },
}
</script>

<style lang="scss" scoped>
    h2{
       margin-bottom: 1.5rem; 
       font-size: 30px;
       color: #424242;
       font-weight: 300;
    }  
</style>
