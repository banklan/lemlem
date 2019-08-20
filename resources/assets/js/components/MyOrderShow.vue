<template>
   <v-content>
       <link-tab></link-tab>
       <v-container grid-list-md>
            <v-layout row wrap class="justify-space-between mt-3">
                <v-flex xs12 sm5 class="">
                    <v-card raised elevation="20" light min-height="300" transition="scale-transition">
                        <v-card-title class="justify-center">
                            <div class="title">Order #{{ orderNo }}</div>
                        </v-card-title>
                        <v-card-text class="mx-4 justify-center">
                            <v-progress-circular indeterminate color="coral" :width="5" :size="40" v-if="!summary"></v-progress-circular>
                            <table v-if="summary" class="table table-responsive table-condensed">
                                <tr>
                                    <th>Order Date: </th>
                                    <td>{{ summary.days_ago }}</td>
                                </tr>
                                <tr>
                                    <th>No of Items: </th>
                                    <td>{{ summary.item_count }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount: </th>
                                    <td>&#8358;{{ summary.total | price }}</td>
                                </tr>
                                <tr>
                                    <th>Order Status: </th>
                                    <td>{{ summary.status }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status: </th>
                                    <td>{{ summary.pymt_status == 'paid' ? 'Paid' : 'Pay on Delivery' }}</td>
                                </tr>
                            </table>
                        </v-card-text>
                    </v-card>
                    <v-card raised elevation="20" light min-height="300" v-if="summary && summary.status == 'delivered'" class="mt-3">
                        <v-card-title class="justify-center" v-if="!summary.valet_review">
                            <div class="title">Rate our valets</div>
                        </v-card-title>
                        <v-card-title class="justify-center" v-else>
                            <div class="title">Your review about our valet</div>
                        </v-card-title>
                        
                        <v-card-text>
                            <div class="valet">
                                <div v-if="!summary.valet_review">
                                    <v-text-field height="100" no-resize counter="100" label="Type your comments" v-model="valetReview"></v-text-field>
                                    <v-btn :disabled="loading1" :loading="loading1" round dark color="#ff3c38" @click.prevent="sendValetRev">Submit</v-btn>
                                </div>
                                <div v-else>
                                    <div class="body-2 dark-grey--text">{{ summary.valet_review }}</div>
                                </div>
                            </div>
                            <div class="cuis_rev">
                                
                            </div>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs12 sm5>
                    <v-progress-circular indeterminate color="coral" :width="5" :size="40" v-if="orders.length === 0"></v-progress-circular>
                    <div class="order_tbl" v-else>
                        <h4 class="text-center">List of items</h4>
                        <div class="item_wrapper" v-for="item in orders" :key="item.id">
                            <p class="cuis"><router-link :to="{path: `/cuisine/${item.cuisine_id}/${item.cuisine.slug}`}">{{ item.cuisine.name }} X {{ item.units }}- <span class="price">&#8358;{{ item.cuisine.price * item.units | price }}</span></router-link><span v-if="summary && summary.status == 'delivered'"><v-btn v-if="item.review == null" small outline color="grey" @click.prevent="openRevModal(item)">Review</v-btn></span></p>
                            <p>{{ item.cuisine && item.cuisine.restaurant.name }}</p>
                        </div>
                    </div>
                </v-flex>
                <modal name="review" height="auto" :draggable="true" :width="400">
                    <div class="modal-header">
                        <h4 class="text-center">Review {{ reviewCuis && reviewCuis.cuisine.name }} </h4>
                    </div>
                    <div class="modal-body">
                        <v-text-field height="100" no-resize counter="100" label="Type your comments" v-model="cuisRevComment"></v-text-field>           
                        Rate Us: <v-rating small dense hover close-delay="1000" color="#ff3c38" v-model="rating"></v-rating>
                    </div>
                    <div class="modal-footer modal_btns">
                        <v-btn flat color="red" @click="dismissModal">Cancel</v-btn>
                        <v-btn :disabled="loading1" :loading="loading2" round dark color="#ff3c38" @click.prevent="sendCuisRev(reviewCuis)">Submit</v-btn> 
                    </div>
                </modal>
            </v-layout>
        </v-container>
   </v-content>       
</template>

<script>
export default {
    data() {
        return {
            orders: [],
            orderNo: null,
            summary: null,
            cuisReview: '',
            valetReview: '',
            cuisRatings: null,
            valetRatings: null,
            loading1: false,
            loading2: false,
            cuisReviewed: false,
            reviewCuis: null,
            cuisRevComment: '',
            rating: null
        }
    },
    methods: {
        fetchOrder(){
            axios.get(`/fetch_order/${this.orderNo}`).then((res) => {
                this.orders = res.data
            })
        },
        fetchSummary(){
            axios.get(`/fetch_ordersummary/${this.orderNo}`).then((res)=>{
                this.summary = res.data
            })
        },
        sendValetRev(){
            if(this.valetReview !== ''){
                this.loading1 = true
                axios.post(`/send_valetreview/${this.orderNo}`, {
                    comment: this.valetReview
                }).then((res) => {
                    // console.log(res.data)
                    this.loading1 = false
                    this.valetReview = ''
                    this.fetchSummary()
                })
            }
        },
        openRevModal(item){
            this.reviewCuis = item
            this.$modal.show('review')
        },
        dismissModal(){
            this.cuisRevComment = ''
            this.$modal.hide('review')
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
                   this.rating = null
                   this.$modal.hide('review')
                   this.fetchOrder()
               })
            }
        }
    },
    mounted() {
        this.orderNo = this.$route.params.id

        this.fetchOrder()
        
        this.fetchSummary()

        // this.isReviewed()
    },
}
</script>

<style lang="scss" scoped>
    tr{
        height: 2.5rem;

        td{
            text-align: left;
        }
    }
    .order_tbl{
        background: #fff;  
        border-color: #fff;
        border-radius: 6px;
        color: rgba(0,0,0,.87);
        box-shadow: 0 6px 6px -3px rgba(0,0,0,.2),0 10px 14px 1px rgba(0,0,0,.14),0 4px 18px 3px rgba(0,0,0,.12)!important;                text-decoration: none;
        overflow: hidden;
        padding-bottom: 1rem;

        h4{
            padding: 1rem;
        }

        .item_wrapper{
            height: 6rem;
            width: 100%;
            border-top: 1px solid #d6d6d6;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: space-around;
            padding: 0 1rem 1rem 1.5rem;
            padding-top:1.7rem;
            
            p{
                font-size: 14px;

                &:last-child{
                    color: grey;
                }

                a{
                    text-decoration: none;

                    .price{
                        color: coral;
                        padding-left: 1rem;
                        font-weight: 600;
                    }
                }
            }
            .cuis{
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
            }
        }
    }
    
</style>
