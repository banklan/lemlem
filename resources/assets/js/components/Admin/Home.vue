<template>
    <!-- <v-app> -->
        <!-- <v-content> -->
            <v-layout row wrap>
                <v-flex xs3>
                    <nav-drawer></nav-drawer>
                </v-flex>
                <v-flex xs9>
                    <h1>Home here</h1>
                </v-flex>
            </v-layout>
        <!-- </v-content> -->
    <!-- </v-app> -->
</template>

<script>
export default {
    data() {
        return {
            admins: [
                ['Management', 'people_outline'],
                ['Settings', 'settings']
            ],
            users: [
                ['Admin', 'settings'],
                ['Bearer', 'people_outline'],
                ['Users', 'people_outline']
            ],
            items: [
                {action: 'assessment', title: 'Dashboard Home', active: true},
                {action: 'people_outline', title: 'My Users',items: [{ title: 'Admins', action: 'settings', link: '/admin/admin_users' }, {title: 'Bearers', action: 'directions_bike', link: '/admin/bearers'}, {title: 'Users', action: 'people_outline'}]},
                {action: 'fastfood', title: 'Cuisines',items: [{ title: 'List Item' }]},
                {action: 'restaurant', title: 'Outlets',items: [{ title: 'List Item' }]},
                {action: 'directions', title: 'Cities',items: [{ title: 'List Item' }]},
                {action: 'shopping_cart', title: 'Orders',items: [{ title: 'List Item' }]},
                {action: 'account_balance_wallet', title: 'Charges',items: [{ title: 'List Item' }]},
                {action: 'local_activity', title: 'Misceleanous',items: [{ title: 'List Item' }]},
                {action: 'forum', title: 'Feedbacks',items: [{ title: 'List Item' }]},
                {action: 'settings', title: 'Settings',items: [{ title: 'List Item' }]},
                {action: 'table_chart', title: 'Tables',items: [{ title: 'List Item' }]},
                {action: 'person_outline', title: 'Profile',items: [{ title: 'List Item' }]},
                {
                    action: 'restaurant',
                    title: 'Dining',
                    // active: true,
                    items: [
                        { title: 'Breakfast & brunch' },
                        { title: 'New American' },
                        { title: 'Sushi' }
                    ]
                },
          
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .nav_drawer{
        background: #34394a !important;
        
        // .sub_list_item a:hover, a .v-list__tile__action:hover{
        //     color: red !important;
        // }

        // .theme--dark .v-list:hover{
        //     color: red;
        // }
        .v-list .v-list__group__items .sub_list_item .v-list__tile:hover{
            color: #ff3c38 !important;
        }
        .v-list__tile .v-list__tile--link .theme--dark{
            color: #ff3c38 !important;
        }
        .yellow_class{
            color: yellow;
        }
    }
</style>
