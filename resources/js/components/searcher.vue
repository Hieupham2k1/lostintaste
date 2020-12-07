<template>
    <div>
        <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Loại</label>
                <div class="col-md-6">
                    <select class="custom-select" v-model="kind">
                        <option>Tất cả</option>
                        <option>Đồ Uống</option>
                        <option>Đồ ăn mặn</option>
                        <option>Đồ ăn ngọt</option>
                        <option>Địa điểm vui chơi</option>
                        <option>Review</option>
                    </select>
                </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Giá (000 VND)</label>
            <div class="col-md-6">
                <input v-model="price" type="number" class="col form-control" />
            </div>
        </div>

        <District @select-change="selectChange($event)" />
        <hr>
        <button @click="search()" class="btn btn-outline-danger">Search</button>
        <Post 
            v-for="data in foods" 
            :key="data.id" 
            :propdata="data"
            page="post" 
        />
    </div>
</template> 
<script>
import District from './district.vue'
import Post from './post.vue'
export default {
    components:{
        District,
        Post
    },
    data:()=>{
        return {
            kind: 'Tất cả',
            price: 1000,
            district: 'Tất cả',
            province: 'Tất cả',
            foods:{}
        }
    },
    methods:{
        search(){
            var url = "getfood?kind=" + this.kind+
            "&price=" + this.price+
            "&district=" + this.district+
            "&province=" + this.province;
            axios.get(url)
            .then(
                (response) => {
                    this.foods=response.data;
                }
            )
            .catch(
                (error) => {
                    console.log(error);
                }
            )
        },
        selectChange(event){
            this[event.type] = event.value;
        },
    }
}
</script>