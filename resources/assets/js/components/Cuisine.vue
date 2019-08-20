<template>
    <div class="cuisine">
        <div class="img">
            <img src="/images/assets/cuisines/delic.jpg">
        </div>
        <div class="details">
            <router-link :to="{path: '/cuisine/' + cuisine.id + '/' + cuisine.slug}">
                <p><strong>{{ cuisine.name }} - <span class="price">&#8358; {{ cuisine.price | price }}</span></strong></p>
                <p> {{ cuisine.restaurant.opening_hrs }}</p>
                <div class="chip">
                    <v-chip outline>{{ cuisine.category.name }}</v-chip>
                </div>
            </router-link>
        </div>
        <div class="action">
            <select class="form-control" v-model="order.portion">
                <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
            </select>
            <div class="add text-center">
                <button class="btn btn-sm btn-default" type="button" @click="addToTray"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['cuisine'],
    data() {
        return {
            order: {
                id: this.cuisine.id,
                name: this.cuisine.name,
                price: this.cuisine.price,
                portion: 1,
                cost: null
            },
            
        }
    },
    methods: {
        addToTray(){
            this.order.cost = parseFloat(this.order.price) * this.order.portion
            this.$store.commit('add_order', this.order) 
            // console.log(this.order)
        }
    },
}
</script>

<style lang="scss" scoped>
    
</style>

