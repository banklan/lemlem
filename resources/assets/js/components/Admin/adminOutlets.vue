 <template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Outlets Management</div>
                        <v-divider></v-divider>
                        <v-layout row wrap class="pa-4">
                            <v-flex xs12>
                                <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Add new Outlet</v-btn>
                                <div class="subheading pa-3">Number of Outlets: {{ outlets.length }}</div>
                                <table class="table table-responsive table-hover table-bordered table-condensed table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>ID</th>
                                            <th>City</th>
                                            <th>Name</th>
                                            <th>View</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(outlet, index) in outlets" :key="outlet.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ outlet.id }}</td>
                                            <td>{{ outlet.city &&  outlet.city.name }}</td>
                                            <td>{{ outlet.name }}</td>
                                            <td style="text-align:center"><v-btn small flat :to="{name: 'adminOutletShow', params:{id: outlet.id}}"><v-icon color="grey">visibility</v-icon></v-btn></td>
                                            <td style="text-align:center"><v-btn small color="blue white--text" @click.prevent="openEditDialog(outlet)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(outlet, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-flex>
                        </v-layout>
                        <v-dialog v-model="CreateDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Create a New Outlet</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap align-center justify-space-around>
                                            <v-flex xs6>
                                                <v-select label="Choose City" :items="cities" item-text="name" item-value="id" required v-model="newOutlet.city" @change="loadLocations" v-validate="'required'" :error-messages="errors.collect('city')" data-vv-name="city"></v-select>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-select label="Choose Location" :items="locations" item-text="name" item-value="id" required v-model="newOutlet.location" v-validate="'required'" :error-messages="errors.collect('location')" data-vv-name="location"></v-select>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field label="Name*" v-model="newOutlet.name" required v-validate="'required|max:100'" :counter="100" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field label="Phone No*" v-model="newOutlet.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-textarea label="Address*" rows="1" auto-grow v-model="newOutlet.address" required v-validate="'required|max:120'" :error-messages="errors.collect('address')" data-vv-name="address"></v-textarea>
                                            </v-flex>
                                            <v-divider></v-divider>
                                            <v-flex xs12 class="mb-2">
                                                <input type="file" style="display:none" ref="fileInput" @change="handleUpload" accept="image/*">
                                                <v-btn raised class="primary" @click.prevent="chooseFile"> Upload Logo</v-btn>
                                            </v-flex>
                                            <v-flex xs12 v-if="previewImg" class="pa-3">
                                                <img :src="newImageUrl" height="100">
                                                <v-btn flat small class="red--text" @click.prevent="removeFile"><v-icon>delete_forever</v-icon></v-btn>
                                            </v-flex>
                                            <v-divider></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-flex xs12 class="mt-3">
                                                <h4 class="mb-2">Operating Hours</h4>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-select label="Opening hour" v-model="newOutlet.openingHr" :items="hours" :max="newOutlet.closingHr" required v-validate="'required'" :error-messages="errors.collect('opening-hr')" data-vv-name="opening-hr"></v-select>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-select label="Closing hour" v-model="newOutlet.closingHr" :items="hours" :min="newOutlet.openingHr" required v-validate="'required'" :error-messages="errors.collect('closing-hr')" data-vv-name="closing-hr"></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" :disabled="saving" :loading="saving" @click="createOutlet"> Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="delDialog" max-width="350">
                            <v-card>
                                <v-card-title class="subheading justify-center">Confirm Delete Outlet?</v-card-title>
                                <v-spacer></v-spacer>
                                <v-card-text> Do you want to delete this outlet <strong>{{ outletToDelete && outletToDelete.name }}</strong>? Once deleted, it's irrecoverable.</v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                    <v-btn color="#3a40fb" dark text @click="delOutlet(outletToDelete, outletToDelIndex)">Delete</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="editDialog" persistent max-width="600px">
                            <v-card class="">
                                <v-card-title class="justify-center">
                                    <span class="title mt-2">Edit Restaurant - {{ outletToUpdate && outletToUpdate.name }} </span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-text-field label="Outlet Name*" v-model="editDetails.name" required v-validate="'required|max:100'" :counter="60" :error-messages="errors.collect('edit.name')" data-vv-name="name" data-vv-scope='edit'></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-text-field label="Phone Number" v-model="editDetails.phone" required hint="Phone number" v-validate="'required'" :error-messages="errors.collect('edit.phone')" data-vv-name="phone" data-vv-scope='edit'></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-textarea label="Address" auto-grow rows="1" v-model="editDetails.address" required hint="Restaurant's address" v-validate="'required|max:120'" :counter="120" :error-messages="errors.collect('edit.address')" data-vv-name="address" data-vv-scope='edit'></v-textarea>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-text-field label="City" readonly :value="outletToUpdate.city && outletToUpdate.city.name"></v-text-field>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-text-field label="Location" readonly :value="outletToUpdate.location && outletToUpdate.location.name"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12>
                                                <v-select label="Change location" v-model="editDetails.location" :items="locs" item-text="name" item-value="id"></v-select>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-select label="Change Opening Hour" v-model="editDetails.opening_hr" :items="hours"></v-select>
                                            </v-flex>
                                            <v-flex xs6>
                                                <v-select label="Change Closing Hour" v-model="editDetails.closing_hr" :items="hours"></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat dark color="red darken-3" @click="editDialog = false">Close</v-btn>
                                    <v-btn color="blue darken-3 white--text" @click="updateOutlet(outletToUpdate)" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-snackbar v-model="created_success" :timeout="6000" top color="#44a80f">
                            New outlet has been successfully created.
                            <v-btn color="coral" flat @click="created_success = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="deletedSuccess" :timeout="6000" top color="#44a80f">
                            Outlet was successfully deleted.
                            <v-btn color="coral" flat @click="deleted_success = false">Close</v-btn>
                        </v-snackbar>
                        <v-snackbar v-model="edited_success" :timeout="6000" top color="#44a80f">
                            Outlet details was successfully updated.
                            <v-btn color="coral" flat @click="edited_success = false">Close</v-btn>
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
            outlets: [],
            cities: [],
            newOutlet: {
                name: '',
                city: null,
                location: null,
                address: '',
                phone: '',
                openingHr: null,
                closingHr: null,
                file: ''
            },
            hours: ['12:00am', '1:00am', '2:00am', '3:00am', '4:00am', '5:00am', '6:00am', '7:00am',
                   '8:00am', '9:00am', '10:00am', '11:00am', '12:00pm', '1:00pm', '2:00pm', '3:00pm',
                   '4:00pm', '5:00pm', '6:00pm', '7:00pm', '8:00pm', '9:00pm', '10:00pm', '11:00pm'],
            locations: [],
            CreateDialog: false,
            delDialog: false,
            saving: false,
            previewImg: false,
            newImageUrl: '',
            created_success: false,
            outletToDelete: null,
            outletToDelIndex: null,
            editDetails: {},
            savingDetails: false,
            deletedSuccess: false,
            editDialog: false,
            outletToUpdate: {},
            locs: [],
            edited_success: false
        }
    },
    methods: {
        getOutlets(){
            axios.get('/admin_getalloutlets').then((res) => {
                this.outlets = res.data
            })
        },
        getCities(){
            axios.get('/admin_getcities').then((res) => {
                this.cities = res.data
            })
        },
        loadLocations(){
            axios.get(`/admin_getlocations_fromcity/${this.newOutlet.city}`).then((res) => {
                this.locations = res.data
            })
        },
        createOutlet(){
            // console.log(this.newOutlet.startTime + ' - ' + this.newOutlet.endTime);
             this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.saving = true

                    const config = {headers: {
                            'Content-Type' : 'multipart/form-data',
                        }
                    };

                    let vm = this; 

                    const form = new FormData();
                    form.append('city', vm.newOutlet.city)
                    form.append('location', vm.newOutlet.location)
                    form.append('name', vm.newOutlet.name)
                    form.append('phone', vm.newOutlet.phone)
                    form.append('address', vm.newOutlet.address)
                    form.append('openingHr', vm.newOutlet.openingHr)
                    form.append('closingHr', vm.newOutlet.closingHr)
                    form.append('file', vm.newOutlet.file)
                    
                    axios.post('/admin_createnewoutlet', form, config).then((res) => {
                        console.log(res.data)
                        this.saving = false
                        this.closeCreateDialog()
                        this.created_success = true
                        this.outlets.unshift(res.data)
                    }).catch((err) => {
                        this.saving = false
                    })
                }
             })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newOutlet = {}
            this.CreateDialog = false
        },
        chooseFile(){
            this.$refs.fileInput.click()
        },
        handleUpload(e){
            this.previewImg = true
            const file = e.target.files[0]
            this.newOutlet.file = file
            let fileName = file.name
            console.log(fileName);
            this.newImageUrl = URL.createObjectURL(file)
        },
        removeFile(){
            this.$refs.fileInput.value = ''
            this.newImageUrl = '';
            this.previewImg = false;
        },
        openEditDialog(outlet){
            this.editDialog = true
            this.outletToUpdate = outlet
            this.editDetails = outlet
            //get locations within city
            axios.get(`/admin_getalllocsincity/${outlet.city_id}`).then((res) => {
                this.locs = res.data
            })
        },
        openDelDialog(outlet, index){
            this.delDialog = true
            this.outletToDelete = outlet
            this.outletToDelIndex = index
        },
        delOutlet(outlet, index){
            axios.post(`/admin_deleteoutlet/${outlet.id}`).then((res) => {
                this.delDialog = false
                this.outlets.splice(index, 1)
                this.deletedSuccess = true
            })
        },
        updateOutlet(){
             this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){ 
                    this.savingDetails = true;
                    axios.post(`/admin_updateoutlet/${this.outletToUpdate.id}`, {
                        outlet: this.editDetails
                    }).then((res)=>{
                        console.log(res.data)
                        this.savingDetails = false
                        this.editDialog = false
                    }).catch((err) => {
                        this.savingDetails = false
                    })
                }
             })
        }
    },
    mounted() {
        this.getOutlets()

        this.getCities()
    },
}
</script>

<style>

</style>
