<template>
    <div class="row justify-content-center">
        <div>
            <div class="row" v-for="h in width" :key="h">
                <Cell 
                    v-for="w in width" :key="w" 
                    :position="[h, w]"
                    @changeFlow="changeFlow"
                    :ref="'cell-' + h + '-' + w"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Cell from './Cell.vue'
export default {
    components:{
        Cell,
    },
    data(){
        return {
            width: 10,
        }
    },
    methods:{
        changeFlow(event){
            let { position, open } = event;
            let refNames = [
                `cell-${ position[0] - 1 }-${ position[1] }`,
                `cell-${ position[0] }-${ position[1] + 1 }`,
                `cell-${ position[0] + 1 }-${ position[1] }`,
                `cell-${ position[0] }-${ position[1] - 1 }`,
            ];

            let currentCell = this.$refs[`cell-${ position[0] }-${ position[1] }`]?.[0];

            for(let i in refNames){
                let neighborCell = this.$refs[refNames[i]]?.[0];
                if(!neighborCell) continue;

                let int = parseInt(i);
                let opositeSide = (int >= 2) ? int - 2 : int + 2;

                currentCell.flow[i] = (
                    neighborCell.flow.includes(1) & // if neighbor cell has flow
                    neighborCell.flow[opositeSide] != 1 & // but not from current cell
                    neighborCell.open[opositeSide] & open[i] // and neighbor cell conects with current cell
                ); // then current cell has flow, else not
            }
            for(let i in refNames){
                let neighborCell = this.$refs[refNames[i]]?.[0];
                if(!neighborCell) continue;

                let int = parseInt(i);
                let opositeSide = (int >= 2) ? int - 2 : int + 2;

                let neighborHadFlow = neighborCell.flow.includes(1);

                neighborCell.flow[opositeSide] = ( // similar as above
                    currentCell.flow.includes(1) & 
                    currentCell.flow[i] != 1 & 
                    open[i] & neighborCell.open[opositeSide]
                );
                neighborCell.$forceUpdate();

                if(neighborHadFlow != neighborCell.flow.includes(1)){ // if neighbor cell change state of hasFlow
                    neighborCell.emitChangeFlow();
                }
            }
        },
    },
    created(){
        
    },
    mounted(){
        this.$refs['cell-1-2'][0].emitChangeFlow();
        this.$refs['cell-1-2'][0].$forceUpdate();
    }
}
</script>

<style>

</style>