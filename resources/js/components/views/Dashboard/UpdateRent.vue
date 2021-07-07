<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Update Rent</p>
                <button type="button" class="delete" @click="$emit('close')" />
            </header>
            <section class="modal-card-body columns mb-0">
                <div class="column is-mobile is-half">
                    <ul class="is-size-7">
                        <li>Name: <strong>{{data.name |capitalize}}</strong></li>
                        <li>Email: <strong>{{data.email}}</strong></li>
                        <li>Rent due: <strong>{{rentDue | formatDate}}</strong></li>
                        <li>Rent: <strong>${{data.rent}}</strong></li>
                    </ul>
                </div>
                <div class="column is-mobile is-half">
                    <label class="b-checkbox checkbox mb-4">
                        <input type="checkbox" autocomplete="on" true-value="Yes" false-value="No" v-model="fully_paid" @change="fullyPaid()">
                        <span class="check"></span>
                        <span class="control-label"> Fully Paid </span>
                    </label>
                    <b-field label="Rent" :type="{'is-danger': (error.rent)}" :message="error.rent" label-position="on-border">
                        <b-input placeholder="$500" type="number" v-model.number="rent" min="1" :max="data.rent" step="0.01" :disabled="fully_paid == 'Yes'">
                        </b-input>
                    </b-field>
                </div>
            </section>
            <footer class="modal-card-foot">
                <b-button label="Close" @click="$emit('close')" />
                <b-button label="Save" type="is-success" @click="add()" :disabled="is_loading" :loading="is_loading"/>
            </footer>
        </div>
    </form>
</template>

<script>
    import axios from './../../../axios';

    export default {
        props:['data'],
        data(){
            return {
                is_loading: false,
                error: {rent: null},
                rent: null, //user input rent
                fully_paid: false
            }
        },
        computed:{
            //Convert rent due day to a propert date
            rentDue(){
                var rent_date = new Date();
                rent_date.setDate(this.data.rent_due);
                return rent_date;
            }
        },
        methods:{
            async add(){
                this.is_loading = true;
                try {
                    // let data = {...this.fields};
                    // data.unit_id = this.unit_id;
                    // const res = await axios.post('/tenant/store', data);
                    this.$emit('update', data);
                    this.$emit('close');
                } catch (err) {
                    this.error = err.response?.data?.errors
                }
                this.is_loading = false;
            },
            fullyPaid(){
                if (this.fully_paid) {
                    this.rent = this.data.rent;
                }
            }
        }
    }
</script>

<style>

</style>
