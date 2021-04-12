<template>
    <div class="grid cursor-move" @click="chosen">
        <div class="row height-33">
            <div class="col"></div>
            <div class="col" :class="open[0] ? 'pipe pipe-top ' + pipeColor() : ''">&nbsp;</div>
            <div class="col"></div>
        </div>
        <div class="row height-33">
            <div class="col" :class="open[3] ? 'pipe pipe-left ' + pipeColor() : ''">&nbsp;</div>
            <div class="col center"><i class="fas fa-sync cursor-pointer" @click="spin()"></i></div>
            <div class="col" :class="open[1] ? 'pipe pipe-right ' + pipeColor() : ''">&nbsp;</div>
        </div>
        <div class="row height-33">
            <div class="col"></div>
            <div class="col" :class="open[2] ? 'pipe pipe-bottom ' + pipeColor() : ''">&nbsp;</div>
            <div class="col"></div>
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
            if(event.target.isEqualNode(document.querySelector('.fas.fa-sync'))) return;
            this.$emit('chosen', this.position);
        },
        pipeColor(){
            return this.isChosen ? 'pipe-glow' : this.flow.includes(1) ? 'pipe-red' : 'pipe-grey';
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
    .center{
        display: flex;
        align-self: center;
        justify-content: center;
    }
    .row{
        margin: auto;
        flex-wrap: nowrap;
    }
    .col{
        padding: 0;
    }
    .height-33{
        height: 33%;
    }
    .cursor-move{
        cursor: move;
    }
    .cursor-pointer{
        cursor: pointer;
    }
    .pipe::before{
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-size: contain;
    }
    .pipe-grey::before{
        background-image: url('/picture/heartcrush/pipe-grey.png');
    }
    .pipe-red::before{
        background-image: url('/picture/heartcrush/pipe-red.png');
    }
    .pipe-glow::before{
        background-image: url('/picture/heartcrush/pipe-glow.png');
    }

    .pipe-left::before{
        transform: rotate(-90deg);
    }
    .pipe-right::before{
        transform: rotate(90deg);
    }
    .pipe-bottom::before{
        transform: rotate(180deg);
    }
</style>