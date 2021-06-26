<template>
    <section>
        <Header title="Create new property" subtitle="Add property details here"
            :breadcrumb="['Dashboard:/', 'Property:/property', 'Create Property:/property/create']" />

        <div class="columns">
            <div class="column">
                <b-field label="Name" :type="error.name ? 'is-danger': 'is-white'" :message="error.name || ''">
                    <b-input placeholder="Name" v-model="input.name" type="text" max="200" required></b-input>
                </b-field>

                <b-field label="Address" :type="error.address ? 'is-danger': 'is-white'" :message="error.address || ''">
                    <b-input placeholder="Ex: 123 Street name" v-model="input.address" type="text" min="5" max="200"
                        required></b-input>
                </b-field>
                <b-field label="City" :type="error.city ? 'is-danger': 'is-white'" :message="error.city || ''">
                    <b-input placeholder="Ex: Colorado" v-model="input.city" type="text" required></b-input>
                </b-field>
            </div>
            <div class="column">
                <b-field label="State" :type="error.state ? 'is-danger': 'is-white'" :message="error.state || ''">
                    <b-input placeholder="Ex: NY" v-model="input.state" type="text" required></b-input>
                </b-field>

                <b-field label="Zip" :type="error.zip ? 'is-danger': 'is-white'" :message="error.zip">
                    <b-input placeholder="Ex: 12345" type="number" v-model.number="input.zip" min="1" max="999999"
                        required></b-input>
                </b-field>
            </div>
        </div>

        <div class="page-header">
            <div class="is-flex is-align-items-center">
                <h3 class="title is-4 mb-0 mr-2">Add Units</h3>
                <b-button rounded type="is-success" size="is-small" @click="openUnitModal">Add</b-button>
            </div>
            <p class="has-text-grey">A property can have multiple units. If no unit is provided, a unit will get created for you.</p>
        </div>
        <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
            <div v-for="(unit, index) in units" :key="index" class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                <AddUnit :unit="unit"
                    :index="index"
                    :address="`${input.address}, ${input.city}, ${input.state}, ${input.zip}`"
                    :error="typeof error.units[index] === 'undefined' ? {} : error.units[index]"
                    v-on:update="addUnit($event)"
                    v-on:destroy="deleteUnit($event)"/>
            </div>
        </div>
        <b-button type="is-primary" native-type="submit" :disabled="!is_validated" :loading="is_loading"
            @click="submit">Submit</b-button>
    </section>
</template>
<script>
    import axios from '../../../axios';
    import Header from '../../Header.vue';
    import AddUnit from './AddUnit.vue';

    export default {
        data() {
            const unit_template = {unit: null, rent: null, size: null, address: null};
            return {
                input: {
                    name: null,
                    address: null,
                    city: null,
                    state: null,
                    zip: null
                },
                unit_template,
                units: [unit_template],
                error: {units: []},
                is_loading: false
            }
        },
        computed: {
            is_validated() {
                return this.input.name && this.input.address && this.input.city && this.input.state && this.input.zip;
            }
        },
        components: {
            Header,
            AddUnit
        },
        methods: {
            async submit() {
                if (this.is_validated) {
                    this.is_loading = true;
                    try {
                        if (this.units.length == 0) {
                            this.units.push(this.defaultUnit());
                        }
                        this.input.units = this.units;
                        const res = await axios.post('/property/store', this.input);
                        this.$router.push({
                            name: 'property'
                        });
                    } catch (err) {
                        this.error = err.response?.data?.errors
                    }
                    this.is_loading = false;
                }
            },
            //If no unit is provided, just create a new one
            defaultUnit(){
                return {
                    unit: this.input.name,
                    size: 1000,
                    rent: 500,
                    address: `${this.input.address}, ${this.input.city}, ${this.input.state}, ${this.input.zip}`
                }
            },
            openUnitModal(){
                this.units.push({...this.unit_template});
            },
            addUnit(unit, index){
                this.units[index] = unit;
            },
            deleteUnit(index){
                this.units.splice(index, 1);
            },
        }
    }
</script>

<style>

</style>
