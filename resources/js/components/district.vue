<template>
    <div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Quận</label>
            <div class="col-md-6">
                <select class="custom-select" name="district" v-model="district" @change="change()">
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
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Phường</label>
            <div class="col-md-6">
                <select class="custom-select" name="province" v-model="province" @change="$emit('select-change', {type: 'province', value: province})">
                    <option>Tất cả</option>
                    <option v-for="p in provinces" :key="p.index" >{{ p.province }}</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        oldDistrict: String,
        oldProvince: String,
    },
    data(){
        return{
            provinces: [],
            district: 'Tất cả',
            province: 'Tất cả',
        }
    },
    mounted(){
        if(this.oldDistrict){
            this.district = this.oldDistrict;
            this.change().then(
                (response) => {
                    if(this.oldProvince){
                        this.province = this.oldProvince;
                    }
                }
            )
            .catch(
                (error) => {
                    console.log(error);
                }
            );
            
        }
    },
    methods:{
        change(){
            this.$emit('select-change', {type: 'district', value: this.district});
            return axios.get("/getprovince/" + this.district)
            .then(
                (response) => {
                    this.provinces = response.data;
                    this.province = 'Tất cả';
                }
            )
            .catch(
                (error) => {
                    console.log(error);
                }
            );
        }
    }
}
</script>