<template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs12 sm3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs12 sm9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Users Management - Client Users</div>
                        <v-divider></v-divider>
                        <v-btn dark color="coral" elevation="10" round small @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                        <v-layout row wrap my-4>
                            <v-flex xs10 offset-xs1>
                                <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!user"></v-progress-circular>
                                <div v-if="user">
                                    <table class="table table-responsive table-hover">
                                        <tr>
                                            <th>Fullname: </th>
                                            <td style="text-align:left">{{ user.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email: </th>
                                            <td style="text-align:left">{{ user.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone: </th>
                                            <td style="text-align:left">{{ user.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alternate Phone: </th>
                                            <td style="text-align:left">{{ user.alt_phone || 'Not filled' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td style="text-align:left">{{ user.address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td style="text-align:left">{{ user.location && user.location.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status: </th>
                                            <td style="text-align:left">{{ user.account_status }}</td>
                                        </tr>
                                    </table>
                                    <div class="btn_span">
                                        <v-btn v-if="user.status == 1" dark color="error" elevation="10" small @click.stop="disableDialog = true">Disable</v-btn>
                                        <v-btn v-if="user.status == 0" dark color="#01bd08" elevation="10" small @click.prevent="enableDialog = true">Enable</v-btn>
                                        <v-btn dark color="#3a40fb" elevation="10" small @click="editUser">Edit</v-btn>
                                        <v-btn dark outline color="purple" elevation="10" small @click="changePswdDialog = true">Change Password</v-btn>
                                        <v-btn dark color="red" elevation="10" small>Delete User</v-btn>
                                    </div>
                                    <v-layout justify-center>
                                        <v-dialog v-model="disableDialog" max-width="350">
                                            <v-card>
                                                <v-card-title class="subheading justify-center">Confirm Disable User?</v-card-title>
                                                <v-spacer></v-spacer>
                                                <v-card-text> Do you want to disable this user?</v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="red darken-1" text @click="disableDialog = false"> No </v-btn>
                                                    <v-btn color="#3a40fb" dark text @click="disableUser">Disable</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="enableDialog" max-width="350">
                                            <v-card>
                                                <v-card-title class="subheading justify-center">Confirm Enable user?</v-card-title>
                                                <v-spacer></v-spacer>
                                                <v-card-text> Do you want to enable this user?</v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="red darken-1" text @click="enableDialog = false"> No </v-btn>
                                                    <v-btn color="#3a40fb" dark text @click="enableUser">Enable</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="editDialog" persistent max-width="600px">
                                            <v-card class="">
                                                <v-card-title class="justify-center">
                                                    <span class="title mt-2">Edit client user Profile</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="Fullname*" v-model="editDetails.fullname" required hint="Users full names" v-validate="'required|max:60'" :error-messages="errors.collect('edit.name')" data-vv-name="name" data-vv-scope='name'></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Phone Number*S" v-model="editDetails.phone" required hint="Phone number" v-validate="'required|numeric'" :error-messages="errors.collect('edit.phone')" data-vv-name="phone" data-vv-scope='edit'></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Alternate Phone No" v-model="editDetails.alt_phone" hint="User's alternate phone number"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-textarea label="Address*" auto-grow rows="1" v-model="editDetails.address" required hint="User's address" v-validate="'required|max:120'" :error-messages="errors.collect('edit.address')" data-vv-name="address" data-vv-scope='edit'></v-textarea>
                                                            </v-flex>
                                                            <v-flex xs6>
                                                                <v-text-field label="Location" readonly :value="user.location && user.location.name"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs6>
                                                                <v-select label="Change Location" :items="locations" item-text="name" item-value="id" v-model="editDetails.location" required hint="Change User's location"></v-select>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Email" readonly v-model="editDetails.email"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat dark color="red darken-3" @click="editDialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-3 white--text" @click="updateUser" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="changePswdDialog" persistent max-width="450px">
                                            <v-card class="">
                                                <v-card-title class="justify-center">
                                                    <span class="title mt-2">Change User Password - {{ user.name }}</span>
                                                    <span class="pink lighten-4 red--text mt-2 pa-2" v-if="pswdChangeError">{{ errorMsg }}</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="New Password*" type="password" v-model="userNewPswd" required></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Confirm New Password" type="password" v-model="userPswdConfirm" required hint="Re-enter the new password"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat dark color="red darken-3" @click="changePswdDialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-3 white--text" @click="updateUserPswd" :disabled="savingPswd" :loading="savingPswd"> Save </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-snackbar v-model="acct_edited_success" :timeout="6000" top color="#44a80f">
                                            The User details have been updated successfully.
                                            <v-btn color="coral" flat  @click="acct_edited_success = false">Close</v-btn>
                                        </v-snackbar>
                                        <v-snackbar v-model="pswd_chng_success" :timeout="6000" top color="#44a80f">
                                            The user Password has been changed successfully.
                                            <v-btn color="coral" flat  @click="pswd_chng_success = false">Close</v-btn>
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
            user: null,
            disableDialog: false,
            enableDialog: false,
            editDialog: false,
            editDetails: {
                fullname: '',
                phone: '',
                alt_phone: '',
                address: '',
                location: null,
                email: '',
            },
            savingDetails: false,
            changePswdDialog: false,
            userNewPswd: '',
            userPswdConfirm: '',
            savingPswd: false,
            pswdChangeError: false,
            errorMsg: '',
            acct_edited_success: false,
            pswd_chng_success: false,
            locations: []
        }
    },
    methods: {
        getUser(){
            axios.get(`/admin_getuser/${this.id}`).then((res) => {
                this.user = res.data
                console.log(res.data)
            })
        },
        disableUser(){
            axios.post(`/admin_disableuser/${this.id}`).then((res) => {
                console.log(res)
                this.disableDialog = false
                this.user.status = 0;
                this.user.account_status = 'Disabled'
            })
        },
        enableUser(){
            axios.post(`/admin_enableuser/${this.id}`).then((res) => {
                console.log(res)
                this.enableDialog = false
                this.user.status = 1;
                this.user.account_status = 'Enabled'
            })
        },
        editUser(){
            this.editDialog = true;
            this.editDetails.fullname = this.user.name
            this.editDetails.phone = this.user.phone
            this.editDetails.alt_phone = this.user.alt_phone
            this.editDetails.address = this.user.address
            this.editDetails.location = this.user.location_id
            this.editDetails.email = this.user.email
        },
        updateUser(){
            if(this.editDetails !== null){
                this.savingDetails = true
                axios.post(`/admin_updateuser/${this.id}`, {
                    user: this.editDetails
                }).then((res) => {
                    console.log(res.data)
                    this.savingDetails = false
                    this.acct_edited_success = true
                    this.editDialog = false;
                    this.user = res.data
                })
            }
        },
        updateUserPswd(){
            if(this.userNewPswd.length > 4 && this.userNewPswd === this.userPswdConfirm){
                this.savingPswd = true
                axios.post(`/admin_changeuserpswd/${this.id}`, {
                    password: this.userNewPswd
                }).then((res) => {
                    this.savingPswd = false
                    this.pswd_chng_success = true
                    this.changePswdDialog = false
                    this.userNewPswd = ''
                    this.userPswdConfirm = ''
                })
            }else{
                this.userNewPswd = ''
                this.userPswdConfirm = ''
                this.pswdChangeError = true
                this.errorMsg = 'Either New Password and confirm password do not match or password invalid'
            }
        },
        getLocations(){
            axios.get('/admin_getalllocations').then((res) => {
                this.locations = res.data
            })
        }
    },
    mounted() {
        this.getUser()

        this.getLocations()
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
