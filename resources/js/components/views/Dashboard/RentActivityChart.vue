<template>
  <div ref="rent_activity"></div>
</template>

<script>
    import axios from './../../../axios';

export default {
    data(){
        return {
            data: null
        }
    },
    async mounted(){
        const res = await axios.get('/rent/activity');
        this.rent.pending_activity = res.data;
        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'sales',
                data: [30,40,35,50,49,60,70,91,125]
            }],
            xaxis: {
                categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
            }
        }

        var chart = new ApexCharts(this.$refs.rent_activity, options);

        chart.render();
    }
}
</script>

<style>

</style>
