<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full">
        </div>
        <div class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 rounded-lg shadow-lg mt-4">
            <div class="current-weather flex items-center justify-between px-6 py-8">
                <div class="flex items-center">
                    <div>
                        <div class="text-6xl font-semibold">{{ currentTemperature.actual }}°C</div>
                        <div>Feels like {{ currentTemperature.feels }}°C</div>
                    </div>
                    <div class="mx-5">
                        <div class="font-semibold">{{ currentTemperature.summary }}</div>
                        <div>{{ location.name }}</div>
                    </div>
                </div>
                <div>icon</div>
            </div><!--end current-weather-->

            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div
                    v-for="(day, index) in daily"
                    :key="day.date"
                    class="flex items-center"
                    :class="{ 'mt-8' : index > 0 }"
                 >
                    <div class="w-1/6 text-lg text-gray-200">{{ toDayOfWeek(day.date_epoch) }}</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div>icon</div>
                        <div class="ml-3">{{ day.day.condition.text }}</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>{{ day.day.maxtemp_c }}°C</div>
                        <div>{{ day.day.mintemp_c }}°C</div>
                    </div>
                </div>

            </div><!--end future-weather-->

        </div><!--end weather-container-->
    </div>
</template>

<script>
export default {
    mounted() {
        this.fetchData()
    },
    data(){
        return {
            currentTemperature:{
                actual:'',
                feels:'',
                summary:'',
                icon:'',
            },
            daily:[],
            location:{
                name: 'Skopje, Macedonia',
                lat:41.99646,
                lng:21.43141,
            }
        }
    },
    methods:{
        fetchData() {
            fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    this.currentTemperature.actual = data.current.temp_c
                    this.currentTemperature.feels = data.current.feelslike_c
                    this.currentTemperature.summary = data.current.condition.text
                    this.currentTemperature.icon = data.current.condition.icon
                    
                    this.daily = data.forecast.forecastday
                })
        },
        toDayOfWeek(timestamp) {
            const newDate = new Date(timestamp*1000);
            const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

            return days[newDate.getDay()]
        }
    }
}
</script>