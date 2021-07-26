<template>
  <div ref="rent_activity"></div>
</template>

<script>
    import axios from './../../../axios';

export default {
    data(){
        return {
            chart: null
        }
    },
    mounted(){
        var options = {
            chart: {
                type: 'line'
            },
            series: [],
            noData: {
                text: "Loading...",
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
            },
        };

        this.chart = new ApexCharts(this.$refs.rent_activity, options);
        this.chart.render();
        this.getData();
    },
    methods: {
        /**
         * get chart data and re-render it
         */
        async getData(){
            const res = await axios.get('/rent/activity');

            this.chart.updateSeries([{
                name: 'Sales',
                data: res.data.map(e => { return {x: e.created_at, y: e.value}})
            }]);
        }
    }
}
</script>

<style>

</style>
