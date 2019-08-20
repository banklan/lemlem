<template>
    <div class="orders">
        <router-view></router-view>
    </div>
</template>


<script>
import make from './MakeOrders';
import show from './cuisineShow';
import test from './CuisineTest';

export default {
    components: {make, show, test},
    name: 'OrdersTest'
}
</script>
