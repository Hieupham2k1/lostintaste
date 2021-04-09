<template>
    <div class="grid cursor-move" :class="{ 'text-success': isChosen, 'text-danger': flow.includes(1) && !isChosen, }" @click="chosen">
        <div class="row">
            <div class="col"></div><div class="col">{{ open[0] }}</div><div class="col"></div>
        </div>
        <div class="row">
            <div class="col">{{ open[3] }}</div><div class="col cursor-pointer" @click="spin()">@</div><div class="col">{{ open[1] }}</div>
        </div>
        <div class="row">
            <div class="col"></div><div class="col">{{ open[2] }}</div><div class="col"></div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        position: Array,
    },
    data(){
        return {
            open: [],
            flow: [0, 0, 0, 0],
            isChosen: false,
        }
    },
    methods:{
        spin(){
            if(this.$parent.isUnmovable(this.position)) return;
            let temp = this.open.pop();
            this.open.unshift(temp);
            
            this.emitChangeFlow();
        },
        emitChangeFlow(){
            this.$emit('changeFlow', this.position);
        },
        chosen(event){
            if(event.target.isEqualNode(document.querySelector('div.col.cursor-pointer'))) return;
            this.$emit('chosen', this.position);
        }
    },
    created(){
        if(this.position[0] == this.position[1] && this.position[0] == 1){
            this.open = [0, 1, 0, 0];
            this.flow = [1, 0, 0, 1]; // flow must not come from other cells
            return;
        }
        if(this.position[0] == this.position[1] && this.position[0] == this.$parent.width){
            this.open = [0, 0, 0, 1];
            return;
        }
        for(let i = 0; i < 4; i++){
            this.open.push(parseInt(Math.random() * 100) % 2);
        }
    }
}
</script>

<style>
    .grid{
        width: 100px;
        height: 100px;
        border: 1px solid;
    }
    .cursor-move{
        cursor: move;
    }
    .cursor-pointer{
        cursor: pointer;
    }
</style>