<template>
    <div>
        <span>Quận:</span><select class="custom-select" ref="district" name="district" @change="change()">
        <option>Tất cả</option>
        <option>Hoàn Kiếm</option>
        <option>Đống Đa</option> 
        <option style="color: green">Ba Đình</option>
        <option>Hai Bà Trưng</option> 
        <option>Hoàng Mai</option>
        <option>Thanh Xuân</option>
        <option>Long Biên</option>
        <option>Nam Từ Liêm</option>
        <option>Bắc Từ Liêm</option>
        <option style="color: orange">Tây Hồ</option>
        <option>Cầu Giấy</option>
        <option> Hà Đông</option>
    </select>
    <br> 
    <span>Phường:</span><select class="custom-select" ref="province" name="province">
        <option>Tất cả</option>
        <option :key="p.index" v-for="p in provinces">{{p.province}}</option>
        </select>
    </div>
</template>
<script>
export default {
    data:()=>{
        return{
            provinces:{}
        }
    },
    methods:{
        change(){
            /*
            const req= new XMLHttpRequest();
            req.onreadystatechange=()=>{
                if(req.readyState==4&&req.status==200){
                    document.write(req.status+"<br/>");
                    document.write(req.responseText);
                }
            }
            req.open("GET",
            "http://localhost/lostintaste/public/getprovince?district="+
            this.$refs.district.value,true);
            req.send();
            */
            axios.get("/lostintaste/public/getprovince?district="+this.$refs.district.value)
            .then(
                (provincesresponse)=>{
                    //console.log("resolved:"+JSON.stringify(response.data));
                    this.provinces=provincesresponse.data;
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
}
</script>