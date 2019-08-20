 <template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Management - Cities</div>
                        <v-divider></v-divider>
                        <v-layout row wrap>
                            <v-flex xs10 offset-xs1>
                                <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Add new City</v-btn>
                                <div class="subheading pa-3">Number of Cities: {{ cities.length }}</div>
                                <table class="table table-responsive table-hover table-bordered table-condensed table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>ID</th>
                                            <th>City</th>
                                            <th>No of Locations</th>
                                            <th>No of Outlets</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(city, index) in cities" :key="city.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ city.id }}</td>
                                            <td>{{ city.name }}</td>
                                            <td>{{ city.location.length }}</td>
                                            <td>{{ city.restaurant.length }}</td>
                                            <td style="text-align:center"><v-btn small color="blue white--text" @click.prevent="openEditDialog(city)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(city, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-flex>
                        </v-layout>
                        <v-dialog v-model="CreateDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Create a New City</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12>
                                                <v-text-field label="Name*" v-model="newCity.name" required v-validate="'required|max:300'" :counter="30" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" :disabled="isSaving" :loading="isSaving" @click="createCity"> Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="delDialog" max-width="350">
                            <v-card>
                                <v-card-title class="subheading justify-center">Confirm Delete City?</v-card-title>
                                <v-spacer></v-spacer>
                                <v-card-text> Do you want to delete <strong>{{ cityToDelete && cityToDelete.name }}</strong> city? Once deleted, it's irrecoverable.</v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                    <v-btn color="#3a40fb" dark text @click="delCity(cityToDelete, cityToDelIndex)">Delete</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="editDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Edit City - {{ cityToUpdate && cityToUpdate.name }} </span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-text-field label="City*" v-model="editDetails.name" required v-validate="'required|max:20'" :counter="20" :error-messages="errors.collect('edit.name')" data-vv-name="name" data-vv-scope='edit'></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click="editDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" @click="updateCity(cityToUpdate)" :disabled="isSaving" :loading="isSaving">Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-snackbar v-model="createdSuccess" :timeout="6000" top color="#44a80f">
                            New city has been successfully created.
                            <v-btn color="coral" flat @click="createdSuccess = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="deletedSuccess" :timeout="6000" top color="#44a80f">
                            City was successfully deleted.
                            <v-btn color="coral" flat @click="deletedSuccess = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="editedSuccess" :timeout="6000" top color="#44a80f">
                            City was successfully updated.
                            <v-btn color="coral" flat @click="editedSuccess = false">Close</v-btn>
                        </v-snackbar>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            cities: [],
            newCity: {
                name: '',
            },
            CreateDialog: false,
            delDialog: false,
            createdSuccess: false,
            cityToDelete: null,
            cityToDelIndex: null,
            editDetails: {},
            isSaving: false,
            deletedSuccess: false,
            editDialog: false,
            outletToUpdate: {},
            locs: [],
            editedSuccess: false,
            cityToUpdate: null
        }
    },
    methods: {
        getCities(){
            axios.get('/admin_getcities').then((res) => {
                this.cities = res.data
            })
        },
        createCity(){
             this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.isSaving = true
                    axios.post('/admin_createnewcity', {
                        city: this.newCity
                    }).then((res) => {
                        console.log(res.data)
                        this.isSaving = false
                        this.closeCreateDialog()
                        this.createdSuccess = true
                        this.cities.unshift(res.data)
                    }).catch((err) => {
                        this.isSaving = false
                    })
                }
             })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newCity = {}
            this.CreateDialog = false
        },
        openEditDialog(city){
            this.editDialog = true
            this.cityToUpdate = city
            this.editDetails = city
        },
        openDelDialog(city, index){
            this.delDialog = true
            this.cityToDelete = city
            this.cityToDelIndex = index
        },
        delCity(city, index){
            axios.post(`/admin_deletecity/${city.id}`).then((res) => {
                this.delDialog = false
                this.cities.splice(index, 1)
                this.deletedSuccess = true
            })
        },
        updateCity(){
             this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){ 
                    this.isSaving = true;
                    axios.post(`/admin_updatecity/${this.cityToUpdate.id}`, {
                        city: this.editDetails.name
                    }).then((res)=>{
                        console.log(res.data)
                        this.isSaving = false
                        this.editDialog = false
                        this.getCities()
                        this.editedSuccess = true
                    }).catch((err) => {
                        this.isSaving = false
                    })
                }
             })
        }
    },
    mounted() {
        this.getCities()
    },
}
</script>

<style>

</style>
