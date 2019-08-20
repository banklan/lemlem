 <template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Management - Locations</div>
                        <v-divider></v-divider>
                        <v-layout row wrap class="px-4">
                            <v-flex xs12>
                                <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Add new Location</v-btn>
                                <div class="subheading pa-3">Number of Locations: {{ locations.length }}</div>
                                <table class="table table-responsive table-hover table-bordered table-condensed table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>ID</th>
                                            <th>Location</th>
                                            <th>No of Outlets</th>
                                            <th>City</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(location, index) in locations" :key="location.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ location.id }}</td>
                                            <td>{{ location.name }}</td>
                                            <td>{{ location.restaurant && location.restaurant.length }}</td>
                                            <td>{{ location.city && location.city.name }}</td>
                                            <td style="text-align:center"><v-btn small color="blue white--text" @click.prevent="openEditDialog(location)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(location, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-flex>
                        </v-layout>
                        <v-dialog v-model="CreateDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Create a New Location</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs12>
                                                <v-text-field label="Name*" v-model="newLocation.name" required v-validate="'required|max:20'" :counter="30" :error-messages="errors.collect('create.name')" data-vv-name="name" data-vv-scope='create'></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-select :items="cities" item-text="name" item-value="id" label="City" v-model="newLocation.city" v-validate="'required'" :error-messages="errors.collect('create.city')" data-vv-name="city" data-vv-scope='create'></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" :disabled="isSaving" :loading="isSaving" @click="createLocation"> Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="delDialog" max-width="350">
                            <v-card>
                                <v-card-title class="subheading justify-center">Confirm Delete Location?</v-card-title>
                                <v-spacer></v-spacer>
                                <v-card-text> Do you want to delete <strong>{{ locationToDelete && locationToDelete.name }}</strong> city? Once deleted, it's irrecoverable.</v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                    <v-btn color="#3a40fb" dark text @click="delLocation(locationToDelete, locationToDelIndex)">Delete</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="editDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Edit Location - {{ locationToUpdate && locationToUpdate.name }} </span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-text-field label="Location*" v-model="editDetails.name" required v-validate="'required|max:20'" :counter="20" :error-messages="errors.collect('edit.name')" data-vv-name="name" data-vv-scope='edit'></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-select label="City" :items="cities" item-text="name" item-value="id" v-model="editDetails.city" v-validate="'required'" :error-messages="errors.collect('edit.city')" data-vv-name="city" data-vv-scope='edit'></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click="editDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" @click="updateLocation(locationToUpdate)" :disabled="isSaving" :loading="isSaving">Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-snackbar v-model="createdSuccess" :timeout="6000" top color="#44a80f">
                            New Location has been created.
                            <v-btn color="coral" flat @click="createdSuccess = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="deletedSuccess" :timeout="6000" top color="#44a80f">
                            Location was successfully deleted.
                            <v-btn color="coral" flat @click="deletedSuccess = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="editedSuccess" :timeout="6000" top color="#44a80f">
                            Location was successfully updated.
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
            locations: [],
            cities: [],
            newLocation: {
                name: '',
                city: null
            },
            CreateDialog: false,
            delDialog: false,
            createdSuccess: false,
            locationToDelete: null,
            locationToDelIndex: null,
            editDetails: {},
            isSaving: false,
            deletedSuccess: false,
            editDialog: false,
            locationToUpdate: {},
            editedSuccess: false,
        }
    },
    methods: {
        getCities(){
            axios.get('/admin_getcities').then((res) => {
                this.cities = res.data
            })
        },
        getLocations(){
            axios.get('/admin_getalllocs').then((res) => {
                this.locations = res.data
                // console.log(res.data);
            })
        },
        createLocation(){
            this.$validator.validateAll('create').then((isValid) =>{
                if(isValid){
                    this.isSaving = true
                    axios.post('/admin_createnewLocation', {
                        location: this.newLocation
                    }).then((res) => {
                        this.isSaving = false
                        this.closeCreateDialog()
                        this.createdSuccess = true
                        this.locations.unshift(res.data)
                    }).catch((err) => {
                        this.isSaving = false
                    })
                }
            })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newLocation = {}
            this.CreateDialog = false
        },
        openEditDialog(location){
            this.editDialog = true
            this.locationToUpdate = location
            this.editDetails = location
        },
        openDelDialog(location, index){
            this.delDialog = true
            this.locationToDelete = location
            this.locationToDelIndex = index
        },
        delLocation(location, index){
            axios.post(`/admin_deletelocation/${location.id}`).then((res) => {
                this.delDialog = false
                this.locations.splice(index, 1)
                this.deletedSuccess = true
            })
        },
        updateLocation(){
             this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){ 
                    this.isSaving = true;
                    axios.post(`/admin_updatelocation/${this.locationToUpdate.id}`, {
                        location: this.editDetails
                    }).then((res)=>{
                        console.log(res.data)
                        this.isSaving = false
                        this.editDialog = false
                        this.getLocations()
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

        this.getLocations()
    },
}
</script>

<style>

</style>
