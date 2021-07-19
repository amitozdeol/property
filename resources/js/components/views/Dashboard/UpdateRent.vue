<template>
    <form action="">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Update Rent</p>
                <button type="button" class="delete" @click="$emit('close')" />
            </header>
            <section v-if="tenant.rent_activity.length == 0" class="modal-card-body columns mb-0">
                <div class="column is-mobile is-half">
                    <ul class="is-size-7">
                        <li class="is-size-6">Rent remaining: <strong class="has-text-primary">${{tenant.rent}}</strong></li>
                        <li>Name: <strong>{{tenant.name |capitalize}}</strong></li>
                        <li>Email: <strong>{{tenant.email}}</strong></li>
                        <li>Due due: <strong>{{rentDue | formatDate}}</strong></li>
                    </ul>
                </div>
                <div class="column is-mobile is-half">
                    <b-field label="Rent" :type="{'is-danger': (error.rent)}" :message="error.rent" label-position="on-border">
                        <b-input placeholder="$500"
                                type="number"
                                v-model.number="rent"
                                min="1"
                                :max="tenant.rent"
                                step="0.01"
                                :disabled="fully_paid == 'Yes'">
                        </b-input>
                    </b-field>
                    <label class="b-checkbox checkbox">
                        <input type="checkbox"
                            autocomplete="on"
                            true-value="Yes"
                            false-value="No"
                            v-model="fully_paid"
                            @change="fullyPaid()">
                        <span class="check"></span>
                        <span class="control-label"> Fully Paid </span>
                    </label>
                </div>
            </section>
            <section v-else class="modal-card-body mb-0">
                <div v-for="(activity, index) in tenant.rent_activity" :key="activity.id" class="columns">
                    <div class="column is-mobile is-half">
                        <ul class="is-size-7">
                            <li class="is-size-6">Rent remaining: <strong class="has-text-primary">${{activity.remaining}}</strong></li>
                            <li>Name: <strong>{{tenant.name |capitalize}}</strong></li>
                            <li>Email: <strong>{{tenant.email}}</strong></li>
                            <li>Due due: <strong>{{activity.rent_month | formatDate(false)}}</strong></li>
                        </ul>
                    </div>
                    <div class="column is-mobile is-half">
                        <b-field label="Rent"
                                :type="{'is-danger': (error[index] ? error[index].rent_paid : false)}"
                                :message="error[index] ? error[index].rent_paid: ''"
                                label-position="on-border">
                            <b-input placeholder="$500"
                                    type="number"
                                    min="1"
                                    :max="activity.remaining"
                                    step="0.01"
                                    v-model="rent_activity[index].rent_paid"
                                    :disabled="rent_activity[index].fully_paid == 'Yes'">
                            </b-input>
                        </b-field>
                        <label class="b-checkbox checkbox">
                            <input type="checkbox"
                                autocomplete="on"
                                true-value="Yes"
                                false-value="No"
                                v-model="rent_activity[index].fully_paid"
                                @change="rent_activity[index].fully_paid == 'Yes' ? rent_activity[index].rent_paid = activity.remaining : ''">
                            <span class="check"></span>
                            <span class="control-label"> Fully Paid </span>
                        </label>
                    </div>
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
        props:['tenant'],
        data(){
            return {
                is_loading: false,
                error: {rent: null},
                fully_paid: false,
                rent: [], //user input rent
                rent_activity: this.tenant.rent_activity
            }
        },
        computed:{
            //Convert rent due day to a propert date YYYY-MM-DD
            rentDue(){
                var now = new Date();
                var rent_date = new Date();
                rent_date.setDate(this.tenant.rent_due);

                // next month
                if (this.tenant.rent_due < now.getDate()) {
                    rent_date.setMonth(rent_date.getMonth()+1);
                }
                return rent_date;
            }
        },
        methods:{
            /**
             * Submit the form
             */
            async submit(){
                this.is_loading = true;
                try {
                    const res = await axios.post(`/rent/${this.tenant.id}`, this.rent_activity);
                    this.$emit('reload');
                    this.$emit('close');
                } catch (err) {
                    this.error = err.response?.data?.errors
                }
                this.is_loading = false;
            },
        }
    }
</script>

<style>

</style>
