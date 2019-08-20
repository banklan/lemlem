<template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs12 sm3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs12 sm9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Outlets Management</div>
                        <v-divider></v-divider>
                        <v-btn dark color="coral" elevation="10" round small @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                        <v-layout row wrap my-4>
                            <v-flex xs10 offset-xs1>
                                <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!outlet"></v-progress-circular>
                                <div v-if="outlet">
                                    <img v-if="outlet.picture" :src="'/images/assets/outlets/' + outlet.picture" height="100" class="mb-3">
                                    <table class="table table-responsive table-hover">
                                        <tr>
                                            <th>Name: </th>
                                            <td style="text-align:left">{{ outlet.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Outlet Phone: </th>
                                            <td style="text-align:left">{{ outlet.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Outlet Address: </th>
                                            <td style="text-align:left">{{ outlet.address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Outlet Location: </th>
                                            <td style="text-align:left">{{ outlet.location && outlet.location.name }}</td>
                                        </tr>
                                         <tr>
                                            <th>Outlet City: </th>
                                            <td style="text-align:left">{{ outlet.city && outlet.city.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Operating Hours: </th>
                                            <td style="text-align:left">{{ outlet.opening_hr }} - {{ outlet.closing_hr }}</td>
                                        </tr>
                                    </table>
                                    <div class="btn_span">
                                        <v-btn dark color="#3a40fb" elevation="10" small @click="editOutlet">Edit</v-btn>
                                        <v-btn dark outline color="purple" elevation="10" small @click="changeImage">Change Image</v-btn>
                                        <v-btn dark color="red" elevation="10" small>Delete Outlet</v-btn>
                                    </div>
                                    <v-layout justify-center>
                                        <v-dialog v-model="editDialog" persistent max-width="600px">
                                            <v-card class="">
                                                <v-card-title class="justify-center">
                                                    <span class="title mt-2">Edit Outlet Details</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="Outlet Name*" v-model="editDetails.name" required v-validate="'required|max:100'" :counter="60" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Phone Number" v-model="editDetails.phone" required hint="Phone number" v-validate="'required'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-textarea label="Address" auto-grow rows="1" v-model="editDetails.address" required hint="Restaurant's address" v-validate="'required|max:120'" :counter="120" :error-messages="errors.collect('address')" data-vv-name="address"></v-textarea>
                                                            </v-flex>
                                                            <v-flex xs6>
                                                                <v-text-field label="City" readonly :value="editDetails.city && editDetails.city.name"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs6>
                                                                <v-text-field label="Location" readonly :value="outlet.location && outlet.location.name"></v-text-field>
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
                                                    <v-btn color="blue darken-3 white--text" @click="updateOutlet" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="changePic" max-width="350">
                                            <v-card>
                                                <v-card-title class="subheading justify-center">Replace Outlet Logo</v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap align-center justify-space-around>
                                                            <v-flex xs12>
                                                                <input type="file" style="display:none" ref="fileInput" @change="handleUpload" accept="image/*">
                                                                <v-btn raised class="primary" @click.prevent="chooseFile"> Change Logo</v-btn>
                                                            </v-flex>
                                                            <v-flex xs12 v-if="previewImg">
                                                                <img :src="newImageUrl" height="150" width="100%"><br>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-flex xs12 v-if="previewImg">
                                                        <v-spacer></v-spacer>
                                                        <v-btn flat dark color="red darken-3" @click.prevent="changePic = false"> Close</v-btn>
                                                        <v-btn raised class="primary" @click.prevent="saveFile" :disabled="savingDetails" :loading="savingDetails"> Save</v-btn>
                                                    </v-flex>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-snackbar v-model="outletEditedSuccess" :timeout="5000" top color="#44a80f">
                                            The outlet details have been updated successfully.
                                            <v-btn color="coral" flat  @click="outletEditedSuccess = false">Close</v-btn>
                                        </v-snackbar>
                                        <v-snackbar v-model="changePicSuccess" :timeout="5000" top color="#44a80f">
                                            The outlet logo has been updated successfully.
                                            <v-btn color="coral" flat  @click="changePicSuccess = false">Close</v-btn>
                                        </v-snackbar>
                                    </v-layout>
                                </div>
                            </v-flex>
                        </v-layout>
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
            id: this.$route.params.id,
            outlet: null,
            editDialog: false,
            editDetails: {},
            savingDetails: false,
            errorMsg: '',
            outletEditedSuccess: false,
            outletToUpdate: {},
            hours: ['12:00am', '1:00am', '2:00am', '3:00am', '4:00am', '5:00am', '6:00am', '7:00am',
                   '8:00am', '9:00am', '10:00am', '11:00am', '12:00pm', '1:00pm', '2:00pm', '3:00pm',
                   '4:00pm', '5:00pm', '6:00pm', '7:00pm', '8:00pm', '9:00pm', '10:00pm', '11:00pm'],
            locs: [],
            changePic: false,
            previewImg: false,
            newFile: null,
            newImageUrl: null,
            changePicSuccess: false
        }
    },
    methods: {
        getOutlet(){
            axios.get(`/admin_getoutlet/${this.id}`).then((res) => {
                this.outlet = res.data
            })
        },
        changeImage(){
            this.changePic = true
        },
        chooseFile(){
            this.$refs.fileInput.click()
        },
        handleUpload(e){
            this.previewImg = true
            const file = e.target.files[0]
            this.newFile = file
            let fileName = file.name
            this.newImageUrl = URL.createObjectURL(file)
        },
        saveFile(){
            if(this.newFile !== null){
                this.savingDetails = true
                const config = {headers: {
                            'Content-Type' : 'multipart/form-data',
                        }
                    };

                let vm = this; 

                const form = new FormData();
                form.append('file', vm.newFile)

                axios.post(`/admin_updaterestaurantlogo/${this.id}`, form, config).then((res) => {
                    this.savingDetails = false
                    console.log(res.data)
                    this.changePic = false
                    this.changePicSuccess = true
                    vm.outlet.picture = res.data
                }).catch((err) => {
                    this.savingDetails = false
                })
            }
        },
        editOutlet(){
            this.editDialog = true;
            this.editDetails.name = this.outlet.name
            this.editDetails.address = this.outlet.address
            this.editDetails.phone = this.outlet.phone
            this.editDetails.location = this.outlet.location_id
            this.editDetails.opening_hr = this.outlet.opening_hr
            this.editDetails.closing_hr = this.outlet.closing_hr
            axios.get(`/admin_getalllocsincity/${this.outlet.city_id}`).then((res) => {
                this.locs = res.data
            })
        },
        updateOutlet(){
             this.$validator.validateAll().then((isValid) =>{
                if(isValid){ 
                    this.savingDetails = true
                    axios.post(`/admin_updateoutlet/${this.id}`, {
                        outlet: this.editDetails
                    }).then((res) => {
                        console.log(res.data)
                        this.savingDetails = false
                        this.outletEditedSuccess = true
                        this.editDialog = false;
                        this.outlet = res.data
                    }).catch((err) => {
                        this.savingDetails = false
                    })
                }
             })
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
    },
    mounted() {
        this.getOutlet()
    },
}
</script>

<style lang="scss" scoped>
    table{
        table-layout: fixed;
        width: 25rem;

        tr{
            height: 2.5rem;
        }
    }
</style>
