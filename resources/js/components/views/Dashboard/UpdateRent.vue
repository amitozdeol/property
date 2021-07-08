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
                        <li class="is-size-6">Rent: <strong class="has-text-primary">${{data.rent}}</strong></li>
                        <li>Name: <strong>{{data.name |capitalize}}</strong></li>
                        <li>Email: <strong>{{data.email}}</strong></li>
                        <li>Rent due: <strong>{{rentDue | formatDate}}</strong></li>
                    </ul>
                </div>
                <div class="column is-mobile is-half">
                    <b-field label="Rent" :type="{'is-danger': (error.rent)}" :message="error.rent" label-position="on-border">
                        <b-input placeholder="$500"
                                type="number"
                                v-model.number="rent"
                                min="1"
                                :max="data.rent"
                                step="0.01"
                                :disabled="fully_paid == 'Yes'">
                        </b-input>
                    </b-field>
                    <label class="b-checkbox checkbox">
                        <input type="checkbox" autocomplete="on" true-value="Yes" false-value="No" v-model="fully_paid" @change="fullyPaid()">
                        <span class="check"></span>
                        <span class="control-label"> Fully Paid </span>
                    </label>
                </div>
            </section>
            <footer class="modal-card-foot is-justify-content-end">
                <b-button label="Close" @click="$emit('close')" />
                <b-button label="Save" type="is-success" @click="submit()" :disabled="is_loading" :loading="is_loading"/>
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
                fully_paid: false,
                rent: null, //user input rent
            }
        },
        computed:{
            //Convert rent due day to a propert date YYYY-MM-DD
            rentDue(){
                var now = new Date();
                var rent_date = new Date();
                rent_date.setDate(this.data.rent_due);

                // next month
                if (this.data.rent_due < now.getDate()) {
                    rent_date.setMonth(rent_date.getMonth()+1);
                }
                return rent_date;
            }
        },
        methods:{
            async submit(){
                this.is_loading = true;
                try {
                    const res = await axios.post(`/rent/${this.data.id}`, {
                        rent_month: this.rentDue,
                        value: this.rent,
                    });
                    // this.$emit('update', data);
                    this.$emit('close');
                } catch (err) {
                    this.error = err.response?.data?.errors
                }
                this.is_loading = false;
            },
            fullyPaid(){
                this.rent = this.fully_paid ? this.data.rent : null;
            }
        }
    }
</script>

<style>

</style>
