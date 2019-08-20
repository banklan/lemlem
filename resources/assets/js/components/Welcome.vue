<template>
   <div class="welcome">
       <div class="welcome_banner">
           <div class="welcome_title text-center">
               <h1 class="">Order your favourite meals, chops and grills..in three simple steps!</h1>
               <h3>...get your orders oven-fresh within minutes</h3>
               <a href="/make_orders" class="btn btn-lg btn_cta">Order Now</a>
           </div>
       </div>
       <div class="container">
           <div class="row">
               <div class="how_to text-center">
                    <h2>Order your favourite meals from your favourite outlets in three simple clicks.</h2>
                    <div class="card_wrap">
                         <div class="card">
                             <div class="cd_icon">
                                 <v-icon size="8rem" color="#105bfb" class="find">find_in_page</v-icon>
                             </div>
                             <div class="cd_text">
                                 <h3>1</h3>
                                 <h3>Choose your city, click your favourite outlet... </h3>
                             </div>
                         </div>
                         <div class="card">
                             <div class="cd_icon">
                                 <v-icon size="8rem" color="#ff3c38" class="cuisine">local_dining</v-icon>
                             </div>
                             <div class="cd_text">
                                 <h3>2</h3>
                                 <h3>Choose your cuisines, drinks or chops... </h3>
                             </div>
                         </div>
                         <div class="card">
                             <div class="cd_icon">
                                 <v-icon size="8rem" color="#105bfb" class="pymt">payment</v-icon>
                             </div>
                             <div class="cd_text">
                                 <h3>3</h3>
                                 <h3>Choose your preferred payment method..and wait while we deliver in jet speed </h3>
                             </div>
                         </div>
                    </div> 
                </div>
           </div>
       </div>
          <featured-rests :outlets="outlets"></featured-rests>
          <pop-cuisines></pop-cuisines>
          <!-- <pop-outlets :outlets="outlets"></pop-outlets> -->
          <our-guarantees></our-guarantees>
          <footerxy></footerxy>
   </div>
</template>

<script>
    export default {
        data() {
            return {
                outlets: [],
            }
        },
        methods: {
            getOutlets(){
                axios.get('/fetch_alloutlets').then((res)=> {
                    this.outlets = res.data
                })
            },
        },
        mounted() {
            this.getOutlets()
        }
    }
</script>

<style lang="scss" scoped>
    
</style>