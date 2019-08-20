<template>
  <v-app>
  <v-container grid-list-md>
    <v-layout mb-3>
        <v-btn color="#ff3c38" dark raised round ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
    </v-layout>
    <v-layout row wrap>
      <v-flex xs12 sm8 offset-sm2>
        <v-card class='pa-3' raised elevation="20" light min-height="300" transition="scale-transition">
            <v-card-title class="justify-center">
                <div class="title">Checkout</div>
            </v-card-title>
            <v-layout row wrap>
                <v-flex xs12 sm10 offset-sm1>
                    <div class="subheading red--text">Total: &#8358;{{ total | price}}</div>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>
            <v-layout row wrap v-if="completeLoc">
                <v-flex xs12 sm10 offset-sm1>
                    <div class="subheading text-xs-center mb-3">Tell us your location</div>
                    <div class="body-2 pa-3" style="background: #ff3f3f1c">
                        To enable us serve you better and ensure fast delivery, it is important we know your location. kindly fill your exact location (or nearest). 
                        It is a one-time process.
                    </div>
                    <v-layout row wrap class="mt-3">
                        <v-flex xs10 sm6>
                            <v-select dense :items="cities" item-text="name" item-value="id" label="Choose your City" v-model="city" @change="getLocation"></v-select>
                        </v-flex>
                        <v-flex xs10 sm6>
                            <v-select dense :items="locations" item-text="name" item-value="id" label="Choose your City" v-model="location"></v-select>
                        </v-flex>
                        <v-flex xs10 sm4 offset-sm4>
                            <v-btn round large ripple color="#ff3c38" class="white--text" @click.prevent="saveLoc">Save Location</v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
            <v-divider v-if="completeLoc"></v-divider>
            <v-layout row wrap>
                <v-flex x12 sm10 offset-sm1>
                    <v-textarea name="instruction" v-model="instruction" height="80" counter="200" auto-grow clearable label="Type any special instruction/request here e.g Drop the package with the gateman" ></v-textarea>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>
            <v-layout row wrap>
                <v-flex xs12 sm10 offset-sm1>
                    <div class="subheading text-xs-center mb-3"> Enter card details </div>
                    <v-text-field v-model="cardNo" :mask="mask" label="Credit Card No" :rules="[rules.required]"></v-text-field>
                    <v-text-field v-model="pin" label="Card Pin" :rules="[rules.required]" hint="Your 4-digits card Pin"></v-text-field>
                </v-flex>
                <v-flex xs4 offset-xs1>
                    <v-text-field v-model="cvv" label="CVV Number" :rules="[rules.required]" hint="Your card security number"></v-text-field>
                </v-flex>
                <v-flex xs4 offset-xs1>
                  <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent lazy full-width width="290px">
                      <template v-slot:activator="{ on }">
                          <v-text-field v-model="date" label="Expiry Date" readonly v-on="on" :rules="[rules.required]"></v-text-field>
                      </template>
                      <v-date-picker v-model="date" type="month" scrollable>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="modal = false">Cancel</v-btn>
                          <v-btn flat color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
                      </v-date-picker>
                  </v-dialog>
                </v-flex>
                <v-flex xs4 offset-xs4 class="my-3">
                    <v-btn color="#ff3c38" :loading="loading" :disabled="loading" large block class="white--text" @click="checkout('paid')">Checkout</v-btn>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>
            <v-layout row wrap class="pa-2 my-3">
                <v-flex xs4 offset-xs4>
                    <v-btn outline @click.prevent="checkout('pod')" color="transparent" :loading="loading" :disabled="loading" block large class="grey--text darken-3">I want to pay on delivery</v-btn>
                </v-flex>
                <v-flex xs10 offset-xs1>
                    <div class="body-4 orange--text darken-2">Please ensure you have the cash for payment ready before our delivery team reaches you as they do not carry petty cash.</div>
                </v-flex>
            </v-layout>
        </v-card> 
        <v-snackbar v-model="success_alert" :timeout="6000" top color="#44a80f">
            Your order has been taken. We will get to you soon
            <v-btn color="coral" flat  @click="success_alert = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="location_success" :timeout="6000" top color="#44a80f">
            Your location has been saved. Thank you.
            <v-btn color="coral" flat  @click="location_success = false">Close</v-btn>
        </v-snackbar>
      </v-flex>
    </v-layout>
  </v-container>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      order: [],
    //   total: null,
      instruction: '',
      mask: 'credit-card',
      cardNo: '0000000000000000',
      expiry: null,
      cvv: null,
      pin: null,
      date: new Date().toISOString().substr(0,7),
      modal: false,
      rules: {
          required: value => !!value || 'Required.',
          min: v => v.length === 4 || 'Pin must be 4 characters'
      },
      loading: false,
      success_alert: false,
      completeLoc: false,
      cities: [],
      city: null,
      locations: [],
      location: null,
      location_success: false
    }
  },
  computed: {
      getCharges(){
        return this.$store.getters.getCharges
      },
      total(){
          return this.$store.getters.getGrandTotalCost
      }
  },
  methods: {
    checkout(status){
      if(this.order.length > 0){
          this.loading = true
          if(status == 'paid'){
            //process payment and if unsuccessful, return msg to user and return; if successfull continue
            //if successful show an alert of payment success
          }    
          axios.post('/post_orders', {
              orders: this.order,
              tot : this.total,
              instr: this.instruction,
              pymt_status: status,
              charges: this.getCharges
          }).then((res) => {
              console.log(res.data)
              this.loading = false
              this.success_alert = true

              //clear from storage
              localStorage.removeItem('orders')
              localStorage.removeItem('total')
              localStorage.removeItem('order_cost')
              localStorage.removeItem('charges')
              this.$store.commit('clear_order', this.order)
              
              //send notif email 
              axios.post(`/send_order_rcvd_mail`, {
                  order: res.data.id
              }).then((res) => {
                  console.log(res.data)
              })
          }) 
          setInterval(() => {
            this.$router.push({name: 'MakeOrders'})
          }, 4000);
      }
    },
    getLocation(){
        if(this.city !== null){
            axios.get('/get_locations/' + this.city).then((res) => {
                this.locations = res.data
            })
        }
    },
    saveLoc(){
        axios.post('/save_userlocation', {
            location: this.location
        }).then((res) => {
            // console.log(res.data)
            this.location_success = true
            this.completeLoc = false
        })
    }
  },
  mounted() {
    this.order = this.$route.params.order || JSON.parse(localStorage.getItem('orders'))
    this.total = this.$route.params.total || localStorage.getItem('total')

    if(this.order.length == 0){
      this.$router.push({name: 'MakeOrders'})
    }

    //check if user has filled location and area code
    axios.get('/check_user_loc').then((res) => {
      if(res.data == false){
        this.completeLoc = true

        let vm = this
        axios.get('/get_cities').then((res) => {
            vm.cities = res.data
        })
      }
    })
  }
}
</script>

<style>

</style>
