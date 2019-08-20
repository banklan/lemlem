<template>
    <v-navigation-drawer app stateless value="true" dark class="nav_drawer" absolute>
       <v-list>
          <template v-for="item in items">
              <v-list v-if="!item.subItems" :key="item.title">
                  <v-list-tile router :to="item.link">
                      <v-list-tile-action>
                          <v-icon>{{ item.action }}</v-icon>
                      </v-list-tile-action>
                      <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile>
              </v-list>

              <v-list-group v-else :key="item.title" :prepend-icon="item.action" no-action> 
                  <template v-slot:activator>
                    <v-list-tile>
                      <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </template>

                  <v-list-tile v-for="subItem in item.subItems" :key="subItem.title" class="hovered" :to="subItem.link">
                    <v-list-tile-content>
                      <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                      <v-icon>{{ subItem.action }}</v-icon>
                    </v-list-tile-action>
                  </v-list-tile>
              </v-list-group>
          </template>
        </v-list>     
    </v-navigation-drawer>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {action: 'assessment', title: 'Dashboard Home', link: '/admin', active: true},
                {action: 'people_outline', title: 'My Users', active: false, subItems: [{ title: 'Admins', action: 'settings', link: '/admin/users/admins' }, {title: 'Bearers', action: 'directions_bike', link: '/admin/users/bearers'}, {title: 'Users', action: 'people_outline', link: '/admin/users/client_users'}]},
                {action: 'fastfood', title: 'Cuisines', link: '/admin/cuisines',},
                {action: 'restaurant', title: 'Outlets', link: '/admin/outlets'},
                {action: 'directions', title: 'Cities', subItems: [{ title: 'Cities', action: 'directions', link: '/admin/cities' }, {title: 'LOcations', action: 'directions', link: '/admin/locations'}]},
                {action: 'shopping_cart', title: 'Orders'},
                {action: 'account_balance_wallet', title: 'Charges'},
                {action: 'local_activity', title: 'Misceleanous',subItems: [{ title: 'List Item' }]},
                {action: 'forum', title: 'Feedbacks',subItems: [{ title: 'List Item' }]},
                {action: 'settings', title: 'Settings',subItems: [{ title: 'List Item' }]},
                {action: 'table_chart', title: 'Tables',subItems: [{ title: 'List Item' }]},
                {action: 'person_outline', title: 'Profile',subItems: [{ title: 'List Item' }]},
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .v-navigation-drawer{
        background: #34394a !important;
        // margin-top: 5rem !important;
    }

   
</style>
