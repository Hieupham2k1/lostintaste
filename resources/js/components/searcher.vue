<template>
    <div>
        <span>Loại:</span><select class="custom-select" ref="kind" name="kind">
        <option>Tất cả</option>
        <option>Đồ Uống</option>
        <option>Đồ ăn mặn</option>
        <option>Đồ ăn ngọt</option>
        <option>Địa điểm vui chơi</option>
        <option>Review</option>
        </select>
        <br>
        <span>Giá dưới:</span>
        <input type="text" name="price" ref="price" 
        style="width:15%" value="1000"><span>000 VND</span>
        <br>
        <district ref="districtcomp"></district>
        <br>
        <button @click="search()" class="btn btn-outline-danger">Search</button>
        <div ref="divshow">
            
            <div :key="food.index" v-for="food in foods">
                <br>
                <div class="card">
                    <img class="card-img-top" 
                    :src=food.picture width="100%" height="100%">
                    <div class="card-body">
                        <h2>Tên: {{food.name}}</h2><br>
                        <div>Loại: {{food.kind}}</div><br>
                        <div>Giá: {{food.price}}000 VND</div><br><br>
                        <span>Quận: {{food.district}},</span>
                        <span>Phường: {{food.province}}</span><br><br>
                        <div>Địa chỉ: {{food.address}}</div><br>
                        <b> Uploader:
                            <img :src=food.user.info.avatar width="10%" height="10%"
                            style="border-radius: 50% 50% 50% 50%">
                            <a :href="'profile/'+food.user.id">
                                {{food.user.name}}
                            </a>
                        </b> 
                        <p>at {{food.updated_at}}</p>
                        <div class="row">
                            <div class="col">
                                <button :id="'save-'+food.id" 
                                @click="save(food.id)" 
                                class="btn btn-outline-primary">
                                Save</button>
                            </div>
                            <div class="col">
                                <a :href="'newschedule/'+food.id" style="text-decoration: none">
                                <button class="btn btn-outline-primary">Schedule</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
            </div>
        </div>
    </div>
</template> 
<script>
import district from './district.vue'
export default {
    components:{
        district
    },
    data:()=>{
        return {
            id:1,
            url:"",
            foods:{}
        }
    },
    methods:{
        search(){
            this.url="getfood?kind="+this.$refs.kind.value+
            "&price="+this.$refs.price.value+
            "&district="+this.$refs.districtcomp.$refs.district.value+
            "&province="+this.$refs.districtcomp.$refs.province.value;
            axios.get(this.url)
            .then(
                (response)=>{
                    //this.$emit('dataupdate', response.data);
                    this.foods=response.data;
                    //this.$refs.divshow.innerHTML=JSON.stringify(response.data);
                    //console.log("resolved:"+JSON.stringify(response.data));
                }
            )
            .catch(
                (error)=>{
                    //this.$refs.divshow.innerHTML=error;
                    console.log(error);
                }
            )
        },
        save(id){
            document.getElementById("save-"+id).innerHTML="Đã Save";
            axios.get("/lostintaste/public/newsavedpost/"+id)
            .then(
                (response)=>{
                    if(JSON.stringify(response.data).length>16)
                    alert("Bạn đã lưu bài này rồi");
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
    }
}
</script>