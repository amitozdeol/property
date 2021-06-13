<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Add Tenant</p>
                <button type="button" class="delete" @click="$emit('close')" />
            </header>
            <section class="modal-card-body">
                <b-field label="Name">
                    <b-input type="name" v-model="name" placeholder="Name" required></b-input>
                </b-field>
                <b-field label="Phone">
                    <b-input type="tel" v-model="phone" placeholder="e.g. 000-000-0000" required></b-input>
                </b-field>
                <b-field label="Email">
                    <b-input type="email" v-model="email" placeholder="e.g. bobsmith@gmail.com" required></b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <b-button label="Close" @click="$emit('close')" />
                <b-button label="Add" type="is-success" @click="add()"/>
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
                email: ""
            }
        },
        methods:{
            add(){
                axios.post('/tenant/store', {
                    unit_id: this.unit_id,
                    name: this.name,
                    phone: this.phone,
                    email: this.email
                });
            }
        }
    }
</script>

<style>

</style>
