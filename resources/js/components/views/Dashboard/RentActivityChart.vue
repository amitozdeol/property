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
                chart: { type: 'bar' },
                title: { text: 'Latest rent activity' },
                plotOptions: { bar: { dataLabels: { position: 'top' } } },
                dataLabels: {
                    enabled: false,
                },
                tooltip: {
                    x: {show: false},
                    y: {
                        formatter: (value, { series, seriesIndex, dataPointIndex, w }) => {
                            const raw_date = w.config.series[seriesIndex].data[dataPointIndex].raw_date;
                            return `$${value}, ${this.$options.filters.formatDate(raw_date, 'dd-MMM-YYYY HH:mm')}`;
                        }
                    }
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
             * Get chart data, format it and re-render the chart
             */
            async getData(){
                const res = await axios.get('/rent/activity'),
                    chart_data = [],
                    tenant_names = Object.keys(res.data);
                Object.values(res.data).forEach((d, index) => {
                    chart_data.push({
                        name: tenant_names[index],
                        data: d.map(e => { return {x: this.$options.filters.formatDate(e.created_at), y: e.value, raw_date: e.created_at}})
                    });
                });
                this.chart.updateSeries(chart_data);
            }
        }
    }
</script>

<style>

</style>
