<template>
    <div class="card">
        <header class="card-header">
            <p class="card-header-title is-justify-content-space-between">
                <span>Unit {{index+1}}</span>
                <b-button type="is-danger" size="is-small" rounded @click="destroy()">Delete</b-button>
            </p>
        </header>
        <div class="card-content">
            <div class="content columns mb-0">
                <div class="column">
                    <b-field label="Number/Name" :type="{'is-danger': (error.unit)}" :message="error.unit || ''">
                        <b-input placeholder="Number/Name" v-model="unit.unit" type="text" max="200" required></b-input>
                    </b-field>
                    <b-field label="Rent" :type="{'is-danger': (error.rent)}" :message="error.rent">
                        <b-input placeholder="$500" type="number" v-model.number="unit.rent" min="1" max="99999" step="0.01">
                        </b-input>
                    </b-field>
                </div>
                <div class="column">
                    <b-field label="Size(Optional)" :type="{'is-danger': (error.size)}" :message="error.size">
                        <b-input placeholder="sq. ft." type="number" v-model.number="unit.size" min="1" max="99999">
                        </b-input>
                    </b-field>
                    <b-field label="Deposit" :type="{'is-danger': (error.deposit)}" :message="error.deposit">
                        <b-input placeholder="$500" type="number" v-model.number="unit.deposit" min="1" max="99999" step="0.01">
                        </b-input>
                    </b-field>
                </div>
            </div>
            <b-field :type="{'is-danger': (error.address)}" :message="error.address || ''" custom-class="is-flex is-align-items-center">
                <template #label>
                    Address
                    <b-button type="is-ghost" size="is-small" rounded @click="unit.address = address">Same as above</b-button>
                </template>

                <b-input placeholder="Ex: 123 Street name, City, State, zip" v-model="unit.address" type="text"
                    min="5" max="500" required></b-input>
            </b-field>
        </div>
    </div>
</template>

<script>
    export default {
        props:['unit', 'address', 'index', 'error'],
        watch:{
            unit: {
                handler(val){
                    this.$emit('update', val, this.index);
                },
                deep: true
            }
        },
        methods:{
            destroy(){
                this.$emit('destroy', this.index);
            }
        }
    }
</script>

<style>

</style>
