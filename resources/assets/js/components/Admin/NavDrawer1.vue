<template>
    <v-navigation-drawer stateless value="true" absolute app dark class="nav_drawer" >
            <v-list>
                <v-list-tile>
                    <v-list-tile-action>
                        <v-icon>assessment</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title>Home</v-list-tile-title>
                </v-list-tile>

                <v-list-tile>
                    <v-list-tile-action>
                        <v-icon>home</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title>New Home</v-list-tile-title>
                </v-list-tile>

                
                <v-list-group prepend-icon="account_circle" value="true">
                    <template v-slot:activator>
                        <v-list-tile>
                            <v-list-tile-title>Users Management</v-list-tile-title>
                        </v-list-tile>
                    </template>

                    <v-list-tile value="true" v-for="item in menus" :key="item.title" :to="item.link" active-class="secondary--text">
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>{{ item.action }}</v-icon>
                            </v-list-tile-action>
                    </v-list-tile>
                </v-list-group>
 

                <!-- <v-list> -->
                    <v-list-group value="true" v-for="item in items" :key="item.title" v-model="item.active"
                        :prepend-icon="item.action">
                        <template v-slot:activator>
                            <v-list-tile>
                                <!-- <v-list-tile-content> -->
                                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                <!-- </v-list-tile-content> -->
                            </v-list-tile>
                        </template>

                        <v-list-tile v-for="subItem in item.items" :key="subItem.title" class="sub_list_item" active-class="#ff3c38 yellow_class" :to="subItem.link">
                            <!-- <v-list-tile-content> -->
                                <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                            <!-- </v-list-tile-content> -->

                            <v-list-tile-action>
                                <v-icon>{{ subItem.action }}</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-group>
                <!-- </v-list> -->
            </v-list>
        </v-navigation-drawer>
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
                {action: 'people_outline', title: 'My Users',items: [{ title: 'Admins', action: 'settings', link: '/admin/users/admins' }, {title: 'Bearers', action: 'directions_bike', link: '/admin/users/bearers'}, {title: 'Users', action: 'people_outline'}]},
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
          
            ],
            menus:[
                {title: 'Admins', action: 'settings', link: '/admin/users/admins' }, 
                {title: 'Bearers', action: 'directions_bike', link: '/admin/users/bearers'}, 
                {title: 'Users', action: 'people_outline', link: '/admin/users/bearers'}
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .nav_drawer{
        background: #34394a !important;
    }
</style>
