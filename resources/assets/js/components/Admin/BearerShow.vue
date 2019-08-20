<template>
    <v-app>
        <v-layout row wrap>
            <v-flex xs12 sm3>
                <nav-drawer></nav-drawer>
            </v-flex>
            <v-flex xs12 sm9>
                <v-layout row wrap class="pa-4">
                    <v-flex xs12>
                        <div class="subheading dark-grey--text">Admin Users Management - Bearer</div>
                        <v-divider></v-divider>
                        <v-btn dark color="coral" elevation="10" round small @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                        <v-layout row wrap my-4>
                            <v-flex xs10 offset-xs1>
                                <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!bearer"></v-progress-circular>
                                <div v-if="bearer">
                                    <table class="table table-responsive table-hover">
                                        <tr>
                                            <th>Fullname: </th>
                                            <td style="text-align:left">{{ bearer.fullname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email: </th>
                                            <td style="text-align:left">{{ bearer.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone: </th>
                                            <td style="text-align:left">{{ bearer.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status: </th>
                                            <td style="text-align:left">{{ bearer.account_status }}</td>
                                        </tr>
                                    </table>
                                    <div class="btn_span">
                                        <v-btn v-if="bearer.status == 1" dark color="error" elevation="10" small @click.stop="disableDialog = true">Disable</v-btn>
                                        <v-btn v-if="!bearer.status == 1" dark color="#01bd08" elevation="10" small @click.prevent="enableDialog = true">Enable</v-btn>
                                        <v-btn dark color="#3a40fb" elevation="10" small @click="editBearer">Edit</v-btn>
                                        <v-btn dark outline color="purple" elevation="10" small @click="changePswdDialog = true">Change Password</v-btn>
                                        <v-btn dark color="red" elevation="10" small>Delete User</v-btn>
                                    </div>
                                    <v-layout justify-center>
                                        <v-dialog v-model="disableDialog" max-width="350">
                                            <v-card>
                                                <v-card-title class="subheading justify-center">Confirm Disable Bearer?</v-card-title>
                                                <v-spacer></v-spacer>
                                                <v-card-text> Do you want to disable this bearer?</v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="red darken-1" text @click="disableDialog = false"> No </v-btn>
                                                    <v-btn color="#3a40fb" dark text @click="disableBearer">Disable</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="enableDialog" max-width="350">
                                            <v-card>
                                                <v-card-title class="subheading justify-center">Confirm Enable Bearer?</v-card-title>
                                                <v-spacer></v-spacer>
                                                <v-card-text> Do you want to enable this bearer?</v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="red darken-1" text @click="enableDialog = false"> No </v-btn>
                                                    <v-btn color="#3a40fb" dark text @click="enableBearer">Enable</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="editDialog" persistent max-width="600px">
                                            <v-card class="">
                                                <v-card-title class="justify-center">
                                                    <span class="title mt-2">Edit Bearer Profile</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="Fullname*" v-model="editDetails.fullname" required></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Phone Number" v-model="editDetails.phone" required hint="Phone number"></v-text-field>
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
                                                    <v-btn color="blue darken-3 white--text" @click="updateBearer" :disabled="savingDetails" :loading="savingDetails">Save </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog v-model="changePswdDialog" persistent max-width="450px">
                                            <v-card class="">
                                                <v-card-title class="justify-center">
                                                    <span class="title mt-2">Change Bearer Password - {{ bearer.fullname }}</span>
                                                    <span class="pink lighten-4 red--text mt-2 pa-2" v-if="pswdChangeError">{{ errorMsg }}</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="New Password*" type="password" v-model="bearerNewPswd" required></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs12>
                                                                <v-text-field label="Confirm New Password" type="password" v-model="bearerPswdConfirm" required hint="Re-enter the new password"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat dark color="red darken-3" @click="changePswdDialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-3 white--text" @click="updateBearerPswd" :disabled="savingPswd" :loading="savingPswd"> Save </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-snackbar v-model="acct_edited_success" :timeout="6000" top color="#44a80f">
                                            The Bearer details have been updated successfully.
                                            <v-btn color="coral" flat  @click="acct_edited_success = false">Close</v-btn>
                                        </v-snackbar>
                                        <v-snackbar v-model="pswd_chng_success" :timeout="6000" top color="#44a80f">
                                            The Bearer Password has been changed successfully.
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
            bearer: null,
            disableDialog: false,
            enableDialog: false,
            editDialog: false,
            editDetails: {
                fullname: '',
                phone: '',
                email: ''
            },
            savingDetails: false,
            changePswdDialog: false,
            bearerNewPswd: '',
            bearerPswdConfirm: '',
            savingPswd: false,
            pswdChangeError: false,
            errorMsg: '',
            acct_edited_success: false,
            pswd_chng_success: false
        }
    },
    methods: {
        getBearer(){
            axios.get(`/admin_getbearer/${this.id}`).then((res) => {
                this.bearer = res.data
            })
        },
        disableBearer(){
            axios.post(`/admin_disablebearer/${this.id}`).then((res) => {
                console.log(res)
                this.disableDialog = false
                this.bearer.status = 0;
                this.bearer.account_status = 'Disabled'
            })
        },
        enableBearer(){
            axios.post(`/admin_enablebearer/${this.id}`).then((res) => {
                console.log(res)
                this.enableDialog = false
                this.bearer.status = 1;
                this.bearer.account_status = 'Enabled'
            })
        },
        editBearer(){
            this.editDialog = true;
            this.editDetails.fullname = this.bearer.fullname
            this.editDetails.phone = this.bearer.phone
            this.editDetails.email = this.bearer.email
        },
        updateBearer(){
            if(this.editDetails !== null){
                this.savingDetails = true
                axios.post(`/admin_updatebearer/${this.id}`, {
                    update: this.editDetails
                }).then((res) => {
                    console.log(res.data)
                    this.savingDetails = false
                    this.acct_edited_success = true
                    this.editDialog = false;
                    this.bearer = res.data
                })
            }
        },
        updateBearerPswd(){
            if(this.bearerNewPswd.length > 4 && this.bearerNewPswd === this.bearerPswdConfirm){
                this.savingPswd = true
                axios.post(`/admin_changebearerpswd/${this.id}`, {
                    password: this.bearerNewPswd
                }).then((res) => {
                    this.savingPswd = false
                    this.pswd_chng_success = true
                    this.changePswdDialog = false
                    this.bearerNewPswd = ''
                    this.bearerPswdConfirm = ''
                })
            }else{
                this.bearerNewPswd = ''
                this.bearerPswdConfirm = ''
                this.pswdChangeError = true
                this.errorMsg = 'Either New Password and confirm password do not match or password invalid'
            }
        }
    },
    mounted() {
        this.getBearer()
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
