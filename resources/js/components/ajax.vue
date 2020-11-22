<template>
    <div ref="response"></div>
</template>
<script>
export default {
    props:["input"],
    data:()=>{
        return{
            url:"",
            response:{}
        }
    },
    beforeCreate(){
        //console.log(this.$options.propsData.input);
        axios.get(this.$options.propsData.input)
        .then(
            (response)=>{
                //console.log("resolved:"+JSON.stringify(response.data));
                this.$refs.response.innerHTML=response.data;
                this.response=response.data;
                this.$emit('emitresponse', this.response);
                //console.log(this.$refs.response.innerHTML);
            }
        )
        .catch(
            (error)=>{
                //this.$refs.divshow.innerHTML=error;
                console.log(error);
            }
        )
    }
}
</script>