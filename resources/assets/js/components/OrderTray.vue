<template>
    <div class="tray_wrap">
       <div class="tray" v-if="orders">
            <h4 class="text-center">Order Tray</h4>
            <v-divider></v-divider>
            <table class="table table-condensed table-hover table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Item({{ orders.length }})</th>
                        <th>Portion</th>
                        <th>Price(&#8358;)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in orders" :key="index">
                        <td>{{ item.name }}</td>
                        <td>{{ item.portion }} X {{ item.price | price }}</td>
                        <td>{{ item.cost | price }}</td>
                        <td><a href="" @click.prevent="delOrder(index)"><v-icon small color="#ff3c38">delete_outline</v-icon></a></td>
                    </tr>
                    <tr>
                        <td colspan="2">Order Total</td>
                        <td>{{ orderTotal | price}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Delivery Charges</td>
                        <td>{{ charges | price }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:right">Total(&#8358;)</th>
                        <td>{{ grandTotal | price }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mb-3">
                <a href="/checkout" class="btn btn_out">Proceed to Checkout</a>
                <!-- <router-link class="btn btn_out" :to="{name: 'checkout', params:{order:orders, charges: charges, total:total}}">Proceed to Checkout</router-link> -->
            </div>
        </div> 
        <div v-else class="tray text-center">
            <p>Your tray is empty</p>
        </div>
    </div>
</template>

<script>
export default {
    // props: ['orders'],
    data() {
        return {
            items: [],
            cuisines: [],
            instruction: '',
            userLoc: null,
            isAuth: false
        }
    },
    computed: {
        orders(){
            return this.$store.getters.getOrders
        },
        orderTotal(){
           return this.$store.getters.getTotalCost
        },
        charges(){
            return this.$store.getters.getCharges
        },
        grandTotal(){
            return this.orderTotal + this.charges
        },
    },
    methods: {
        delOrder(index){
            this.orders.splice(index, 1)
            this.$store.commit('update_order', this.orders)
        },
        getUserLoc(){
            axios.get('/get_user_loc').then((res) => {
                // this.userLoc = res.data
                this.$store.commit('user_loc', res.data)
            })
        },
    },
    mounted() {
        // this.getUserLoc()
        
        console.log(this.orders)

        //check if logged in
        if(window.Laravel.auth){
            this.isAuth = true
        }
    },
}
</script>

<style>
    .tray{
        padding: 12px;
        margin: 1.7rem 1.5rem;
        background: #fff;
        border: 1px solid #fff;
        transition: .3s cubic-bezier(.25,.8,.5,1);
        color: rgba(0,0,0,.87);
        box-shadow: 0 3px 5px -1px rgba(0,0,0,.2),0 5px 8px 0 rgba(0,0,0,.14),0 1px 14px 0 rgba(0,0,0,.12)!important;
        overflow: hidden;
        border-radius: 4px;
    }
</style>
