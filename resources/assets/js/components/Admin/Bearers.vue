<template>
    <v-app>
    <v-layout row wrap>
        <v-flex xs3>
            <nav-drawer></nav-drawer>
        </v-flex>
        <v-flex xs9>
            <v-layout row wrap class="pa-4">
                <v-flex xs12>
                    <div class="subheading dark-grey--text">Bearers Management</div>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs10 offset-xs1>
                            <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Create Bearer</v-btn>
                            <div class="subheading pa-3">Number of Bearers: {{ bearers.length }}</div>
                            <table class="table table-responsive table-hover table-bordered table-condensed table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bearer, index) in bearers" :key="bearer.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bearer.id }}</td>
                                        <td>{{ bearer.fullname }}</td>
                                        <td>{{ bearer.status }}</td>
                                        <td style="text-align:center"><v-btn small flat :to="{name: 'bearerShow', params:{id: bearer.id}}"><v-icon color="grey">visibility</v-icon></v-btn></td>
                                        <td style="text-align:center"><v-btn small color="blue white--text" @click.prevent="openEditDialog(bearer)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(bearer, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-flex>
                    </v-layout>
                    <v-dialog v-model="CreateDialog" persistent max-width="550px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Create a New Bearer User</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field label="Fullname*" v-model="newBearer.fullname" required v-validate="'required|max:60'" :counter="60" :error-messages="errors.collect('fullname')" data-vv-name="fullname"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Email*" v-model="newBearer.email" type="email" required v-validate="'required|email'" :error-messages="errors.collect('email')" data-vv-name="email"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Phone No*" v-model="newBearer.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-select :items="status" item-text="name" item-value="id" label="Status" v-model="newBearer.status" v-validate="'required'" :error-messages="errors.collect('status')" data-vv-name="status"></v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                <v-btn color="blue darken-3 white--text" :disabled="savingBearer" :loading="savingBearer" @click="createBearer"> Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="delDialog" max-width="350">
                        <v-card>
                            <v-card-title class="subheading justify-center">Confirm Delete Bearer?</v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-text> Do you want to delete this Bearer Account <strong>{{ bearerToDelete && bearerToDelete.fullname }}</strong>? Once deleted, you will not be able to retrieve account.</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                <v-btn color="#3a40fb" dark text @click="delBearer(bearerToDelete, bearerToDelIndex)">Delete</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="editDialog" persistent max-width="600px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Edit Bearer Profile - {{ bearerToUpdate && bearerToUpdate.fullname }} </span>
                            </v-card-title>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field label="Fullname*" v-model="editDetails.fullname" required v-validate="'required|max:60'" :counter="60" :error-messages="errors.collect('edit.fullname')" data-vv-name="fullname" data-vv-scope='edit'></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Phone Number" v-model="editDetails.phone" required hint="Phone number" v-validate="'required'" :error-messages="errors.collect('edit.phone')" data-vv-name="phone" data-vv-scope='edit'></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Email*" readonly v-model="editDetails.email"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat dark color="red darken-3" @click="editDialog = false">Close</v-btn>
                                <v-btn color="blue darken-3 white--text" @click="updateBearer(bearerToUpdate)" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-snackbar v-model="created_success" :timeout="6000" top color="#44a80f">
                        Bearer was successfully created.
                        <v-btn color="coral" flat @click="created_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="deleted_success" :timeout="6000" top color="#44a80f">
                        Bearer was successfully deleted.
                        <v-btn color="coral" flat @click="deleted_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="edited_success" :timeout="6000" top color="#44a80f">
                        Bearer details was successfully updated.
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
            bearers: [],
            CreateDialog: false,
            newBearer: {
                fullname: '',
                phone: '',
                email: '',
                status: ''
            },
            savingBearer: false,
            status: [
                {name: 'Enable', id: 1},
                {name: 'Disable', id: 0}
            ],
            created_success: false,
            delDialog: false,
            bearerToDelete: null,
            bearerToDelIndex: null,
            deleted_success: false,
            editDialog: false,
            bearerToUpdate: null,
            editDetails: {
                fullname: '',
                phone: '',
                email: ''
            },
            savingDetails: false,
            edited_success: false
        }
    },
    methods: {
        getBearers(){
            axios.get('/admin_get_allbearers').then((res) => {
                this.bearers = res.data
                console.log(res.data)
            })
        },
        createBearer(){
            // console.log(this.newAdmin)
            this.$validator.validateAll().then(() =>{
                this.savingBearer = true
                axios.post('/admin_createnewbearer/', {
                    bearer: this.newBearer
                }).then((res) =>{
                    this.closeCreateDialog()
                    this.savingBearer = false
                    this.created_success = true
                    this.bearers.unshift(res.data)
                    console.log(res.data)
                }).catch((err) => {
                    this.savingBearer = false
                })
            })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newBearer.fullname = ''
            this.newBearer.phone = ''
            this.newBearer.email = ''
            this.newBearer.status = ''
            this.CreateDialog = false
        },
        openDelDialog(bearer, index){
            this.delDialog = true
            this.bearerToDelete = bearer
            this.bearerToDelIndex = index
        },
        delBearer(bearer, index){
            axios.post(`/admin_deletebearer/${bearer.id}`).then((res) => {
                this.delDialog = false
                this.bearers.splice(index, 1)
                this.deleted_success = true
            })
        },
        openEditDialog(bearer){
            this.editDialog = true
            this.bearerToUpdate = bearer
            this.editDetails.fullname = bearer.fullname
            this.editDetails.phone = bearer.phone
            this.editDetails.email = bearer.email
        },
        updateBearer(bearerToUpdate){
            this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){
                    this.savingDetails = true
                    axios.post(`/admin_updatebearer/${bearerToUpdate.id}`, {
                        bearer: this.editDetails
                    }).then((res) => {
                        this.savingDetails = false
                        this.editDialog = false
                        this.getBearers()
                        // console.log(res.data)
                        this.edited_success = true
                    }).catch((err) => {
                        this.savingDetails = false
                    })
                }
            })
        }
    },
    mounted() {
        this.getBearers()
        // this.admins
    },
}
</script>

<style scoped>
    table th{
        text-align: center;
    }
</style>
