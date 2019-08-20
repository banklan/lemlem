<template>
    <v-app>
        <v-content>
            <v-container>
                <v-layout row wrap>
                    <v-flex xs10 offset-xs1 md10 offset-md1>
                        <v-card raised color="white" class="grey--text" min-height="12rem">
                            <v-layout pa-2>
                                <v-flex xs3>
                                    <v-img src="/images/assets/cuisines/delic.jpg" height="10rem"></v-img>
                                </v-flex>
                                <v-flex xs9>
                                    {{ cuisine.name }}
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    props: ['cuisine']
}
</script>

<v-flex xs12>
            <v-card color="cyan darken-2" class="white--text">
              <v-layout>
                <v-flex xs5>
                  <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/foster.jpg"
                    height="125px"
                    contain
                  ></v-img>
                </v-flex>
                <v-flex xs7>
                  <v-card-title primary-title>
                    <div>
                      <div class="headline">Supermodel</div>
                      <div>Foster the People</div>
                      <div>(2014)</div>
                    </div>
                  </v-card-title>
                </v-flex>
              </v-layout>
              <v-divider light></v-divider>
              <v-card-actions class="pa-3">
                Rate this album
                <v-spacer></v-spacer>
                <v-icon>star_border</v-icon>
                <v-icon>star_border</v-icon>
                <v-icon>star_border</v-icon>
                <v-icon>star_border</v-icon>
                <v-icon>star_border</v-icon>
              </v-card-actions>
            </v-card>
          </v-flex>

