<template>
    <v-layout>
        <v-flex xs12 sm10 offset-sm1 class="featured">
            <h2 class="text-center">Featured Outlets</h2>
            <div class="logo_grid">
                <div class="img" v-for="outlet in outlets" :key="outlet.id" >
                    <img :src="`./images/assets/outlets/${outlet.picture}`" />
                </div>
            </div>
        </v-flex>
  </v-layout>
</template>

<script>
export default {
    props: ['outlets']
}
</script>

<style lang="scss" scoped>
    
</style>

