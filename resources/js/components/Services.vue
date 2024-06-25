<template>
    <div>
        {{ services }}
    </div>
</template>

<script>
import axios from "axios";
    export default {
        name:'Services',
        props:{
            onlymine:{
                type:Boolean,
                default:true
            }
        },
        data() {
            return {
                services: null
            }
        },
        beforeMount(){

            this.getServices(this.onlyMine)
            
        },
        methods: {
            getServices(onlyMine){
                const self = this;
                axios.get('/home/services').then((res)=>{
                    self.services = res.data.data
                })
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>