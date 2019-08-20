<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="single">
                    <div class="img">
                        <img src="/images/assets/cuisines/delic.jpg">
                    </div>
                    <div class="details">
                        <p><strong>Jollof rice</strong></p>
                        <p>&#8358;750.00</p>
                        <div class="chip">
                            <v-chip outline>Rice</v-chip>
                        </div>
                    </div>
                    <div class="action">
                        <select class="form-control">
                            <option value="" disabled selected>Portions</option>
                            <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                        </select>
                        <div class="add text-center">
                            <button class="btn btn-sm btn-default" type="button" @click="addToTray"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <order-tray></order-tray>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cuisines: [],
            portions: [1, 2, 3, 4, 5],
            order: {
                cuisine: '',
                price: '',
                portion: ''
            }

        }
    },
    methods: {
        addToTray(){

        }
    },
    mounted() {
        axios.get('/fetch_allcuisines').then((res) => {
            res.data.forEach(item => {
                this.cuisines.push(item)
            });
            // this.cuisines = res.data
            console.log(this.cuisines)
        })
    },
}
</script>

<style lang="scss">
    .single{
        height: 11rem;
        width: 100%;
        display: flex;
        border-radius: 4px;
        position: relative;
        transition: .3s cubic-bezier(.25,.8,.5,1);

        background-color: #fff;
        border-color: #fff;
        color: rgba(0,0,0,.87);
        box-shadow: 0 3px 5px -1px rgba(0,0,0,.2),0 5px 8px 0 rgba(0,0,0,.14),0 1px 14px 0 rgba(0,0,0,.12)!important;
        overflow: hidden;

        .img{
            flex: 0 1 30%;
            height: 100%;
            border-right:1px solid #dadada;

            img{
                height: 100%;
                width: 100%;
            }
        }
        .details{
            flex: 0 1 40%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:flex-start;
            margin-left: 2rem;
            .chip{
                margin-left: -3px;
            }
        }
        .action{
            flex: 0 1 30%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;

            select{
                flex: 0 1 50%;
                border: none !important;
                border-bottom: 1px solid #ccd0d2 !important;
                box-shadow: none;
                border-radius: 0;
                margin: auto;
            }
            .add{
                flex:0 1 50%;
                margin: auto;
                
                button{
                    margin: auto;
                    background: #6ecdea;
                    border: 1px solid #6ecdea;
                    transition: all .5s;

                    &:hover{
                        background: #4a96ad;
                        border: 1px solid #39788b;
                    }

                    .fa{
                        color: #fff
                    }
                }
            }
        }
        @media screen and (max-width: 700px){
            .details{
                margin-left: 1rem;
                font-size: 13px;
                flex: 0 1 35%;
            }
            .action{
                 flex: 0 1 35%;
            }
        }
        
    }
    
</style>


