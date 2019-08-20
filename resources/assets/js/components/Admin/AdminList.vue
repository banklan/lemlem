<template>
    <v-app>
    <v-layout row wrap>
        <v-flex xs3>
            <nav-drawer></nav-drawer>
        </v-flex>
        <v-flex xs9>
            <v-layout row wrap class="pa-4">
                <v-flex xs12>
                    <div class="subheading dark-grey--text">Admin Users Management</div>
                    <v-divider></v-divider>
                    <v-layout row wrap>
                        <v-flex xs10 offset-xs1>
                            <v-btn dark color="coral" ripple elevation="10" round @click="CreateDialog = true"><v-icon left>add</v-icon>Create Admin</v-btn>
                            <div class="subheading pa-3">Number of Admins: {{ admins.length }}</div>
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
                                    <tr v-for="(admin, index) in admins" :key="admin.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ admin.id }}</td>
                                        <td>{{ admin.fullname }}</td>
                                        <td>{{ admin.status }}</td>
                                        <td style="text-align:center"><v-btn small flat :to="{name: 'adminShow', params:{id: admin.id}}"><v-icon color="grey">visibility</v-icon></v-btn></td>
                                        <td style="text-align:center"><v-btn small color="blue white--text" v-if="!admin.self" @click.prevent="openEditDialog(admin)"><v-icon>edit</v-icon></v-btn> <v-btn small color="red white--text" @click.prevent="openDelDialog(admin, index)" v-if="!admin.self"><v-icon>delete_forever</v-icon></v-btn></td>
                                    </tr>
                                </tbody>
                            </table>
                        </v-flex>
                    </v-layout>
                    <v-dialog v-model="CreateDialog" persistent max-width="550px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Create a New Admin Account</span>
                                <!-- <span class="pink lighten-4 red--text mt-2 pa-2" v-if="pswdChangeError">{{ errorMsg }}</span> -->
                            </v-card-title>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field label="Fullname*" v-model="newAdmin.fullname" required v-validate="'required|max:60'" :counter="60" :error-messages="errors.collect('fullname')" data-vv-name="fullname"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Email*" v-model="newAdmin.email" type="email" required v-validate="'required|email'" :error-messages="errors.collect('email')" data-vv-name="email"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-text-field label="Phone No*" v-model="newAdmin.phone" required v-validate="'required|numeric'" :error-messages="errors.collect('phone')" data-vv-name="phone"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12>
                                            <v-select :items="status" item-text="name" item-value="id" label="Status" v-model="newAdmin.status" v-validate="'required'" :error-messages="errors.collect('status')" data-vv-name="status"></v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat dark color="red darken-3" @click.prevent="CreateDialog = false">Close</v-btn>
                                <v-btn color="blue darken-3 white--text" :disabled="savingAdmin" :loading="savingAdmin" @click="createAdmin"> Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="delDialog" max-width="350">
                        <v-card>
                            <v-card-title class="subheading justify-center">Confirm Delete Admin?</v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-text> Do you want to delete the admin <strong>{{ adminToDelete && adminToDelete.fullname }}</strong>? Once deleted, you will not be able to retrieve account.</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat color="red darken-1" text @click="delDialog = false"> No </v-btn>
                                <v-btn color="#3a40fb" dark text @click="delAdmin(adminToDelete, adminToDelIndex)">Delete</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="editDialog" persistent max-width="600px">
                        <v-card class="">
                            <v-card-title class="justify-center">
                                <span class="title mt-2">Edit Admin Profile - {{ adminToUpdate && adminToUpdate.fullname }} </span>
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
                                <v-btn color="blue darken-3 white--text" @click="updateAdmin(adminToUpdate)" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-snackbar v-model="created_success" :timeout="6000" top color="#44a80f">
                        Admin was successfully created.
                        <v-btn color="coral" flat @click="created_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="deleted_success" :timeout="6000" top color="#44a80f">
                        Admin was successfully deleted.
                        <v-btn color="coral" flat @click="deleted_success = false">Close</v-btn>
                    </v-snackbar>
                    <v-snackbar v-model="edited_success" :timeout="6000" top color="#44a80f">
                        Admin details was successfully updated.
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
            admins: [],
            CreateDialog: false,
            newAdmin: {
                fullname: '',
                phone: '',
                email: '',
                status: ''
            },
            savingAdmin: false,
            status: [
                {name: 'Enable', id: 1},
                {name: 'Disable', id: 0}
            ],
            created_success: false,
            delDialog: false,
            adminToDelete: null,
            adminToDelIndex: null,
            deleted_success: false,
            editDialog: false,
            adminToUpdate: null,
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
        getAdmins(){
            axios.get('/admin_get_alladmins').then((res) => {
                this.admins = res.data
                console.log(res.data)
            })
        },
        createAdmin(){
            console.log(this.newAdmin)
            this.$validator.validateAll().then(() =>{
                this.savingAdmin = true
                let vm = this
                axios.post('/admin_createnewadmin/', {
                    admin: this.newAdmin
                }).then((res) =>{
                    this.closeCreateDialog()
                    this.savingAdmin = false
                    this.created_success = true
                    this.admins.unshift(res.data)
                    console.log(res.data)
                }).catch((err) => {
                    this.savingAdmin = false
                })
            })
        },
        closeCreateDialog(){
            this.$validator.reset()
            this.newAdmin.fullname = ''
            this.newAdmin.phone = ''
            this.newAdmin.email = ''
            this.newAdmin.status = ''
            this.CreateDialog = false
        },
        openDelDialog(admin, index){
            this.delDialog = true
            this.adminToDelete = admin
            this.adminToDelIndex = index
        },
        delAdmin(admin, index){
            axios.post(`/admin_deleteadmin/${admin.id}`).then((res) => {
                this.delDialog = false
                this.admins.splice(index, 1)
                this.deleted_success = true
            })
        },
        openEditDialog(admin){
            this.editDialog = true
            this.adminToUpdate = admin
            this.editDetails.fullname = admin.fullname
            this.editDetails.phone = admin.phone
            this.editDetails.email = admin.email
        },
        updateAdmin(adminToUpdate){
            this.$validator.validateAll('edit').then((isValid) =>{
                if(isValid){
                    this.savingDetails = true
                    axios.post(`/admin_updateadmin/${adminToUpdate.id}`, {
                        admin: this.editDetails
                    }).then((res) => {
                        this.savingDetails = false
                        this.editDialog = false
                        this.getAdmins()
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
        this.getAdmins()
        // this.admins
    },
}
</script>

<style scoped>
    table th{
        text-align: center;
    }
</style>
