<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Tenant</p>
                <button type="button" class="delete" @click="$emit('close')" />
            </header>
            <section class="modal-card-body columns mb-0">
                <div class="column is-mobile">
                    <b-field label="Name" :type="{'is-danger': error.name}" :message="error.name || ''">
                        <b-input type="name" v-model="name" placeholder="Name" required></b-input>
                    </b-field>
                    <b-field label="Phone" :type="{'is-danger': error.phone}" :message="error.phone || ''">
                        <b-input type="tel" v-model="phone" placeholder="e.g. 000-000-0000" required></b-input>
                    </b-field>
                </div>
                <div class="column is-mobile">
                    <b-field label="Email" :type="{'is-danger': error.email}" :message="error.email || ''">
                        <b-input type="email" v-model="email" placeholder="e.g. bobsmith@gmail.com" required></b-input>
                    </b-field>
                    <b-field label="Lease Start" :type="{'is-danger': error.lease_start}" :message="error.lease_start || ''">
                        <b-input type="date" v-model="lease_start" required></b-input>
                    </b-field>
                    <b-field label="Lease End" :type="{'is-danger': error.lease_end}" :message="error.lease_end || ''">
                        <b-input type="date" v-model="lease_end" required></b-input>
                    </b-field>
                </div>
            </section>
            <footer class="modal-card-foot">
                <b-button label="Close" @click="$emit('close')" />
                <b-button label="Add" type="is-success" @click="add()" :disabled="is_loading" :loading="is_loading"/>
            </footer>
        </div>
    </form>
</template>

<script>
    import axios from './../../../axios';

    export default {
        props:['unit_id'],
        data(){
            return {
                name: "",
                phone: "",
                email: "",
                lease_start: "",
                lease_end: "",
                is_loading: false,
                error: {name: '', phone: '', email: '', lease_start: "", lease_end: "" }
            }
        },
        methods:{
            async add(){
                this.is_loading = true;
                try {
                    const data = {
                                    unit_id: this.unit_id,
                                    name: this.name,
                                    phone: this.phone,
                                    email: this.email,
                                    lease_start: this.lease_start,
                                    lease_end: this.lease_end
                                };
                    const res = await axios.post('/tenant/store', data);
                    this.$emit('update', data);
                    this.$emit('close');
                } catch (err) {
                    this.error = err.response?.data?.errors
                }
                this.is_loading = false;
            }
        }
    }
</script>

<style>

</style>
