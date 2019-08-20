<template>
   <div>
       <link-tab></link-tab>
       <v-container grid-list-md text-xs-center>
            <v-layout row wrap class="justify-space-between mt-3">
                <v-flex xs12 sm8>
                    <v-card class="pa-4" raised elevation="20" light min-height="350">
                        <v-card-text>
                            <p class="text-xs-center subheading">My Orders</p>
                            <table class="table table-condensed table-striped table-hover table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>No of Items</th>
                                        <th>Amount(&#8358;)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order, index) in orders" :key="order.id">
                                        <td>{{ index + 1}}</td>
                                        <td>{{ order.days_ago }}</td>
                                        <td>{{ order.order_id }}</td>
                                        <td>{{ order.item_count }}</td>
                                        <td>{{ order.total | price }}</td>
                                        <td>{{ order.status }}</td>
                                        <td class="action"><router-link :to="{path: `/my_orders/${order.order_id}`}"><i class="fa fa-eye"></i></router-link></td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs12 sm3 class="ml-2">
                    <v-card raised elevation="20" light ripple min-height="350" class="mb-3">
                        <v-card-title class="justify-center subheading">Alert Board</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text v-if="summaries.length > 0">
                            <h5 class="body-2">You have placed {{ summaries.length }} orders</h5>
                            <h5 class="body-4 orange--text">Pending: {{ pending.length }}</h5>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <div class="body-2 grey--text darken-3 px-2">Please call our mobile number 08023572852 to cancel a pending order</div>
                    </v-card>
                    <!-- <v-card raised elevation="20" light ripple min-height="300" class="mb-2">
                        <v-card-title class="justify-center subheading">We appreciate your reviews</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text v-if="summaries.length > 0">
                            <h5 class="body-2">You have placed {{ summaries.length }} orders</h5>
                            <h5 class="body-4 orange--text">Pending: {{ pending.length }}</h5>
                        </v-card-text>
                    </v-card> -->
                </v-flex>
                <modal name="review-order" height="auto" :draggable="true" :width="400">
                    <div class="modal-header">
                        <h4 class="text-center">How did you see your order of {{ revCuis && revCuis.cuisine.name }} ?</h4>
                    </div>
                    <div class="modal-body">
                        <v-text-field height="100" no-resize counter="100" label="Type your comments" v-model="cuisRevComment"></v-text-field>           
                        Rate Us: <v-rating small dense hover close-delay="2000" color="#ff3c38" v-model="rating"></v-rating>
                    </div>
                    <div class="modal-footer modal_btns">
                        <v-btn flat color="red" @click="dismissModal">Cancel</v-btn>
                        <v-btn :disabled="loading" :loading="loading" round dark color="#ff3c38" @click.prevent="sendCuisRev(revCuis)">Submit</v-btn> 
                    </div>
                </modal>
                <v-snackbar v-model="reviewAlert" :timeout="6000" top color="#44a80f">
                    Thanks for your review.
                    <v-btn color="coral" flat  @click="reviewAlert = false">Close</v-btn>
                </v-snackbar>
            </v-layout>
       </v-container>
   </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [],
            summaries: [],
            pending: [],
            revCuis: null,
            cuisRevComment: '',
            rating: null,
            loading: false,
            reviewAlert: false
        }  
    },
    methods: {
        calc(){
            axios.post('/calc').then((res) => {
                console.log(res.data)
            })
        },
        getMyOrders(){
            axios.get('/fetch_myorders').then((res) => {
                // console.log(res.data)
                this.orders = res.data
            })
        },
        fetchOrderSummaries(){
            axios.get('/fetch_ordersummaries_foruser').then((res) => {
                this.summaries = res.data

                if(res.data){
                    res.data.forEach(el => {
                        el.status === 'Pending'
                        this.pending.push(el)
                    })
                }
            })
        },
        showReviewModal(){
            axios.get('/show_review_modal').then((res)=>{
                // console.log(res.data)
                const multipl = Math.floor(Math.random() * (4 - 1)) + 1
                if(multipl === 2){
                    this.$modal.show('review-order')
                    this.revCuis = res.data
                }
            })
        },
        dismissModal(){
            this.cuisRevComment = ''
            this.$modal.hide('review-order')
        },
        sendCuisRev(order){
            if(this.cuisRevComment !== ''){
               axios.post(`/send_order_review/${order.cuisine_id}`, {
                   order: order,
                   comment: this.cuisRevComment,
                   rest: order.cuisine.restaurant_id,
                   rating: this.rating
               }).then((res) =>{
                //    console.log(res.data)
                   this.cuisRevComment = ''
                   this.$modal.hide('review-order')
                   this.reviewAlert = true
               })
            }
        }
    },
    mounted() {
        this.getMyOrders();
        this.fetchOrderSummaries();
        this.showReviewModal()
    },
}
</script>

<style lang="scss" scoped>
    table tr th{
        text-align: center;
    }
</style>
