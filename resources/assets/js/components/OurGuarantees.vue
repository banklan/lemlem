<template>
    <div class="guarantees">
        <h2 class="text-center">Why you should use lemlem to order</h2>
        <v-layout row wrap>
            <v-flex xs12 sm8 offset-sm2 v-for="reason in reasons" :key="reason.text" align-center>
                <v-icon dark left x-large>{{ reason.icon }}</v-icon>
                <span class="subheading">{{ reason.text }}</span>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
export default {
    data() {
        return {
            reasons: [
                {icon: 'done_all', text: 'You can concentrate on what matters to you, while we take care of your orders'},
                {icon: 'done_all', text: 'Our deliveries are as fast as if we are within your neighbourhood before'},
                {icon: 'done_all', text: 'We will ensure you get your orders oven fresh and hot'},
                {icon: 'done_all', text: 'We recognise the importance of payment flexibilities, we offer you just that'},
                {icon: 'done_all', text: 'Our staff are corteous and professional'},
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .guarantees{
        margin: auto;
        min-height: 40rem;
        background-image: linear-gradient(to bottom right, rgba(105, 178, 226, 0.7), rgba(162, 197, 220, 0.7)), url(/images/assets/guarantees.jpg);
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 2rem;
        color: #fff;
        line-height: 1.6;

        h2{
            font-size: 36px;
            font-weight: 200;
            padding: 1.2rem;
        }
        .layout{
            margin-top: 3rem auto !important;
            padding: 1.5rem !important;
        }
        .subheading{
            font-size: 24px !important;
            font-weight: 200;
        }
    }
</style>
