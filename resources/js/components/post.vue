<template>
    <div class="card">
        <img class="card-img-top" :src="data.picture" width="100%" height="100%" />
        <div class="card-body">
            <h2>Tên: {{ data.name }}</h2><br>
            <div>Loại: {{ data.kind }}</div><br>
            <div>Giá: {{ data.price }} 000 VND</div><br><br>
            <span>Quận: {{ data.district }}, </span>
            <span>Phường: {{ data.province }}</span><br><br>
            <div>Địa chỉ: {{ data.address }}</div><br>
            <b> Đăng bởi:
                <img :src="data.user.info.avatar" width="10%" height="10%"
                style="border-radius: 50% 50% 50% 50%" />
                <a :href="'/lostintaste/profile/'+data.user.id">
                    {{ data.user.name }}
                </a>
            </b> 
            <p>lúc {{ data.updated_at.substring(0, data.updated_at.indexOf('T')) }}</p>
            <!-- người tham gia schedule -->
            <div v-if="page == 'schedule' || page == 'news'">
                <div><b>Thời gian:</b> {{ propdata.time }}</div>
                <br>
                <div><b>Schedule for:</b> {{ propdata.mode }}</div>
                <br>
                Người tham gia:<br>
                <div v-for="attendee in propdata.attendee" :key="attendee.id">
                    <a :href="'/lostintaste/profile/'+attendee.user.id">
                        {{ attendee.user.name }}
                    </a>
                </div>
            </div>
            <!-- btn actions -->
            <div class="row">
                <!-- nút Save -->
                <div class="col" v-if="page != 'savedpost'">
                    <button
                    @click="save(data.id)" 
                    class="btn btn-outline-primary"
                    >{{ (!isSaved) ? 'Save' : 'Đã Save' }}</button>
                </div>
                <!-- nút Hiển thị -->
                <div class="col" v-if="page == 'savedpost'">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hiển thị với: {{ propdata.mode }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item" :href="'/lostintaste/update/savedpost/' + propdata.id + '/all'">Tất cả</a>
                            <a class="dropdown-item" :href="'/lostintaste/update/savedpost/' + propdata.id + '/only'">Chỉ mình tôi</a>
                        </div>
                    </div>
                </div>
                <!-- nút Update -->
                <div class="col" v-if="page != 'news' && page != 'profile'">
                    <div class="dropdown">
                        <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Update
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a :href="'/lostintaste/delete/' + page + '/' + propdata.id" style="text-decoration: none">
                                <button class="btn btn-outline-danger">Delete</button>
                            </a>
                            <a :href="'/lostintaste/update/' + page + '/' + propdata.id" style="text-decoration: none" 
                            v-if="page == 'post' || page == 'schedule'">
                                <button class="btn btn-outline-success">Update</button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- nut schedule -->
                <div class="col" v-if="page == 'post' || page == 'savedpost' || page == 'profile'">
                    <a :href="'/lostintaste/newschedule/' + data.id" class="btn btn-outline-primary">Schedule</a>
                </div>
                <!-- nút Tham gia -->
                <div class="col" v-if="page == 'news'">
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ (!isAttended) ? 'Tham gia' : 'Đã tham gia' }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button @click="attend(propdata.id)"
                                class="btn btn-outline-danger">
                                    Chắc chắn?
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        propdata: Object,
        page: String,
    },
    data(){
        return {
            data: {},
            isSaved: false,
            isAttended: false,
        }
    },
    created(){
        this.data = (this.page == 'post' || this.page == 'profile') ? this.propdata : this.propdata.post;
    },
    methods:{
        save(id){
            if(this.isSaved){
                alert("Bạn đã lưu bài này rồi");
                return;
            }
            axios.get("/lostintaste/newsavedpost/"+id)
            .then(
                (response)=>{
                    this.isSaved = true;
                    // cần tối ưu
                    (response.data == 0) ? alert("Bạn đã lưu bài này rồi") : '';
                }
            )
            .catch(
                (error)=>{
                    (error.response.status == 401) ? window.location.href = 'login' : '';
                    console.log(error.response);
                }
            )
        },
        attend(id){
            if(this.isAttended){
                alert("Bạn đã tham gia rồi");
                return;
            }
            axios.get("/lostintaste/attend/"+id)
            .then(
                (response)=>{
                    this.isAttended = true;
                    // cần tối ưu
                    (response.data == 0) ? alert("Bạn đã tham gia rồi") : '';
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        },
    }
}
</script>

<style>

</style>