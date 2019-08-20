<template>
    <v-app>
    <v-layout row wrap>
        <v-flex xs3>
            <nav-drawer></nav-drawer>
        </v-flex>
        <v-flex xs9>
            <v-layout row wrap class="pa-4">
                <v-flex xs12>
                    <div class="subheading dark-grey--text">Admin Users Management - Client Users List</div>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs10 offset-xs1>
                            <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Create New Client User</v-btn>
                            <div class="subheading pa-3">Number of Users: {{ users.length }}</div>
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
                                    <tr v-for="(user, index) in users" :key="user.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.status }}</td>
                                        <td style="text-align:center"><v-btn small flat :to="{name: 'clientUserShow', params:{id: user.id}}"><v-icon color="grey">visibility</v-icon></v-btn></td>
                                        <td style="text-align:center"><v-btn small color="blue white--text" @click.prevent="openEditDialog(user)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(user, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-flex>
                    </v-layout>
                    <v-dialog v-model="CreateDialog" persistent max-width="550px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Create a New User Account</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field label="Fullname*" v-model="newUser.fullname" required v-validate="'required|max:60'" :counter="60" :error-messages="errors.collect('fullname')" data-vv-name="fullname"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Email*" v-model="newUser.email" type="email" required v-validate="'required|email'" :error-messages="errors.collect('email')" data-vv-name="email"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Phone No*" v-model="newUser.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-textarea label="Address" rows="1" v-model="newUser.address" auto-grow required v-validate="'required|max:120'" :counter="120" :error-messages="errors.collect('address')" data-vv-name="address"></v-textarea>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-select :items="locations" item-text="name" item-value="id" label="Choose Location" v-model="newUser.location" v-validate="'required'" :error-messages="errors.collect('location')" data-vv-name="location" required></v-select>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-select :items="status" item-text="name" item-value="id" label="Status" v-model="newUser.status" v-validate="'required'" :error-messages="errors.collect('status')" data-vv-name="status"></v-select>
                                        </v-flex>
                                        <v-flex xs12>
                                            <div class="blue lighten-2 white--text pa-2">Please note that a default password 'password' will be set for the new user account</div>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                <v-btn color="blue darken-3 white--text" :disabled="savingUser" :loading="savingUser" @click="createUser"> Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="delDialog" max-width="350">
                        <v-card>
                            <v-card-title class="subheading justify-center">Confirm Delete User?</v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-text> Do you want to delete this user <strong>{{ userToDelete && userToDelete.name }}</strong>? Once deleted, you will not be able to retrieve the account.</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                <v-btn color="#3a40fb" dark text @click="delUser(userToDelete, userToDelIndex)">Delete</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="editDialog" persistent max-width="600px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Edit Client User Profile - {{ userToUpdate && userToUpdate.name }} </span>
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
                                            <v-textarea label="Address" auto-grow rows="1" v-model="editDetails.address" required hint="User's address" v-validate="'required|max:120'" :error-messages="errors.collect('edit.address')" data-vv-name="address" data-vv-scope='edit'></v-textarea>
                                        </v-flex>
                                        <v-flex xs6>
                                            <v-text-field label="Location" readonly :value="userToUpdate && userToUpdate.location.name"></v-text-field>
                                        </v-flex>
                                        <v-flex xs6>
                                            <v-select label="Change Location" :items="locations" item-text="name" item-value="id" v-model="editDetails.location" required hint="Change User's location" v-validate="'required'" :error-messages="errors.collect('edit.location')" data-vv-name="location" data-vv-scope='edit'></v-select>
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
                                <v-btn color="blue darken-3 white--text" @click="updateUser(userToUpdate)" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-snackbar v-model="created_success" :timeout="6000" top color="#44a80f">
                        New user was successfully created.
                        <v-btn color="coral" flat @click="created_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="deleted_success" :timeout="6000" top color="#44a80f">
                        User was successfully deleted.
                        <v-btn color="coral" flat @click="deleted_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="edited_success" :timeout="6000" top color="#44a80f">
                        User profile was successfully updated.
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
            users: [],
            CreateDialog: false,
            locations: [],
            newUser: {
                fullname: '',
                phone: '',
                email: '',
                address: '',
                location: null,
                status: ''
            },
            savingUser: false,
            status: [
                {name: 'Enable', id: 1},
                {name: 'Disable', id: 0}
            ],
            created_success: false,
            delDialog: false,
            userToDelete: null,
            userToDelIndex: null,
            deleted_success: false,
            editDialog: false,
            userToUpdate: null,
            editDetails: {
                fullname: '',
                phone: '',
                email: '',
                address: '',
                location: ''
            },
            savingDetails: false,
            edited_success: false
        }
    },
    methods: {
        getUsers(){
            axios.get('/admin_get_allusers').then((res) => {
                this.users = res.data
                console.log(res.data)
            })
        },
        createUser(){
            this.$validator.validateAll().then(() =>{
                this.savingUser = true
                axios.post('/admin_createnewuser/', {
                    user: this.newUser
                }).then((res) =>{
                    this.closeCreateDialog()
                    this.savingUser = false
                    this.created_success = true
                    this.users.unshift(res.data)
                }).catch((err) => {
                    this.savingUser = false
                })
            })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newUser.name = ''
            this.newUser.phone = ''
            this.newUser.email = ''
            this.newUser.status = ''
            this.CreateDialog = false
        },
        openDelDialog(user, index){
            this.delDialog = true
            this.userToDelete = user
            this.userToDelIndex = index
        },
        delUser(user, index){
            axios.post(`/admin_deleteuser/${user.id}`).then((res) => {
                this.delDialog = false
                this.users.splice(index, 1)
                this.deleted_success = true
            })
        },
        openEditDialog(user){
            this.editDialog = true
            this.userToUpdate = user
            this.editDetails.fullname = user.name
            this.editDetails.phone = user.phone
            this.editDetails.address = user.address
            this.editDetails.location = user.location_id
            this.editDetails.email = user.email
        },
        updateUser(userToUpdate){
            this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){
                    this.savingDetails = true
                    axios.post(`/admin_updateuser/${userToUpdate.id}`, {
                        user: this.editDetails
                    }).then((res) => {
                        this.savingDetails = false
                        this.editDialog = false
                        this.getUsers()
                        this.edited_success = true
                    }).catch((err) => {
                        this.savingDetails = false
                    })
                }
            })
        },
        getLocations(){
            axios.get('/admin_getalllocations').then((res) => {
                this.locations = res.data
                // console.log(res.data)
            })
        }
    },
    mounted() {
        this.getUsers()

        this.getLocations()
    },
}
</script>

<style scoped>
    table th{
        text-align: center;
    }
</style>
